@extends('layouts.app')

@section('title', $seg['title'].' di Bogor, Jakarta & BSD | Top Sains Bangunan')
@section('description', $seg['description'])

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Solusi','/solusi/proyek'],[$seg['h1'],null]]" />

        <div class="row g-5 mt-1">
            <div class="col-lg-6">
                <p class="eyebrow mb-3">Untuk proyek</p>
                <h1 class="display-t mb-4" style="font-size:clamp(2.2rem,5vw,3.8rem)">{{ $seg['h1'] }}</h1>
                <p class="lead-t mb-5">{{ $seg['intro'] }}</p>

                <h2 class="fs-4 mb-3">Siapkan ini agar penawaran lebih cepat</h2>
                <ol class="num-list mb-4">
                    @foreach($seg['prep'] as $p)<li>{{ $p }}</li>@endforeach
                </ol>

                <div class="d-flex flex-wrap gap-3">
                    <a href="/produk" class="link-arrow">Lihat katalog produk</a>
                    <a href="/project" class="link-arrow">Project yang pernah kami layani</a>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4 pt-4 border-top">
                    @foreach(['proyek' => 'Proyek umum', 'kontraktor' => 'Kontraktor', 'developer' => 'Developer', 'hotel-villa' => 'Hotel & Villa'] as $s => $l)
                        <a href="/solusi/{{ $s }}" class="chip {{ $slug === $s ? 'on' : '' }}">{{ $l }}</a>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-panel">
                    <h2 class="fs-3 mb-1">Request Quotation</h2>
                    <p class="text-muted mb-4">Isi data singkat. Tim Top Sains akan menghubungi Anda lewat WhatsApp.</p>
                    <x-quotation-form />
                </div>
            </div>
        </div>
    </div>
</section>
@endsection