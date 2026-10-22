@extends('layouts.app')

@section('title', 'Bantu Saya Memilih Sanitary | Top Sains Bangunan')
@section('description', 'Jawab empat pertanyaan singkat tentang kamar mandi Anda, lalu lihat rekomendasi produk sanitary dari Top Sains Bangunan.')

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Bantu Saya Memilih',null]]" />

        <div class="row g-5 mt-1">
            <div class="col-lg-4">
                <div class="sticky-col">
                    <p class="eyebrow mb-3">Rekomendasi</p>
                    <h1 class="h-section mb-3">Bantu Saya Memilih Sanitary</h1>
                    <p class="lead-t">Jawab empat pertanyaan singkat. Kami tampilkan produk yang paling relevan, lalu tim Top Sains membantu sisanya lewat WhatsApp.</p>
                </div>
            </div>

            <div class="col-lg-8">
                <form method="get" action="/bantu-memilih#hasil">
                    <input type="hidden" name="cari" value="1">

                    <fieldset class="q">
                        <legend><span>01</span>Apa yang sedang Anda buat?</legend>
                        <div class="opts">
                            @foreach($usages as $k => $v)
                                <label class="opt"><input type="radio" name="usage" value="{{ $k }}" @checked($input['usage'] === $k)><span>{{ $v }}</span></label>
                            @endforeach
                        </div>
                    </fieldset>

                    <fieldset class="q">
                        <legend><span>02</span>Gaya yang Anda inginkan?</legend>
                        <div class="opts">
                            @foreach($styles as $k => $v)
                                <label class="opt"><input type="radio" name="style" value="{{ $k }}" @checked($input['style'] === $k)><span>{{ $v }}</span></label>
                            @endforeach
                        </div>
                    </fieldset>

                    <fieldset class="q">
                        <legend><span>03</span>Apa yang Anda butuhkan?</legend>
                        <div class="opts">
                            @foreach($categories as $c)
                                <label class="opt"><input type="checkbox" name="needs[]" value="{{ $c->slug }}" @checked(in_array($c->slug, $input['needs']))><span>{{ $c->name }}</span></label>
                            @endforeach
                        </div>
                    </fieldset>

                    <fieldset class="q">
                        <legend><span>04</span>Budget kira-kira?</legend>
                        <div class="opts">
                            @foreach($ranges as $k => $r)
                                <label class="opt"><input type="radio" name="budget" value="{{ $k }}" @checked($input['budget'] === (string) $k)><span>{{ $r[0] }}</span></label>
                            @endforeach
                            <label class="opt"><input type="radio" name="budget" value="belum-tahu" @checked($input['budget'] === 'belum-tahu')><span>Belum tahu</span></label>
                        </div>
                    </fieldset>

                    <button type="submit" class="btn-main mt-3">Lihat Rekomendasi</button>
                </form>
            </div>
        </div>

        {{-- Hasil --}}
        @if($results !== null)
        <div id="hasil" class="mt-5 pt-5 border-top">
            <p class="eyebrow mb-3">Hasil</p>
            <h2 class="h-section mb-5">Rekomendasi Top Sains</h2>

            @if(empty($results))
                <div class="empty-box">Pilih minimal satu kebutuhan produk (langkah 03), lalu coba lagi.</div>
            @else
                @foreach($results as $g)
                    <div class="mb-5">
                        <h3 class="fs-4 mb-4">{{ $g['category']->name }}</h3>
                        @if($g['products']->isNotEmpty())
                            <div class="row g-4 row-cols-2 row-cols-lg-3">
                                @foreach($g['products'] as $p)<div class="col"><x-product-card :product="$p" /></div>@endforeach
                            </div>
                        @else
                            <div class="empty-box">Belum ada pilihan {{ strtolower($g['category']->name) }} di rentang budget ini. Tanyakan alternatifnya ke tim kami.</div>
                        @endif
                    </div>
                @endforeach

                @php
                    $msg = 'Halo Top Sains, saya ingin minta rekomendasi sanitary. '
                        .'Untuk: '.($usages[(string) $input['usage']] ?? '-').'. '
                        .'Gaya: '.($styles[(string) $input['style']] ?? '-').'. '
                        .'Produk: '.collect($results)->pluck('category.name')->join(', ').'. '
                        .'Budget: '.($ranges[(string) $input['budget']][0] ?? 'belum tahu').'.';
                @endphp
                <div class="consult">
                    <div>
                        <h3 class="fs-3 mb-1">Ingin rekomendasi yang lebih tepat?</h3>
                        <p class="mb-0 text-muted">Kirim pilihan Anda ke tim Top Sains. Kami bantu cek ketersediaan dan harga.</p>
                    </div>
                    <a href="{{ wa_url($msg) }}" target="_blank" rel="noopener" class="btn-main">Kirim ke WhatsApp</a>
                </div>
            @endif
        </div>
        @endif
    </div>
</section>
@endsection