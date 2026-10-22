<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Rentang harga (juta rupiah). Dipakai lagi di Step 4 (rekomendasi).
    const PRICE_RANGES = [
        '0-2'   => ['< Rp2 juta', 0, 2000000],
        '2-5'   => ['Rp2–5 juta', 2000000, 5000000],
        '5-10'  => ['Rp5–10 juta', 5000000, 10000000],
        '10-20' => ['Rp10–20 juta', 10000000, 20000000],
        '20+'   => ['> Rp20 juta', 20000000, null],
    ];

    // /produk
    public function index(Request $request)
    {
        return $this->listing($request, Product::query(), [
            'category' => null, 'brand' => null,
        ]);
    }

    // /produk/{category}
    public function category(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return $this->listing($request, Product::where('category_id', $category->id), [
            'category' => $category, 'brand' => null,
        ]);
    }

    // /brand/{slug}
    public function brand(Request $request, string $slug)
    {
        $brand = Brand::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return $this->listing($request, Product::where('brand_id', $brand->id), [
            'category' => null, 'brand' => $brand,
        ]);
    }

    // /produk/{category}/{product}
    public function show(string $categorySlug, string $slug)
    {
        $product = Product::with(['category', 'brand', 'images', 'related.category', 'related.brand'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->whereHas('category', fn ($q) => $q->where('slug', $categorySlug))
            ->firstOrFail();

        $similar = Product::with(['category', 'brand'])
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderByDesc('is_best_seller')->orderBy('sort_order')
            ->take(4)->get();

        return view('products.show', [
            'product' => $product,
            'related' => $product->related->where('is_active', true),
            'similar' => $similar,
        ]);
    }

    private function listing(Request $request, $query, array $context)
    {
        $query->with(['category', 'brand'])->where('is_active', true);

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('sku', 'like', "%{$q}%");
            });
        }

        if (! $context['brand'] && $request->filled('brand')) {
            $query->whereHas('brand', fn ($b) => $b->where('slug', $request->query('brand')));
        }

        if ($range = self::PRICE_RANGES[$request->query('harga')] ?? null) {
            $query->whereNotNull('price')->where('price', '>=', $range[1]);
            if ($range[2]) {
                $query->where('price', '<', $range[2]);
            }
        }

        match ($request->query('urut')) {
            'harga-rendah' => $query->orderByRaw('price is null')->orderBy('price'),
            'harga-tinggi' => $query->orderByDesc('price'),
            'nama'         => $query->orderBy('name'),
            default        => $query->orderByDesc('is_best_seller')->orderBy('sort_order'),
        };

        return view('products.index', $context + [
            'products'   => $query->paginate(12)->withQueryString(),
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'brands'     => Brand::where('is_active', true)->get(),
            'ranges'     => self::PRICE_RANGES,
        ]);
    }
}