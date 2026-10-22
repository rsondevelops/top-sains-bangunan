@extends('layouts.app')

@section('title', 'After Sales | Top Sains Bangunan')
@section('description', 'Layanan after-sales Top Sains Bangunan: bantuan untuk customer setelah produk sanitary dibeli.')

@php
    $points = array_values(array_filter(preg_split('/\r?\n/', (string) setting('aftersales_points', ''))));
    if (! $points) $points = ['[ISI LAYANAN AFTER-SALES 1]', '[ISI LAYANAN AFTER-SALES 2]', '[ISI LAYANAN AFTER-SALES 3]'];
@endphp

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['After Sales',null]]" />
        <div class="row g-5 mt-1">
            <div class="col-lg-6">
                <p class="eyebrow mb-3">After Sales</p>
                <h1 class="display-t" style="font-size:clamp(2.4rem,5.5vw,4.2rem)">Tidak berhenti setelah pembelian.</h1>
                <p class="lead-t mt-4">Kami membantu customer setelah produk dibeli.</p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="{{ wa_url('Halo Top Sains, saya ingin bertanya tentang layanan after-sales untuk produk yang sudah saya beli.') }}" target="_blank" rel="noopener" class="btn-main">Tanya via WhatsApp</a>
                    <a href="/produk/spare-part" class="btn-line">Lihat Spare Part</a>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <ol class="num-list">@foreach($points as $p)<li>{{ $p }}</li>@endforeach</ol>
            </div>
        </div>
    </div>
</section>
@endsection