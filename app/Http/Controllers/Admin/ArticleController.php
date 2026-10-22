<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Articles', 'base' => 'admin.articles',
            'rows' => Article::latest()->get(),
            'cols' => [
                'Judul' => fn ($r) => $r->title,
                'Tanggal terbit' => fn ($r) => $r->published_at?->format('d M Y') ?? '-',
                'Status' => fn ($r) => $r->is_published ? 'Terbit' : 'Draft',
            ],
        ]);
    }

    public function create() { return $this->form(new Article); }
    public function edit(Article $article) { return $this->form($article); }

    public function store(Request $request)
    {
        $this->save($request, new Article);
        return redirect()->route('admin.articles.index')->with('ok', 'Artikel disimpan.');
    }

    public function update(Request $request, Article $article)
    {
        $this->save($request, $article);
        return redirect()->route('admin.articles.index')->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(Article $article)
    {
        if ($article->image) Storage::disk('public')->delete($article->image);
        $article->delete();

        return back()->with('ok', 'Artikel dihapus.');
    }

    private function form(Article $m)
    {
        return view('admin.crud.form', [
            'title' => $m->exists ? 'Edit Artikel' : 'Tambah Artikel',
            'base' => 'admin.articles', 'model' => $m,
            'fields' => [
                ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'Slug (URL)', 'type' => 'text', 'help' => 'Kosongkan untuk otomatis dari judul.'],
                ['name' => 'excerpt', 'label' => 'Ringkasan', 'type' => 'textarea', 'rows' => 2, 'help' => 'Maks 300 karakter. Tampil di daftar artikel.'],
                ['name' => 'content', 'label' => 'Isi (Markdown)', 'type' => 'textarea', 'rows' => 18, 'help' => 'Subjudul: ## Judul. Tebal: **teks**. Daftar: awali baris dengan "- ". Link: [teks](https://...)'],
                ['name' => 'image', 'label' => 'Gambar utama', 'type' => 'file'],
                ['name' => 'meta_title', 'label' => 'Meta title (opsional)', 'type' => 'text', 'help' => 'Maks 70 karakter.'],
                ['name' => 'meta_description', 'label' => 'Meta description (opsional)', 'type' => 'textarea', 'rows' => 2, 'help' => 'Maks 160 karakter.'],
                ['name' => 'is_published', 'label' => 'Terbitkan', 'type' => 'checkbox'],
            ],
        ]);
    }

    private function save(Request $r, Article $m): void
    {
        $d = $r->validate([
            'title' => 'required|string|max:150',
            'slug' => ['nullable', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('articles', 'slug')->ignore($m->id)],
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
        ], id_messages());

        $publish = $r->boolean('is_published');

        $m->fill([
            'title' => $d['title'],
            'slug' => $d['slug'] ?? ($m->slug ?: unique_slug(Article::class, $d['title'], $m->id)),
            'excerpt' => $d['excerpt'] ?? null,
            'content' => $d['content'],
            'image' => save_image($r, 'image', 'articles', $m->image),
            'meta_title' => $d['meta_title'] ?? null,
            'meta_description' => $d['meta_description'] ?? null,
            'is_published' => $publish,
            'published_at' => $publish ? ($m->published_at ?? now()) : $m->published_at,
        ])->save();
    }
}