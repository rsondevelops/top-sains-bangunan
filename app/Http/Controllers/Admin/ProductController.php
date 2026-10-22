<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RecommendationController as Rec;
use App\Models\{Brand, Category, Product, ProductImage};
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'brand'])
            ->when($request->q, fn ($q, $v) => $q->where(fn ($w) => $w->where('name', 'like', "%{$v}%")->orWhere('sku', 'like', "%{$v}%")))
            ->when($request->category, fn ($q, $v) => $q->where('category_id', $v))
            ->orderBy('sort_order')->orderBy('name')
            ->paginate(20)->withQueryString();

        return view('admin.products.index', [
            'products'   => $products,
            'categories' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return $this->form(new Product(['is_active' => true, 'sort_order' => 0]));
    }

    public function edit(Product $product)
    {
        return $this->form($product->load(['images', 'related']));
    }

    public function store(Request $request)
    {
        $product = new Product();
        $this->save($request, $product);

        return redirect()->route('admin.products.edit', $product)->with('ok', 'Produk disimpan.');
    }

    public function update(Request $request, Product $product)
    {
        $this->save($request, $product);

        return redirect()->route('admin.products.edit', $product)->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();   // product_images dan product_relations ikut terhapus (cascade)

        return redirect()->route('admin.products.index')->with('ok', 'Produk dihapus.');
    }

    private function form(Product $product)
    {
        return view('admin.products.form', [
            'product'    => $product,
            'categories' => Category::orderBy('sort_order')->get(),
            'brands'     => Brand::orderBy('name')->get(),
            'others'     => Product::when($product->exists, fn ($q) => $q->where('id', '!=', $product->id))
                                ->orderBy('name')->get(['id', 'name', 'sku']),
            'styles'     => Arr::except(Rec::STYLES, 'belum-tahu'),
            'usages'     => Arr::except(Rec::USAGES, 'lainnya'),
        ]);
    }

    private function save(Request $request, Product $product): void
    {
        // "1.500.000" -> 1500000
        $request->merge(['price' => preg_replace('/\D/', '', (string) $request->input('price')) ?: null]);

        $data = $request->validate([
            'name'              => 'required|string|max:150',
            'slug'              => ['nullable', 'string', 'max:160', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('products', 'slug')->ignore($product->id)],
            'sku'               => 'nullable|string|max:60',
            'category_id'       => 'required|exists:categories,id',
            'brand_id'          => 'nullable|exists:brands,id',
            'short_description' => 'nullable|string|max:255',
            'description'       => 'nullable|string|max:5000',
            'price'             => 'nullable|integer|min:0',
            'sort_order'        => 'nullable|integer|min:0|max:100000',
            'meta_title'        => 'nullable|string|max:70',
            'meta_description'  => 'nullable|string|max:160',
            'suitable_for'      => 'nullable|string|max:1000',
            'image'             => 'nullable|image|max:2048',
            'gallery'           => 'nullable|array|max:10',
            'gallery.*'         => 'image|max:2048',
            'delete_images'     => 'nullable|array',
            'delete_images.*'   => 'integer',
            'spec_label.*'      => 'nullable|string|max:100',
            'spec_value.*'      => 'nullable|string|max:255',
            'styles'            => 'nullable|array',
            'usages'            => 'nullable|array',
            'related'           => 'nullable|array',
            'related.*'         => 'integer|exists:products,id',
        ], [
            'required'    => ':attribute wajib diisi.',
            'image'       => ':attribute harus berupa gambar (jpg, png, atau webp).',
            'max.file'    => ':attribute maksimal :max KB.',
            'max.string'  => ':attribute terlalu panjang (maks :max karakter).',
            'unique'      => ':attribute sudah dipakai produk lain.',
            'regex'       => 'Format :attribute: huruf kecil, angka, dan tanda minus. Contoh: closet-cw53',
            'integer'     => ':attribute harus berupa angka.',
        ], [
            'name' => 'Nama', 'slug' => 'Slug', 'category_id' => 'Kategori', 'price' => 'Harga',
            'image' => 'Gambar utama', 'gallery.*' => 'Gambar gallery', 'meta_description' => 'Meta description',
        ]);

        $fields = Arr::only($data, ['category_id', 'brand_id', 'name', 'sku', 'short_description', 'description', 'price', 'meta_title', 'meta_description']);
        $fields['sort_order'] = $data['sort_order'] ?? 0;
        $fields['slug'] = $data['slug'] ?? $this->uniqueSlug($data['name'], $product->id);

        // Spesifikasi: pasangan label + nilai, baris kosong dibuang
        $fields['specifications'] = collect($request->input('spec_label', []))
            ->map(fn ($l, $i) => ['label' => trim((string) $l), 'value' => trim((string) $request->input("spec_value.{$i}"))])
            ->filter(fn ($s) => $s['label'] !== '' && $s['value'] !== '')
            ->values()->all();

        // Cocok untuk: satu per baris
        $fields['suitable_for'] = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) $request->input('suitable_for')))));

        // Style dan usage: hanya key yang valid
        $fields['styles'] = array_values(array_intersect(array_keys(Rec::STYLES), (array) $request->input('styles')));
        $fields['usages'] = array_values(array_intersect(array_keys(Rec::USAGES), (array) $request->input('usages')));

        foreach (['is_featured', 'is_best_seller', 'is_active'] as $flag) {
            $fields[$flag] = $request->boolean($flag);
        }

        // Gambar utama
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $fields['image'] = store_webp($request->file('image'), 'products', 1200);
        } elseif ($request->boolean('remove_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $fields['image'] = null;
        }

        $product->fill($fields)->save();

        // Gallery: hapus yang dicentang, tambah yang baru
        if ($ids = $request->input('delete_images')) {
            ProductImage::where('product_id', $product->id)->whereIn('id', $ids)->get()->each(function ($img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            });
        }
        $next = (int) ProductImage::where('product_id', $product->id)->max('sort_order');
        foreach ((array) $request->file('gallery', []) as $file) {
            ProductImage::create([
                'product_id' => $product->id,
                'path' => store_webp($file, 'products', 1200),
                'sort_order' => ++$next,
            ]);
        }

        // Produk pendamping (urutan mengikuti urutan daftar)
        $sync = [];
        foreach (array_values(array_diff((array) $request->input('related', []), [$product->id])) as $i => $id) {
            $sync[$id] = ['sort_order' => $i];
        }
        $product->related()->sync($sync);
    }

    private function uniqueSlug(string $name, ?int $ignoreId): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $n = 2;
        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $n++;
        }

        return $slug;
    }
}