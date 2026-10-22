@extends('layouts.app')

@php
    $heading = $category->name ?? $brand->name ?? 'Semua Produk';
    $base = $category ? '/produk/'.$category->slug : ($brand ? '/brand/'.$brand->slug : '/produk');
    $crumbs = [['Beranda', '/'], ['Produk', ($category || $brand) ? '/produk' : null]];
    if ($category) $crumbs[] = [$category->name, null];
    if ($brand) $crumbs[] = [$brand->name, null];
@endphp

@section('title')
@if($category)Katalog {{ $category->name }} Sanitary di Bogor | Top Sains Bangunan
@elseif($brand)Produk {{ $brand->name }} di Bogor | Top Sains Bangunan
@else Katalog Produk Sanitary & Bathroom | Top Sains Bangunan
@endif
@endsection

@section('description', $category?->description
    ?: 'Daftar produk sanitary dan perlengkapan kamar mandi di Top Sains Bangunan, Bogor. Tanyakan harga dan ketersediaan langsung via WhatsApp.')

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="$crumbs" />

        <div class="row g-4 align-items-end mt-3 mb-4">
            <div class="col-lg-7">
                <h1 class="h-section">{{ $heading }}</h1>
                @if($category?->description)<p class="lead-t mt-3 mb-0">{{ $category->description }}</p>@endif
            </div>
            <div class="col-lg-5 text-lg-end">
                <span class="eyebrow">{{ $products->total() }} produk</span>
            </div>
        </div>

        {{-- Chip kategori --}}
        <div class="chips mb-4">
            <a href="/produk" class="chip {{ ! $category && ! $brand ? 'on' : '' }}">Semua</a>
            @foreach($categories as $c)
                <a href="/produk/{{ $c->slug }}" class="chip {{ $category?->id === $c->id ? 'on' : '' }}">{{ $c->name }}</a>
            @endforeach
        </div>

        {{-- Filter --}}
        <form method="get" action="{{ $base }}" class="filter-bar mb-5">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau SKU" aria-label="Cari produk">
            <select name="harga" aria-label="Rentang harga">
                <option value="">Semua harga</option>
                @foreach($ranges as $key => $r)
                    <option value="{{ $key }}" @selected(request('harga') === (string) $key)>{{ $r[0] }}</option>
                @endforeach
            </select>
            @if(! $brand && $brands->count() > 1)
                <select name="brand" aria-label="Brand">
                    <option value="">Semua brand</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->slug }}" @selected(request('brand') === $b->slug)>{{ $b->name }}</option>
                    @endforeach
                </select>
            @endif
            <select name="urut" aria-label="Urutkan">
                <option value="">Paling populer</option>
                <option value="harga-rendah" @selected(request('urut') === 'harga-rendah')>Harga terendah</option>
                <option value="harga-tinggi" @selected(request('urut') === 'harga-tinggi')>Harga tertinggi</option>
                <option value="nama" @selected(request('urut') === 'nama')>Nama A–Z</option>
            </select>
            <button class="btn-main btn-sm-t" type="submit">Terapkan</button>
            @if(request()->hasAny(['q','harga','brand','urut']))
                <a href="{{ $base }}" class="link-arrow align-self-center">Reset</a>
            @endif
        </form>

        {{-- Grid --}}
        @if($products->isNotEmpty())
            <div class="row g-4 g-lg-5 row-cols-2 row-cols-lg-4">
                @foreach($products as $p)
                    <div class="col"><x-product-card :product="$p" /></div>
                @endforeach
            </div>
            <div class="mt-5 d-flex justify-content-center">{{ $products->links() }}</div>
        @else
            <div class="empty-box">
                Produk tidak ditemukan. Coba ubah filter, atau
                <a class="link-wa" href="{{ wa_url('Halo Top Sains, saya mencari produk sanitary tapi belum menemukannya di website. Bisa dibantu?') }}" target="_blank" rel="noopener">tanyakan langsung via WhatsApp</a>.
            </div>
        @endif

        {{-- Bantuan --}}
        <div class="consult mt-5 reveal">
            <div>
                <h2 class="fs-3 mb-1">Belum menemukan yang cocok?</h2>
                <p class="mb-0 text-muted">Ceritakan kebutuhan Anda, atau jawab beberapa pertanyaan singkat.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="/bantu-memilih" class="btn-line">Bantu Saya Memilih</a>
                <a href="{{ wa_url('Halo Top Sains, saya ingin berkonsultasi memilih produk sanitary.') }}" target="_blank" rel="noopener" class="btn-main">Konsultasi via WhatsApp</a>
            </div>
        </div>
    </div>
</section>
@endsection