@extends('layouts.app')

@php
    $name = $product->display_name;
    $desc = $product->meta_description
        ?: ($product->short_description ?: "{$name}, {$product->category->name} ".($product->brand?->name ?? '')." di Top Sains Bangunan, Bogor. Tanyakan harga dan ketersediaan via WhatsApp.");

    // Gallery: gambar utama + gambar tambahan
    $gallery = collect();
    if ($product->image_url) $gallery->push(['src' => $product->image_url, 'alt' => "{$name} {$product->category->name}"]);
    foreach ($product->images as $img) {
        $gallery->push(['src' => asset('storage/'.$img->path), 'alt' => $img->alt ?: "{$name} {$product->category->name}"]);
    }

    $specs = collect($product->specifications ?? [])->filter(fn ($s) => filled($s['label'] ?? null) && filled($s['value'] ?? null));
    $suit  = collect($product->suitable_for ?? [])->filter();

    // Schema Product. Tanpa "availability" karena stok tidak dikelola di website.
    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $name,
        'sku' => $product->sku,
        'category' => $product->category->name,
        'description' => $product->short_description ?: strip_tags((string) $product->description) ?: null,
        'image' => $gallery->pluck('src')->all() ?: null,
        'brand' => $product->brand ? ['@type' => 'Brand', 'name' => $product->brand->name] : null,
        'offers' => $product->price ? [
            '@type' => 'Offer', 'url' => $product->url,
            'priceCurrency' => 'IDR', 'price' => (string) $product->price,
        ] : null,
    ]);
@endphp

@section('title', ($product->meta_title ?: "{$name} {$product->category->name}: Harga & Spesifikasi")." | Top Sains Bangunan")
@section('description', \Illuminate\Support\Str::limit($desc, 158))
@section('wa', product_wa($product))

