@extends('layouts.app')

@section('title', 'Pricelist & Katalog TOTO | Top Sains Bangunan Bogor')
@section('description', 'Pricelist, fitting catalog, dan katalog produk TOTO. Tanyakan harga dan ketersediaan terbaru langsung via WhatsApp ke Top Sains Bangunan, Bogor.')

@section('content')
@php
    $waGeneral = wa_url('Halo Top Sains, saya ingin meminta pricelist TOTO terbaru.');
    $types = \App\Models\Download::TYPES;
@endphp
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Pricelist & Katalog',null]]" />

        <div class="row g-5 mt-1 mb-5">
            <div class="col-lg-7">
                <p class="eyebrow mb-3">Unduh</p>
                <h1 class="display-t mb-4" style="font-size:clamp(2.2rem,5vw,3.8rem)">Pricelist &amp; Katalog TOTO</h1>
                <p class="lead-t" style="max-width:none">Buka pricelist, fitting catalog, dan katalog produk dalam format PDF. Harga dan ketersediaan bisa berubah, jadi konfirmasi dulu ke tim kami sebelum memesan.</p>
            </div>
            <div class="col-lg-4 offset-lg-1 align-self-end">
                <a href="{{ $waGeneral }}" target="_blank" rel="noopener" class="btn-main w-100 justify-content-center">Minta Pricelist Terbaru via WhatsApp</a>
            </div>
        </div>

        @forelse($types as $key => $label)
            @if(isset($groups[$key]))
                <h2 class="fs-3 mt-5 mb-3">{{ $label }}</h2>
                @foreach($groups[$key] as $d)
                    <div class="dl-row">
                        <div>
                            <div class="dl-title">{{ $d->title }}</div>
                            @if($d->period)<div class="dl-meta">{{ $d->period }}</div>@endif
                            @if($d->description)<p class="text-muted mb-0 mt-1">{{ $d->description }}</p>@endif
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ $d->link }}" target="_blank" rel="noopener" class="btn-line btn-sm-t">Buka PDF</a>
                            @if($d->file)
                                <a href="{{ asset('storage/'.$d->file) }}" download="{{ \Illuminate\Support\Str::slug($d->title) }}.pdf" class="btn-line btn-sm-t">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    Download
                                </a>
                            @endif
                            <a href="{{ wa_url('Halo Top Sains, saya melihat "'.$d->title.'" di website. Saya ingin menanyakan harga dan ketersediaan produknya.') }}" target="_blank" rel="noopener" class="btn-main btn-sm-t">Tanya via WhatsApp</a>
                        </div>
                    </div>
                @endforeach
            @endif
        @empty
        @endforelse

        @if($groups->isEmpty())
            <div class="empty-box">Dokumen belum tersedia. Minta langsung lewat WhatsApp, tim kami kirimkan.</div>
        @endif

        <div class="consult mt-5">
            <div>
                <h2 class="fs-3 mb-1">Tidak menemukan produknya?</h2>
                <p class="mb-0 text-muted">Sebutkan kode atau foto produk yang Anda cari. Kami cek ketersediaan dan harganya.</p>
            </div>
            <a href="{{ $waGeneral }}" target="_blank" rel="noopener" class="btn-main">Tanya via WhatsApp</a>
        </div>
    </div>
</section>
@endsection