@extends('layouts.app')

@section('title', 'Kontak & Lokasi Showroom | Top Sains Bangunan')
@section('description', 'Alamat showroom, jam buka, nomor WhatsApp, dan peta lokasi Top Sains Bangunan di Bogor.')

@push('head')<x-local-schema />@endpush

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Kontak',null]]" />
        <h1 class="h-section my-4">Kontak</h1>
        <p class="lead-t mb-5">Cara tercepat adalah WhatsApp. Sebutkan produk atau kebutuhan Anda, tim kami akan membalas.</p>
        <a href="{{ wa_url('Halo Top Sains, saya ingin bertanya tentang produk sanitary.') }}" target="_blank" rel="noopener" class="btn-main mb-5">WhatsApp Top Sains</a>
        <div class="mt-5 pt-5 border-top"><x-showroom /></div>
        @if(setting('phone'))<p class="mt-4 text-muted">Telepon: {{ setting('phone') }}</p>@endif
    </div>
</section>
@endsection