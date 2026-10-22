@extends('layouts.app')

@php
    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $article->title,
        'description' => $article->meta_description ?: $article->excerpt,
        'image' => $article->image ? [asset('storage/'.$article->image)] : null,
        'datePublished' => $article->published_at->toIso8601String(),
        'dateModified' => $article->updated_at->toIso8601String(),
        'mainEntityOfPage' => url('/artikel/'.$article->slug),
        'author' => ['@type' => 'Organization', 'name' => 'Top Sains Bangunan'],
        'publisher' => ['@type' => 'Organization', 'name' => 'Top Sains Bangunan', 'logo' => ['@type' => 'ImageObject', 'url' => asset('img/logo.svg')]],
    ]);
@endphp

@section('title', ($article->meta_title ?: $article->title).' | Top Sains Bangunan')
@section('description', \Illuminate\Support\Str::limit($article->meta_description ?: $article->excerpt ?: $article->title, 158))

@push('head')
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
<article class="pt-4 pb-5">
    <div class="container" style="max-width:820px">
        <x-breadcrumb :items="[['Beranda','/'],['Artikel','/artikel'],[$article->title,null]]" />
        <p class="eyebrow mt-4 mb-2">{{ $article->published_at->translatedFormat('d F Y') }}</p>
        <h1 class="h-section mb-4">{{ $article->title }}</h1>
        @if($article->image)
            <div class="proj-img mb-4"><img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" width="1200" height="900" fetchpriority="high"></div>
        @endif
        <div class="prose">{!! \Illuminate\Support\Str::markdown($article->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>

        <div class="consult mt-5">
            <div>
                <h2 class="fs-3 mb-1">Ada pertanyaan soal produk?</h2>
                <p class="mb-0 text-muted">Tanyakan langsung ke tim Top Sains.</p>
            </div>
            <a href="{{ wa_url('Halo Top Sains, saya membaca artikel "'.$article->title.'" dan ingin bertanya.') }}" target="_blank" rel="noopener" class="btn-main">Tanya via WhatsApp</a>
        </div>
    </div>
</article>
@endsection