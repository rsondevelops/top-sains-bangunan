@extends('layouts.app')

@section('title', 'Artikel Sanitary & Kamar Mandi | Top Sains Bangunan')
@section('description', 'Panduan memilih sanitary, tips renovasi kamar mandi, dan informasi produk dari Top Sains Bangunan.')

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Artikel',null]]" />
        <h1 class="h-section my-4">Artikel</h1>

        @if($articles->isNotEmpty())
            <div class="row g-4 g-lg-5">
                @foreach($articles as $a)
                    <div class="col-md-6 col-lg-4">
                        <a href="/artikel/{{ $a->slug }}" class="d-block">
                            <div class="proj-img">
                                @if($a->image)<img src="{{ asset('storage/'.$a->image) }}" alt="{{ $a->title }}" width="800" height="600" loading="lazy">@else<span class="ph">Artikel</span>@endif
                            </div>
                            <div class="eyebrow">{{ $a->published_at->translatedFormat('d F Y') }}</div>
                            <h2 class="fs-5 mt-1 mb-2">{{ $a->title }}</h2>
                            @if($a->excerpt)<p class="text-muted small mb-0">{{ $a->excerpt }}</p>@endif
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 d-flex justify-content-center">{{ $articles->links() }}</div>
        @else
            <div class="empty-box">Artikel akan segera ditambahkan.</div>
        @endif
    </div>
</section>
@endsection