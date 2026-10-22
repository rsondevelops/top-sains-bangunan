@extends('layouts.app')

@section('title', 'Top Sains Bangunan: Sanitary TOTO di Bogor, Jakarta & BSD')
@section('description', 'Katalog dan showroom sanitary TOTO di Bogor untuk rumah, renovasi, dan proyek. Melayani Bogor, Jakarta, BSD, dan sekitarnya.')

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <p class="eyebrow mb-3">Showroom Sanitary · Bogor</p>
                <h1 class="display-t mb-4">Sanitary &amp; Bathroom Solution untuk Rumah dan Proyek</h1>
                <p class="lead-t mb-4">Temukan produk sanitary berkualitas untuk kebutuhan rumah, renovasi, dan proyek Anda.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="/produk" class="btn-main">Cari Produk</a>
                    <a href="{{ wa_url('Halo Top Sains, saya ingin berkonsultasi tentang produk sanitary.') }}" target="_blank" rel="noopener" class="btn-line">Konsultasi WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-6 reveal">
                <div class="hero-wrap">
                    <div class="hero-visual">
                        {{-- Taruh foto showroom/produk di public/img/hero.webp --}}
                        <img src="{{ asset('img/hero.webp') }}" alt="Showroom sanitary Top Sains Bangunan di Bogor" width="800" height="1000" fetchpriority="high" onerror="this.remove()">
                    </div>
                    <div class="hero-note">
                        <span class="eyebrow d-block mb-1">Area layanan</span>
                        Bogor, Jakarta, BSD, dan sekitarnya
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TRUST STRIP --}}
<section class="trust">
    <div class="container trust-inner">
        <div class="trust-item">
            <span class="eyebrow">Brand</span>
            <strong>{{ $brands->isNotEmpty() ? $brands->pluck('name')->join(' · ') : 'TOTO' }}</strong>
        </div>
        <div class="trust-item">
            <span class="eyebrow">Area layanan</span>
            <strong>Bogor · Jakarta · BSD</strong>
        </div>
        <div class="trust-item">
            <span class="eyebrow">Melayani</span>
            <strong>Retail &amp; proyek</strong>
        </div>
        @if(setting('year_established'))
        <div class="trust-item">
            <span class="eyebrow">Berdiri</span>
            <strong>Sejak {{ setting('year_established') }}</strong>
        </div>
        @endif
    </div>
</section>

{{-- DISCOVERY --}}
<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="sticky-col reveal">
                    <p class="eyebrow mb-3">Katalog</p>
                    <h2 class="h-section mb-3">Cari berdasarkan kebutuhan</h2>
                    <p class="lead-t mb-4">Belum tahu produk apa yang cocok? Jawab beberapa pertanyaan singkat, kami bantu pilihkan.</p>
                    <a href="/bantu-memilih" class="link-arrow">Bantu Saya Memilih</a>
                </div>
            </div>
            <div class="col-lg-7 offset-lg-1 reveal">
                @foreach($categories as $c)
                    <a href="/produk/{{ $c->slug }}" class="index-row">
                        <span class="idx-name">{{ $c->name }}</span>
                        <span class="idx-meta">{{ $c->products_count }} produk →</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- BEST SELLERS --}}
<section class="section pt-0">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4 reveal">
            <div>
                <p class="eyebrow mb-3">Paling banyak dicari</p>
                <h2 class="h-section">Best Seller</h2>
            </div>
            <a href="/produk" class="link-arrow">Lihat semua produk</a>
        </div>
        <div class="hscroll reveal">
            @foreach($bestSellers as $p)
                <x-product-card :product="$p" />
            @endforeach
        </div>
    </div>
</section>

