@extends('layouts.admin')

@php
    $edit = $product->exists;
    $rows = old('spec_label') !== null
        ? collect(old('spec_label'))->map(fn ($l, $i) => ['label' => $l, 'value' => old('spec_value.'.$i)])->all()
        : ($product->specifications ?? []);
    if (! $rows) $rows = [['label' => '', 'value' => '']];
    $selStyles  = old('styles', $product->styles ?? []);
    $selUsages  = old('usages', $product->usages ?? []);
    $selRelated = old('related', $edit ? $product->related->pluck('id')->all() : []);
    $suit       = old('suitable_for', implode("\n", $product->suitable_for ?? []));
@endphp

@section('title', $edit ? 'Edit '.$product->name : 'Tambah Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">{{ $edit ? 'Edit Produk' : 'Tambah Produk' }}</h1>
    <div class="d-flex gap-3 align-items-center">
        @if($edit)<a href="{{ $product->url }}" target="_blank" class="small">Lihat di website ↗</a>@endif
        <a href="{{ route('admin.products.index') }}" class="small">← Kembali</a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">Ada isian yang perlu diperbaiki. Lihat pesan merah di bawah.</div>
@endif

<form method="post" enctype="multipart/form-data"
      action="{{ $edit ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf
    @if($edit) @method('PUT') @endif

    <div class="row g-4">
        {{-- KIRI --}}
        <div class="col-xl-8">

            <div class="bg-white border rounded p-3 p-md-4 mb-4">
                <h2 class="h6 mb-3">Informasi dasar</h2>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Nama</label>
                        <input name="name" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">SKU</label>
                        <input name="sku" value="{{ old('sku', $product->sku) }}" class="form-control @error('sku') is-invalid @enderror">
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih</option>
                            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>@endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-select">
                            <option value="">-</option>
                            @foreach($brands as $b)<option value="{{ $b->id }}" @selected(old('brand_id', $product->brand_id) == $b->id)>{{ $b->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga (Rp)</label>
                        <input name="price" inputmode="numeric" value="{{ old('price', $product->price) }}" class="form-control @error('price') is-invalid @enderror" placeholder="1500000">
                        <div class="form-text">Kosongkan jika harga tidak ditampilkan. Website akan menulis "Tanya harga".</div>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Slug (URL)</label>
                        <input name="slug" value="{{ old('slug', $product->slug) }}" class="form-control @error('slug') is-invalid @enderror" placeholder="otomatis dari nama">
                        <div class="form-text">Ubah slug produk yang sudah tayang hanya jika perlu, karena URL lama akan 404.</div>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi singkat</label>
                        <input name="short_description" value="{{ old('short_description', $product->short_description) }}" class="form-control" maxlength="255">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi lengkap</label>
                        <textarea name="description" rows="6" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white border rounded p-3 p-md-4 mb-4">
                <h2 class="h6 mb-1">Spesifikasi</h2>
                <p class="text-muted small">Isi dari katalog resmi atau data keluarga. Baris kosong diabaikan.</p>
                <div id="specs">
                    @foreach($rows as $r)
                        <div class="row g-2 mb-2 spec-row">
                            <div class="col-5"><input name="spec_label[]" value="{{ $r['label'] }}" class="form-control" placeholder="Label (mis. Ukuran)"></div>
                            <div class="col-6"><input name="spec_value[]" value="{{ $r['value'] }}" class="form-control" placeholder="Nilai"></div>
                            <div class="col-1"><button type="button" class="btn btn-outline-danger w-100" data-rm aria-label="Hapus baris">×</button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addSpec" class="btn btn-sm btn-outline-dark">+ Tambah baris</button>
            </div>

            <div class="bg-white border rounded p-3 p-md-4 mb-4">
                <h2 class="h6 mb-3">Cocok untuk &amp; rekomendasi</h2>
                <label class="form-label">Cocok untuk <span class="text-muted">(tampil di halaman produk, satu per baris)</span></label>
                <textarea name="suitable_for" rows="4" class="form-control mb-4" placeholder="Rumah&#10;Renovasi&#10;Bathroom modern">{{ $suit }}</textarea>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-label">Gaya <span class="text-muted">(untuk "Bantu Saya Memilih")</span></div>
                        @foreach($styles as $k => $v)
                            <div class="form-check"><input class="form-check-input" type="checkbox" name="styles[]" value="{{ $k }}" id="st-{{ $k }}" @checked(in_array($k, $selStyles))><label class="form-check-label" for="st-{{ $k }}">{{ $v }}</label></div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">Penggunaan <span class="text-muted">(untuk "Bantu Saya Memilih")</span></div>
                        @foreach($usages as $k => $v)
                            <div class="form-check"><input class="form-check-input" type="checkbox" name="usages[]" value="{{ $k }}" id="us-{{ $k }}" @checked(in_array($k, $selUsages))><label class="form-check-label" for="us-{{ $k }}">{{ $v }}</label></div>
                        @endforeach
                    </div>
                </div>
                <div class="form-text mt-3">Centang hanya yang sesuai kenyataan. Produk tanpa centang tetap muncul di rekomendasi, hanya skornya lebih rendah.</div>
            </div>

            <div class="bg-white border rounded p-3 p-md-4 mb-4">
                <h2 class="h6 mb-1">Produk yang sering digunakan bersama</h2>
                <p class="text-muted small">Contoh untuk closet: jet spray. Kosongkan jika belum yakin kombinasinya.</p>
                <input type="search" id="relFilter" class="form-control mb-2" placeholder="Cari produk...">
                <div class="border rounded p-2" style="max-height:240px;overflow:auto">
                    @foreach($others as $o)
                        <label class="d-block rel-item py-1">
                            <input type="checkbox" name="related[]" value="{{ $o->id }}" @checked(in_array($o->id, $selRelated))>
                            {{ $o->name }} <small class="text-muted">{{ $o->sku }}</small>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border rounded p-3 p-md-4 mb-4">
                <h2 class="h6 mb-1">SEO <span class="text-muted fw-normal">(opsional)</span></h2>
                <p class="text-muted small">Jika kosong, website membuat title dan description otomatis dari nama produk.</p>
                <div class="mb-3">
                    <label class="form-label">Meta title</label>
                    <input name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="form-control" maxlength="70">
                </div>
                <div>
                    <label class="form-label">Meta description</label>
                    <textarea name="meta_description" rows="2" class="form-control" maxlength="160">{{ old('meta_description', $product->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- KANAN --}}
        <div class="col-xl-4">
            <div class="bg-white border rounded p-3 p-md-4 mb-4">
                <h2 class="h6 mb-3">Status</h2>
                <div class="form-check form-switch mb-2"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $product->is_active))><label class="form-check-label" for="is_active">Aktif (tampil di website)</label></div>
                <div class="form-check form-switch mb-2"><input class="form-check-input" type="checkbox" name="is_best_seller" value="1" id="is_best_seller" @checked(old('is_best_seller', $product->is_best_seller))><label class="form-check-label" for="is_best_seller">Best seller</label></div>
                <div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $product->is_featured))><label class="form-check-label" for="is_featured">Featured</label></div>
                <label class="form-label">Urutan</label>
                <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $product->sort_order ?? 0) }}" class="form-control">
                <div class="form-text">Angka kecil tampil lebih dulu.</div>
            </div>

            <div class="bg-white border rounded p-3 p-md-4 mb-4">
                <h2 class="h6 mb-3">Gambar utama</h2>
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="" class="img-fluid border rounded mb-2" style="max-height:200px">
                    <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="remove_image" value="1" id="rm_img"><label class="form-check-label" for="rm_img">Hapus gambar ini</label></div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                <div class="form-text">Maks 2 MB. Disarankan WebP atau JPG, rasio persegi, latar polos.</div>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="bg-white border rounded p-3 p-md-4 mb-4">
                <h2 class="h6 mb-3">Gallery</h2>
                @if($product->images->isNotEmpty())
                    <div class="row g-2 mb-3">
                        @foreach($product->images as $img)
                            <div class="col-4">
                                <img src="{{ asset('storage/'.$img->path) }}" alt="" class="img-fluid border rounded">
                                <label class="small d-block mt-1"><input type="checkbox" name="delete_images[]" value="{{ $img->id }}"> Hapus</label>
                            </div>
                        @endforeach
                    </div>
                @endif
                <input type="file" name="gallery[]" accept="image/*" multiple class="form-control @error('gallery.*') is-invalid @enderror">
                <div class="form-text">Bisa pilih beberapa file. Maks 10 file, masing-masing 2 MB.</div>
                @error('gallery.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="sticky-bottom bg-white border-top py-3 mt-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark px-4">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>

<template id="specRow">
    <div class="row g-2 mb-2 spec-row">
        <div class="col-5"><input name="spec_label[]" class="form-control" placeholder="Label (mis. Ukuran)"></div>
        <div class="col-6"><input name="spec_value[]" class="form-control" placeholder="Nilai"></div>
        <div class="col-1"><button type="button" class="btn btn-outline-danger w-100" data-rm aria-label="Hapus baris">×</button></div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    const box = document.getElementById('specs');
    document.getElementById('addSpec').onclick = () => box.append(document.getElementById('specRow').content.cloneNode(true));
    box.addEventListener('click', e => { if (e.target.matches('[data-rm]')) e.target.closest('.spec-row').remove(); });
    document.getElementById('relFilter').addEventListener('input', e => {
        const v = e.target.value.toLowerCase();
        document.querySelectorAll('.rel-item').forEach(el => el.style.display = el.textContent.toLowerCase().includes(v) ? '' : 'none');
    });
</script>
@endpush