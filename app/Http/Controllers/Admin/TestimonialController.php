<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Testimonials', 'base' => 'admin.testimonials',
            'rows' => Testimonial::orderBy('sort_order')->latest()->get(),
            'cols' => [
                'Nama' => fn ($r) => $r->name,
                'Peran / perusahaan' => fn ($r) => $r->role_company ?: '-',
                'Featured' => fn ($r) => $r->is_featured ? 'Ya' : '-',
                'Status' => fn ($r) => $r->is_active ? 'Aktif' : 'Nonaktif',
            ],
        ]);
    }

    public function create() { return $this->form(new Testimonial(['is_active' => true])); }
    public function edit(Testimonial $testimonial) { return $this->form($testimonial); }

    public function store(Request $request)
    {
        $this->save($request, new Testimonial);
        return redirect()->route('admin.testimonials.index')->with('ok', 'Testimonial disimpan.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $this->save($request, $testimonial);
        return redirect()->route('admin.testimonials.index')->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image) Storage::disk('public')->delete($testimonial->image);
        $testimonial->delete();

        return back()->with('ok', 'Testimonial dihapus.');
    }

    private function form(Testimonial $m)
    {
        return view('admin.crud.form', [
            'title' => $m->exists ? 'Edit Testimonial' : 'Tambah Testimonial',
            'base' => 'admin.testimonials', 'model' => $m,
            'fields' => [
                ['name' => 'name', 'label' => 'Nama customer', 'type' => 'text', 'required' => true],
                ['name' => 'role_company', 'label' => 'Peran / perusahaan', 'type' => 'text', 'help' => 'Contoh: Pemilik rumah, Bogor. Isi hanya jika customer mengizinkan.'],
                ['name' => 'content', 'label' => 'Isi testimonial', 'type' => 'textarea', 'rows' => 5, 'help' => 'Hanya testimonial asli dari customer, ditulis sesuai ucapan mereka.'],
                ['name' => 'image', 'label' => 'Foto (opsional)', 'type' => 'file', 'help' => 'Belum dipakai di tampilan saat ini.'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'default' => 0],
                ['name' => 'is_featured', 'label' => 'Featured (tampil di homepage, maksimal 3 teratas)', 'type' => 'checkbox'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox', 'default' => true],
            ],
        ]);
    }

    private function save(Request $r, Testimonial $m): void
    {
        $d = $r->validate([
            'name' => 'required|string|max:100',
            'role_company' => 'nullable|string|max:150',
            'content' => 'required|string|max:600',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ], id_messages());

        $m->fill([
            'name' => $d['name'],
            'role_company' => $d['role_company'] ?? null,
            'content' => $d['content'],
            'image' => save_image($r, 'image', 'testimonials', $m->image),
            'sort_order' => $d['sort_order'] ?? 0,
            'is_featured' => $r->boolean('is_featured'),
            'is_active' => $r->boolean('is_active'),
        ])->save();
    }
}