{{-- STYLE / NEED --}}
<section class="section pt-0">
    <div class="container">
        <div class="mb-5 reveal">
            <p class="eyebrow mb-3">Mulai dari sini</p>
            <h2 class="h-section">Sesuaikan dengan gaya<br class="d-none d-md-block"> dan kebutuhan Anda</h2>
        </div>
        <div class="need-grid reveal">
            <a href="/bantu-memilih?style=modern-minimalis" class="need need-dark">
                <span class="eyebrow" style="color:rgba(255,255,255,.6)">Gaya</span>
                <div><h3>Modern Minimalis</h3><p>Garis bersih dan bentuk sederhana untuk kamar mandi rumah masa kini.</p></div>
            </a>
            <a href="/bantu-memilih?style=premium" class="need"><span class="eyebrow">Gaya</span><div><h3>Premium</h3><p>Pilihan untuk kamar mandi dengan standar lebih tinggi.</p></div></a>
            <a href="/bantu-memilih?usage=renovasi" class="need"><span class="eyebrow">Kebutuhan</span><div><h3>Renovasi Kamar Mandi</h3><p>Ganti sebagian atau seluruh sanitary yang lama.</p></div></a>
            <a href="/solusi/proyek" class="need"><span class="eyebrow">Kebutuhan</span><div><h3>Bathroom Project</h3><p>Pengadaan dalam jumlah besar untuk kontraktor dan developer.</p></div></a>
            <a href="/solusi/hotel-villa" class="need"><span class="eyebrow">Kebutuhan</span><div><h3>Hotel / Villa</h3><p>Sanitary untuk kamar tamu dan area umum.</p></div></a>
        </div>
    </div>
</section>

{{-- COMBINATIONS --}}
<section class="section pt-0">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 reveal">
                <p class="eyebrow mb-3">Biar tidak ada yang terlewat</p>
                <h2 class="h-section mb-3">Produk yang sering digunakan bersama</h2>
                <p class="lead-t">Kombinasi ini paling sering dibeli customer kami. Gunakan sebagai daftar periksa sebelum memesan.</p>
            </div>
            <div class="col-lg-7 offset-lg-1 reveal">
                <a href="/produk/closet" class="combo">
                    <div class="combo-title">Closet<span class="combo-plus">+</span>Jet Spray</div>
                    <p>Banyak customer melengkapi closet dengan jet spray sekaligus.</p>
                </a>
                <a href="/produk/wastafel" class="combo">
                    <div class="combo-title">Wastafel<span class="combo-plus">+</span>Kran</div>
                    <p>Pastikan model kran cocok dengan lubang kran pada wastafel.</p>
                </a>
                <a href="/produk/kran" class="combo">
                    <div class="combo-title">Kran Cabang<span class="combo-plus">+</span>Shower</div>
                    <p>Kran cabang membagi aliran air ke lebih dari satu titik.</p>
                </a>
                <a href="/produk/accessories" class="combo">
                    <div class="combo-title">Stopkran<span class="combo-plus">+</span>Flexible</div>
                    <p>Sambungan air ke closet atau kran biasanya memakai keduanya.</p>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- PROJECT / QUOTATION --}}
<section class="section block-dark on-dark">
    <div class="container">
        <div class="row g-5 align-items-end">
            <div class="col-lg-7 reveal">
                <p class="eyebrow mb-3">Untuk proyek</p>
                <h2 class="h-section mb-4">Kebutuhan Sanitary untuk Proyek</h2>
                <p class="lead-t mb-5">Kirim daftar kebutuhan dan lokasi proyek Anda. Tim Top Sains akan menyiapkan penawaran.</p>
                <ul class="seg-list">
                    <li>Kontraktor</li><li>Developer</li><li>Hotel</li><li>Villa</li>
                    <li>Apartment</li><li>Restaurant</li><li>Commercial building</li>
                </ul>
            </div>
            <div class="col-lg-4 offset-lg-1 reveal">
                <a href="/solusi/proyek" class="btn-main w-100 justify-content-center mb-2">Request Quotation</a>
                <a href="{{ wa_url('Halo Top Sains, saya ingin meminta penawaran untuk kebutuhan sanitary proyek. Nama: ____. Lokasi proyek: ____. Kebutuhan: ____.') }}" target="_blank" rel="noopener" class="btn-line w-100 justify-content-center">Langsung via WhatsApp</a>
            </div>
        </div>
    </div>
</section>

