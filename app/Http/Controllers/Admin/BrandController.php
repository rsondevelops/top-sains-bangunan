<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Brands', 'base' => 'admin.brands',
            'rows' => Brand::withCount('products')->orderBy('name')->get(),
            'cols' => [
                'Nama' => fn ($r) => $r->name,
                'Slug' => fn ($r) => $r->slug,
                'Produk' => fn ($r) => $r->products_count,
                'Status' => fn ($r) => $r->is_active ? 'Aktif' : 'Nonaktif',
            ],
        ]);
    }

    public function create() { return $this->form(new Brand(['is_active' => true])); }
    public function edit(Brand $brand) { return $this->form($brand); }

    public function store(Request $request)
    {
        $this->save($request, new Brand);
        return redirect()->route('admin.brands.index')->with('ok', 'Brand disimpan.');
    }

    public function update(Request $request, Brand $brand)
    {
        $this->save($request, $brand);
        return redirect()->route('admin.brands.index')->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return back()->with('err', 'Brand ini masih dipakai produk. Ubah brand produknya dulu.');
        }
        if ($brand->logo) Storage::disk('public')->delete($brand->logo);
        $brand->delete();

        return back()->with('ok', 'Brand dihapus.');
    }

    private function form(Brand $m)
    {
        return view('admin.crud.form', [
            'title' => $m->exists ? 'Edit Brand' : 'Tambah Brand',
            'base' => 'admin.brands', 'model' => $m,
            'fields' => [
                ['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'Slug (URL)', 'type' => 'text', 'help' => 'Kosongkan untuk otomatis.'],
                ['name' => 'logo', 'label' => 'Logo', 'type' => 'file', 'help' => 'Belum dipakai di tampilan saat ini.'],
                ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea'],
                ['name' => 'is_active', 'label' => 'Aktif (tampil di website)', 'type' => 'checkbox', 'default' => true],
            ],
        ]);
    }

    private function save(Request $r, Brand $m): void
    {
        $d = $r->validate([
            'name' => 'required|string|max:100',
            'slug' => ['nullable', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('brands', 'slug')->ignore($m->id)],
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:1000',
        ], id_messages());

        $m->fill([
            'name' => $d['name'],
            'slug' => $d['slug'] ?? ($m->slug ?: unique_slug(Brand::class, $d['name'], $m->id)),
            'logo' => save_image($r, 'logo', 'brands', $m->logo),
            'description' => $d['description'] ?? null,
            'is_active' => $r->boolean('is_active'),
        ])->save();
    }
}