@push('head')
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Produk','/produk'],[$product->category->name,'/produk/'.$product->category->slug],[$name,null]]" />

        <div class="row g-5 mt-1">
            {{-- Gallery --}}
            <div class="col-lg-7">
                <div class="gallery-main">
                    @if($gallery->isNotEmpty())
                        <img id="gMain" src="{{ $gallery[0]['src'] }}" alt="{{ $gallery[0]['alt'] }}" width="900" height="900" fetchpriority="high">
                    @else
                        <span class="ph">{{ $product->sku ?: $product->name }}</span>
                    @endif
                    @if($product->is_best_seller)<span class="tag">Best Seller</span>@endif
                </div>
                @if($gallery->count() > 1)
                    <div class="gallery-thumbs">
                        @foreach($gallery as $g)
                            <button type="button" class="thumb {{ $loop->first ? 'on' : '' }}" data-src="{{ $g['src'] }}" data-alt="{{ $g['alt'] }}" aria-label="Lihat gambar {{ $loop->iteration }}">
                                <img src="{{ $g['src'] }}" alt="" width="120" height="120" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="col-lg-5">
                <div class="sticky-col">
                    <p class="eyebrow mb-2">{{ $product->category->name }}</p>
                    <h1 class="h-section mb-3" style="font-size:clamp(2rem,4vw,3rem)">{{ $name }}</h1>
                    @if($product->short_description)<p class="lead-t mb-4">{{ $product->short_description }}</p>@endif

                    <div class="price-big mb-1">{{ $product->price ? rupiah($product->price) : 'Tanya harga' }}</div>
                    <p class="small text-muted mb-4">Harga dan ketersediaan dapat berubah. Konfirmasi ke tim Top Sains sebelum membeli.</p>

                    <a href="{{ product_wa($product) }}" target="_blank" rel="noopener" class="btn-main w-100 justify-content-center mb-4">Tanya Harga &amp; Ketersediaan</a>

                    <div class="info-row d-flex justify-content-between"><span class="text-muted">SKU</span><span>{{ $product->sku ?: '-' }}</span></div>
                    @if($product->brand)
                        <div class="info-row d-flex justify-content-between"><span class="text-muted">Brand</span><a href="/brand/{{ $product->brand->slug }}">{{ $product->brand->name }}</a></div>
                    @endif
                    <div class="info-row d-flex justify-content-between"><span class="text-muted">Kategori</span><a href="/produk/{{ $product->category->slug }}">{{ $product->category->name }}</a></div>
                </div>
            </div>
        </div>

        {{-- Deskripsi, spesifikasi, cocok untuk --}}
        @if($product->description || $specs->isNotEmpty() || $suit->isNotEmpty())
        <div class="row g-5 mt-4">
            @if($specs->isNotEmpty())
            <div class="col-lg-7">
                <h2 class="fs-3 mb-3">Spesifikasi</h2>
                <table class="spec-table">
                    @foreach($specs as $s)
                        <tr><th>{{ $s['label'] }}</th><td>{{ $s['value'] }}</td></tr>
                    @endforeach
                </table>
            </div>
            @endif
            <div class="col-lg-5 {{ $specs->isEmpty() ? 'offset-lg-0' : '' }}">
                @if($product->description)
                    <h2 class="fs-3 mb-3">Deskripsi</h2>
                    <div class="mb-5 text-muted">{!! nl2br(e($product->description)) !!}</div>
                @endif
                @if($suit->isNotEmpty())
                    <h2 class="fs-3 mb-3">Cocok untuk</h2>
                    <ul class="suit-list">
                        @foreach($suit as $s)<li>{{ $s }}</li>@endforeach
                    </ul>
                @endif
            </div>
        </div>
        @endif

        {{-- Produk pendamping (hanya tampil jika diisi admin) --}}
        @if($related->isNotEmpty())
        <div class="mt-5 pt-5 border-top">
            <div class="row g-5">
                <div class="col-lg-4">
                    <p class="eyebrow mb-3">Biar tidak ada yang terlewat</p>
                    <h2 class="h-section mb-3" style="font-size:clamp(1.75rem,3vw,2.4rem)">Produk yang sering digunakan bersama</h2>
                    <a href="{{ wa_url('Halo Top Sains, saya ingin menanyakan '.$name.' beserta '.$related->map->display_name->join(', ', ' dan ').'. Apakah tersedia dan berapa harganya?') }}" target="_blank" rel="noopener" class="btn-line">Tanya semuanya sekaligus</a>
                </div>
                <div class="col-lg-8">
                    <div class="row g-4 row-cols-2">
                        @foreach($related as $r)
                            <div class="col"><x-product-card :product="$r" /></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Konsultasi --}}
        <div class="consult mt-5">
            <div>
                <h2 class="fs-3 mb-1">Masih bingung memilih?</h2>
                <p class="mb-0 text-muted">Ceritakan kebutuhan kamar mandi Anda. Tim Top Sains akan membantu memilihkan produk yang sesuai.</p>
            </div>
            <a href="{{ wa_url('Halo Top Sains, saya masih bingung memilih. Saya tertarik dengan '.$name.' dan ingin berkonsultasi.') }}" target="_blank" rel="noopener" class="btn-main">Konsultasi via WhatsApp</a>
        </div>

        {{-- Produk serupa --}}
        @if($similar->isNotEmpty())
        <div class="mt-5 pt-5">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h2 class="h-section" style="font-size:clamp(1.75rem,3vw,2.4rem)">Lainnya di {{ $product->category->name }}</h2>
                <a href="/produk/{{ $product->category->slug }}" class="link-arrow">Lihat semua</a>
            </div>
            <div class="row g-4 row-cols-2 row-cols-lg-4">
                @foreach($similar as $s)<div class="col"><x-product-card :product="$s" /></div>@endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<script>
document.querySelectorAll('.thumb').forEach(function (t) {
    t.addEventListener('click', function () {
        var m = document.getElementById('gMain');
        m.src = t.dataset.src; m.alt = t.dataset.alt;
        document.querySelectorAll('.thumb').forEach(function (x) { x.classList.remove('on'); });
        t.classList.add('on');
    });
});
</script>
@endsection