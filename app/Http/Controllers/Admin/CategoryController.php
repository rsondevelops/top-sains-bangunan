<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Categories', 'base' => 'admin.categories',
            'rows' => Category::withCount('products')->orderBy('sort_order')->get(),
            'cols' => [
                'Nama' => fn ($r) => $r->name,
                'Slug' => fn ($r) => $r->slug,
                'Produk' => fn ($r) => $r->products_count,
                'Status' => fn ($r) => $r->is_active ? 'Aktif' : 'Nonaktif',
            ],
        ]);
    }

    public function create() { return $this->form(new Category(['is_active' => true])); }
    public function edit(Category $category) { return $this->form($category); }

    public function store(Request $request)
    {
        $this->save($request, new Category);
        return redirect()->route('admin.categories.index')->with('ok', 'Kategori disimpan.');
    }

    public function update(Request $request, Category $category)
    {
        $this->save($request, $category);
        return redirect()->route('admin.categories.index')->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('err', 'Kategori ini masih punya produk. Pindahkan atau hapus produknya dulu.');
        }
        if ($category->image) Storage::disk('public')->delete($category->image);
        $category->delete();

        return back()->with('ok', 'Kategori dihapus.');
    }

    private function form(Category $m)
    {
        return view('admin.crud.form', [
            'title' => $m->exists ? 'Edit Kategori' : 'Tambah Kategori',
            'base' => 'admin.categories', 'model' => $m,
            'fields' => [
                ['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'Slug (URL)', 'type' => 'text', 'help' => 'Kosongkan untuk otomatis. Mengubah slug kategori yang sudah tayang membuat URL lama 404.'],
                ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'help' => 'Tampil di halaman kategori dan dipakai sebagai meta description.'],
                ['name' => 'image', 'label' => 'Gambar', 'type' => 'file', 'help' => 'Belum dipakai di tampilan saat ini.'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'default' => 0, 'help' => 'Angka kecil tampil lebih dulu.'],
                ['name' => 'is_active', 'label' => 'Aktif (tampil di website)', 'type' => 'checkbox', 'default' => true],
            ],
        ]);
    }

    private function save(Request $r, Category $m): void
    {
        $d = $r->validate([
            'name' => 'required|string|max:100',
            'slug' => ['nullable', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('categories', 'slug')->ignore($m->id)],
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ], id_messages());

        $m->fill([
            'name' => $d['name'],
            'slug' => $d['slug'] ?? ($m->slug ?: unique_slug(Category::class, $d['name'], $m->id)),
            'description' => $d['description'] ?? null,
            'image' => save_image($r, 'image', 'categories', $m->image),
            'sort_order' => $d['sort_order'] ?? 0,
            'is_active' => $r->boolean('is_active'),
        ])->save();
    }
}