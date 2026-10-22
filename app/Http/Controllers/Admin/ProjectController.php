<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Projects', 'base' => 'admin.projects',
            'rows' => Project::orderBy('sort_order')->latest()->get(),
            'cols' => [
                'Nama' => fn ($r) => $r->name,
                'Tipe' => fn ($r) => $r->type ?: '-',
                'Lokasi' => fn ($r) => $r->location ?: '-',
                'Status' => fn ($r) => $r->is_active ? 'Aktif' : 'Nonaktif',
            ],
        ]);
    }

    public function create() { return $this->form(new Project(['is_active' => true])); }
    public function edit(Project $project) { return $this->form($project); }

    public function store(Request $request)
    {
        $this->save($request, new Project);
        return redirect()->route('admin.projects.index')->with('ok', 'Project disimpan.');
    }

    public function update(Request $request, Project $project)
    {
        $this->save($request, $project);
        return redirect()->route('admin.projects.index')->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(Project $project)
    {
        foreach (array_filter([$project->image, ...($project->gallery ?? [])]) as $path) {
            Storage::disk('public')->delete($path);
        }
        $project->delete();

        return back()->with('ok', 'Project dihapus.');
    }

    private function form(Project $m)
    {
        return view('admin.crud.form', [
            'title' => $m->exists ? 'Edit Project' : 'Tambah Project',
            'base' => 'admin.projects', 'model' => $m,
            'fields' => [
                ['name' => 'name', 'label' => 'Nama project', 'type' => 'text', 'required' => true, 'help' => 'Hanya project yang benar-benar pernah dilayani.'],
                ['name' => 'slug', 'label' => 'Slug (URL)', 'type' => 'text', 'help' => 'Kosongkan untuk otomatis.'],
                ['name' => 'type', 'label' => 'Tipe', 'type' => 'text', 'help' => 'Contoh: Residential, Villa, Commercial.'],
                ['name' => 'location', 'label' => 'Lokasi', 'type' => 'text', 'help' => 'Contoh: Bogor.'],
                ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'rows' => 6],
                ['name' => 'image', 'label' => 'Foto utama', 'type' => 'file'],
                ['name' => 'gallery', 'label' => 'Foto tambahan', 'type' => 'gallery', 'help' => 'Maks 10 file, masing-masing 2 MB.'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'default' => 0],
                ['name' => 'is_featured', 'label' => 'Featured (tampil di homepage, maksimal 3 teratas)', 'type' => 'checkbox'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox', 'default' => true],
            ],
        ]);
    }

    private function save(Request $r, Project $m): void
    {
        $d = $r->validate([
            'name' => 'required|string|max:150',
            'slug' => ['nullable', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('projects', 'slug')->ignore($m->id)],
            'type' => 'nullable|string|max:60',
            'location' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:3000',
            'image' => 'nullable|image|max:2048',
            'gallery' => 'nullable|array|max:10',
            'gallery.*' => 'image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ], id_messages());

        // Gallery: hanya path yang memang ada di gallery project ini yang boleh dihapus
        $gallery = collect($m->gallery ?? []);
        foreach ((array) $r->input('delete_gallery', []) as $path) {
            if ($gallery->contains($path)) {
                Storage::disk('public')->delete($path);
                $gallery = $gallery->reject(fn ($p) => $p === $path);
            }
        }
        foreach ((array) $r->file('gallery', []) as $file) {
            $gallery->push(store_webp($file, 'projects'));
        }

        $m->fill([
            'name' => $d['name'],
            'slug' => $d['slug'] ?? ($m->slug ?: unique_slug(Project::class, $d['name'], $m->id)),
            'type' => $d['type'] ?? null,
            'location' => $d['location'] ?? null,
            'description' => $d['description'] ?? null,
            'image' => save_image($r, 'image', 'projects', $m->image),
            'gallery' => $gallery->values()->all(),
            'sort_order' => $d['sort_order'] ?? 0,
            'is_featured' => $r->boolean('is_featured'),
            'is_active' => $r->boolean('is_active'),
        ])->save();
    }
}