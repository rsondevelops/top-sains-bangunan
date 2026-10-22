@extends('layouts.app')

@section('title', 'Tentang Top Sains Bangunan | Showroom Sanitary di Bogor')
@section('description', 'Kenali Top Sains Bangunan, toko sanitary dan perlengkapan kamar mandi di Bogor yang melayani retail dan proyek.')

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Tentang Kami',null]]" />
        <div class="row g-5 mt-1">
            <div class="col-lg-7">
                <p class="eyebrow mb-3">Tentang kami</p>
                <h1 class="display-t mb-4" style="font-size:clamp(2.2rem,5vw,3.8rem)">Top Sains Bangunan</h1>
                <div class="lead-t" style="max-width:none">{!! nl2br(e(setting('about_story', '[ISI CERITA TOP SAINS: sejarah, siapa yang mengelola, dan fokus bisnis. Isi dari Settings.]'))) !!}</div>
            </div>
            <div class="col-lg-4 offset-lg-1">
                <div class="info-row"><div class="eyebrow">Lokasi</div>Bogor</div>
                <div class="info-row"><div class="eyebrow">Melayani</div>Retail dan proyek</div>
                <div class="info-row"><div class="eyebrow">Area layanan</div>Bogor, Jakarta, BSD, dan sekitarnya</div>
                @if(setting('year_established'))<div class="info-row"><div class="eyebrow">Berdiri</div>Sejak {{ setting('year_established') }}</div>@endif
                <div class="info-row"><div class="eyebrow">Brand</div>TOTO</div>
            </div>
        </div>
    </div>
</section>
<section class="section pt-0"><div class="container"><x-showroom /></div></section>
@endsection