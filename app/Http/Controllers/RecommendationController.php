<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    const USAGES = [
        'rumah-baru' => 'Rumah baru', 'renovasi' => 'Renovasi kamar mandi', 'hotel' => 'Bathroom hotel',
        'villa' => 'Villa', 'apartment' => 'Apartment', 'restaurant' => 'Restaurant',
        'kantor' => 'Kantor', 'developer' => 'Proyek developer', 'lainnya' => 'Lainnya',
    ];

    const STYLES = [
        'modern-minimalis' => 'Modern minimalis', 'minimalis' => 'Minimalis', 'modern' => 'Modern',
        'premium' => 'Premium', 'luxury' => 'Luxury', 'classic' => 'Classic', 'belum-tahu' => 'Saya belum tahu',
    ];

    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $ranges = ProductController::PRICE_RANGES;

        $input = [
            'usage'  => isset(self::USAGES[(string) $request->query('usage')]) ? $request->query('usage') : null,
            'style'  => isset(self::STYLES[(string) $request->query('style')]) ? $request->query('style') : null,
            'budget' => (isset($ranges[(string) $request->query('budget')]) || $request->query('budget') === 'belum-tahu')
                            ? $request->query('budget') : null,
            'needs'  => array_values(array_filter((array) $request->query('needs', []), 'is_string')),
        ];

        $results = $request->boolean('cari')
            ? $this->recommend($categories->whereIn('slug', $input['needs']), $input)
            : null;

        return view('recommendation.index', [
            'categories' => $categories, 'input' => $input, 'results' => $results,
            'usages' => self::USAGES, 'styles' => self::STYLES, 'ranges' => $ranges,
        ]);
    }

    // Skor sederhana: kategori wajib cocok, budget menyaring, style/usage/best seller menambah skor.
    private function recommend($cats, array $in): array
    {
        $range = ProductController::PRICE_RANGES[(string) $in['budget']] ?? null;
        $out = [];

        foreach ($cats as $cat) {
            $products = Product::with(['category', 'brand'])
                ->where('is_active', true)->where('category_id', $cat->id)
                ->orderBy('sort_order')->get()
                ->filter(function ($p) use ($range) {
                    if (! $range || ! $p->price) return true;   // tanpa harga = tidak disaring
                    return $p->price >= $range[1] && (! $range[2] || $p->price < $range[2]);
                })
                ->sortByDesc(fn ($p) => $this->score($p, $in))
                ->take(3)->values();

            $out[] = ['category' => $cat, 'products' => $products];
        }

        return $out;
    }

    private function score(Product $p, array $in): int
    {
        $s = $p->is_best_seller ? 1 : 0;
        if ($in['style'] && in_array($in['style'], $p->styles ?? [])) $s += 3;
        if ($in['usage'] && in_array($in['usage'], $p->usages ?? [])) $s += 3;

        return $s;
    }
}