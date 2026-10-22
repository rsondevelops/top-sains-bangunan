@extends('layouts.app')

@section('title', $page['title'].' | Top Sains Bangunan')
@section('description', $page['description'])

@push('head')<x-local-schema />@endpush

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],[$page['h1'],null]]" />

        <div class="row g-5 mt-1">
            <div class="col-lg-7">
                <h1 class="display-t mb-4" style="font-size:clamp(2.2rem,5vw,3.8rem)">{{ $page['h1'] }}</h1>
                <p class="lead-t mb-4" style="max-width:none">{{ $page['intro'] }}</p>
                @foreach($page['body'] as $para)<p class="text-muted">{{ $para }}</p>@endforeach
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="/produk" class="btn-main">Lihat Katalog</a>
                    <a href="{{ wa_url('Halo Top Sains, saya ingin bertanya tentang produk sanitary.') }}" target="_blank" rel="noopener" class="btn-line">Tanya via WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-1">
                <p class="eyebrow mb-3">Mulai dari sini</p>
                <a href="/bantu-memilih" class="index-row"><span class="fs-5 fw-semibold">Bantu Saya Memilih</span><span class="idx-meta">→</span></a>
                <a href="/solusi/proyek" class="index-row"><span class="fs-5 fw-semibold">Request Quotation</span><span class="idx-meta">→</span></a>
                <a href="/after-sales" class="index-row"><span class="fs-5 fw-semibold">After Sales</span><span class="idx-meta">→</span></a>
            </div>
        </div>

        @if($products->isNotEmpty())
        <div class="mt-5 pt-5">
            <h2 class="h-section mb-4" style="font-size:clamp(1.75rem,3vw,2.4rem)">Best Seller</h2>
            <div class="row g-4 row-cols-2 row-cols-lg-4">
                @foreach($products as $p)<div class="col"><x-product-card :product="$p" /></div>@endforeach
            </div>
        </div>
        @endif

        <div class="mt-5 pt-5 border-top"><x-showroom /></div>
    </div>
</section>
@endsection