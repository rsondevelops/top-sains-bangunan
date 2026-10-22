@extends('layouts.app')

@section('title', 'Halaman tidak ditemukan | Top Sains Bangunan')
@section('description', 'Halaman yang Anda cari tidak ditemukan. Cari produk sanitary atau hubungi tim Top Sains via WhatsApp.')
@section('robots', 'noindex,follow')

@section('content')
<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7">
                <p class="eyebrow mb-3">Error 404</p>
                <h1 class="display-t mb-4">Halaman ini tidak ditemukan.</h1>
                <p class="lead-t mb-4">Alamatnya mungkin salah ketik, atau produknya sudah tidak ditampilkan. Cari langsung di katalog, atau tanyakan ke tim kami.</p>

                <form method="get" action="/produk" class="nf-search mb-4" role="search">
                    <input type="search" name="q" placeholder="Cari nama atau SKU produk" aria-label="Cari produk">
                    <button type="submit" class="btn-main">Cari</button>
                </form>

                <div class="d-flex flex-wrap gap-2">
                    <a href="/produk" class="btn-line">Lihat Semua Produk</a>
                    <a href="{{ wa_url('Halo Top Sains, saya mencari produk sanitary tapi halaman di website tidak ditemukan. Bisa dibantu?') }}" target="_blank" rel="noopener" class="btn-main">Tanya via WhatsApp</a>
                </div>
            </div>

            <div class="col-lg-4 offset-lg-1">
                <p class="eyebrow mb-3">Mungkin yang Anda cari</p>
                <a href="/produk/closet" class="index-row"><span class="fs-5 fw-semibold">Closet</span><span class="idx-meta">→</span></a>
                <a href="/produk/wastafel" class="index-row"><span class="fs-5 fw-semibold">Wastafel</span><span class="idx-meta">→</span></a>
                <a href="/produk/kran" class="index-row"><span class="fs-5 fw-semibold">Kran</span><span class="idx-meta">→</span></a>
                <a href="/bantu-memilih" class="index-row"><span class="fs-5 fw-semibold">Bantu Saya Memilih</span><span class="idx-meta">→</span></a>
                <a href="/solusi/proyek" class="index-row"><span class="fs-5 fw-semibold">Request Quotation</span><span class="idx-meta">→</span></a>
            </div>
        </div>
    </div>
</section>
@endsection