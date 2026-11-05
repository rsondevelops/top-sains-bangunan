<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DownloadController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Pricelist & Katalog', 'base' => 'admin.downloads',
            'rows' => Download::orderBy('sort_order')->latest()->get(),
            'cols' => [
                'Judul' => fn ($r) => $r->title,
                'Jenis' => fn ($r) => Download::TYPES[$r->type] ?? $r->type,
                'Sumber' => fn ($r) => $r->file ? 'File PDF' : 'Link',
                'Status' => fn ($r) => $r->is_active ? 'Aktif' : 'Nonaktif',
            ],
        ]);
    }

    public function create() { return $this->form(new Download(['is_active' => true, 'type' => 'pricelist'])); }
    public function edit(Download $download) { return $this->form($download); }

    public function store(Request $request)
    {
        $this->save($request, new Download);
        return redirect()->route('admin.downloads.index')->with('ok', 'Dokumen disimpan.');
    }

    public function update(Request $request, Download $download)
    {
        $this->save($request, $download);
        return redirect()->route('admin.downloads.index')->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(Download $download)
    {
        if ($download->file) Storage::disk('public')->delete($download->file);
        $download->delete();

        return back()->with('ok', 'Dokumen dihapus.');
    }

    private function form(Download $m)
    {
        return view('admin.crud.form', [
            'title' => $m->exists ? 'Edit Dokumen' : 'Tambah Dokumen',
            'base' => 'admin.downloads', 'model' => $m,
            'fields' => [
                ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'required' => true, 'help' => 'Contoh: Pricelist TOTO Januari 2026'],
                ['name' => 'type', 'label' => 'Jenis', 'type' => 'select', 'options' => Download::TYPES],
                ['name' => 'period', 'label' => 'Periode berlaku (opsional)', 'type' => 'text', 'help' => 'Contoh: Berlaku per Januari 2026. Isi sesuai tanggal di dokumen.'],
                ['name' => 'description', 'label' => 'Keterangan (opsional)', 'type' => 'textarea', 'rows' => 3],
                ['name' => 'file', 'label' => 'File PDF', 'type' => 'pdf', 'help' => 'Maks 20 MB. Atau kosongkan dan isi link di bawah.'],
                ['name' => 'url', 'label' => 'Atau link PDF', 'type' => 'text', 'help' => 'Link lengkap https://... ke PDF di situs resmi. Dipakai jika tidak ada file yang diunggah.'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'default' => 0],
                ['name' => 'is_active', 'label' => 'Aktif (tampil di website)', 'type' => 'checkbox', 'default' => true],
            ],
        ]);
    }

    private function save(Request $r, Download $m): void
    {
        $d = $r->validate([
            'title' => 'required|string|max:150',
            'type' => 'required|in:' . implode(',', array_keys(Download::TYPES)),
            'period' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'file' => 'nullable|file|mimes:pdf|max:30480',
            'url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ], id_messages() + ['mimes' => ':attribute harus berupa PDF.', 'in' => ':attribute tidak valid.']);

        $remove = $r->boolean('remove_file');
        $willHaveFile = $r->hasFile('file') || ($m->file && ! $remove);

        if (! $willHaveFile && blank($d['url'] ?? null)) {
            throw ValidationException::withMessages(['file' => 'Unggah file PDF atau isi link PDF.']);
        }

        $path = $m->file;
        if ($r->hasFile('file')) {
            if ($path) Storage::disk('public')->delete($path);
            $path = $r->file('file')->store('downloads', 'public');
        } elseif ($remove && $path) {
            Storage::disk('public')->delete($path);
            $path = null;
        }

        $m->fill([
            'title' => $d['title'],
            'type' => $d['type'],
            'period' => $d['period'] ?? null,
            'description' => $d['description'] ?? null,
            'file' => $path,
            'url' => $d['url'] ?? null,
            'sort_order' => $d['sort_order'] ?? 0,
            'is_active' => $r->boolean('is_active'),
        ])->save();
    }
}