{{-- AFTER SALES --}}
@php
    $asPoints = array_values(array_filter(preg_split('/\r?\n/', (string) setting('aftersales_points', ''))));
    if (! $asPoints) {
        $asPoints = ['[ISI LAYANAN AFTER-SALES 1]', '[ISI LAYANAN AFTER-SALES 2]', '[ISI LAYANAN AFTER-SALES 3]'];
    }
@endphp
<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 reveal">
                <p class="eyebrow mb-3">After Sales</p>
                <h2 class="display-t" style="font-size:clamp(2.4rem,5.5vw,4.2rem)">Tidak berhenti setelah pembelian.</h2>
                <p class="lead-t mt-4">Kami membantu customer setelah produk dibeli.</p>
            </div>
            <div class="col-lg-5 offset-lg-1 reveal">
                <ol class="num-list">
                    @foreach($asPoints as $point)<li>{{ $point }}</li>@endforeach
                </ol>
                <a href="/after-sales" class="link-arrow d-inline-block mt-4">Pelajari layanan after-sales</a>
            </div>
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="section pt-0">
    <div class="container">
        <h2 class="h-section mb-5 reveal">Apa Kata Customer</h2>
        @if($testimonials->isNotEmpty())
            <div class="row g-5">
                @foreach($testimonials as $t)
                    <div class="col-lg-4 reveal">
                        <figure class="t-card m-0">
                            <blockquote class="quote">“{{ $t->content }}”</blockquote>
                            <figcaption>
                                <strong>{{ $t->name }}</strong>
                                @if($t->role_company)<span class="d-block text-muted small">{{ $t->role_company }}</span>@endif
                            </figcaption>
                        </figure>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-box reveal">Tambahkan testimonial customer di CMS.</div>
        @endif
    </div>
</section>

{{-- PROJECTS --}}
<section class="section pt-0">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5 reveal">
            <h2 class="h-section">Project yang Pernah Kami Layani</h2>
            <a href="/project" class="link-arrow">Lihat semua project</a>
        </div>
        @if($projects->isNotEmpty())
            <div class="row g-4">
                @foreach($projects as $pr)
                    <div class="col-md-4 reveal">
                        <a href="/project/{{ $pr->slug }}" class="d-block">
                            <div class="proj-img">
                                @if($pr->image)<img src="{{ asset('storage/'.$pr->image) }}" alt="{{ $pr->name }}, {{ $pr->location }}" width="800" height="600" loading="lazy">@else<span class="ph">Foto project</span>@endif
                            </div>
                            <div class="eyebrow">{{ $pr->type }}{{ $pr->type && $pr->location ? ' — ' : '' }}{{ $pr->location }}</div>
                            <h3 class="fs-5 mt-1">{{ $pr->name }}</h3>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-box reveal">Tambahkan project di CMS.</div>
        @endif
    </div>
</section>

{{-- SHOWROOM --}}
<section class="section pt-0">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 reveal">
                <p class="eyebrow mb-3">Lokasi</p>
                <h2 class="h-section mb-4">Kunjungi Showroom Top Sains</h2>
                <div class="info-row"><div class="eyebrow">Alamat</div>{!! nl2br(e(setting('address', '[ISI ALAMAT TOKO]'))) !!}</div>
                <div class="info-row"><div class="eyebrow">Jam buka</div>{!! nl2br(e(setting('opening_hours', '[ISI JAM BUKA]'))) !!}</div>
                <div class="info-row"><div class="eyebrow">Area layanan</div>Bogor, Jakarta, BSD, dan sekitarnya</div>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    @if(setting('maps_url'))<a href="{{ setting('maps_url') }}" target="_blank" rel="noopener" class="btn-main">Buka Google Maps</a>@endif
                    <a href="{{ wa_url('Halo Top Sains, saya ingin berkunjung ke showroom. Boleh tahu jam buka dan lokasinya?') }}" target="_blank" rel="noopener" class="btn-line">Hubungi WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-7 reveal">
                <div class="map-box">
                    @if(setting('maps_embed'))
                        <iframe src="{{ setting('maps_embed') }}" title="Lokasi Top Sains Bangunan di Google Maps" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <span class="ph">[ISI GOOGLE MAPS EMBED]</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection