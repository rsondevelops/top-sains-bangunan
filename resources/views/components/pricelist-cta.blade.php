@props(['variant' => 'band'])

@php
    // Query ringan, di-cache sebagai array biasa (aman, bukan objek Eloquent)
    $docs = \Illuminate\Support\Facades\Cache::remember('downloads_cta', 600, fn () =>
        \App\Models\Download::where('is_active', true)->orderBy('sort_order')->latest()->get()
            ->map(fn ($d) => [
                'title' => $d->title,
                'type'  => \App\Models\Download::TYPES[$d->type] ?? $d->type,
                'period'=> $d->period,
                'link'  => $d->link,
            ])->all()
    );
    $wa = wa_url('Halo Top Sains, saya ingin meminta pricelist dan katalog TOTO terbaru. Produk yang saya cari: ____');
@endphp

<section class="plc plc-{{ $variant }}" aria-labelledby="plc-title">
    <div class="container">
        <div class="plc-inner">
            <div class="plc-text">
                <p class="eyebrow mb-2">Pricelist &amp; Katalog</p>
                <h2 id="plc-title" class="plc-h">Produk yang tampil di sini hanya yang paling banyak dicari.</h2>
                <p class="plc-p">Daftar lengkap ada di pricelist, fitting catalog, dan katalog TOTO. Tidak menemukan produknya? Tanyakan langsung.</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a href="/katalog-pricelist" class="btn-main">Lihat Pricelist &amp; Katalog</a>
                    <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn-line">Minta via WhatsApp</a>
                </div>
            </div>

            @if(count($docs))
            <ul class="plc-list">
                @foreach(array_slice($docs, 0, 4) as $d)
                    <li>
                        <a href="{{ $d['link'] }}" target="_blank" rel="noopener">
                            <span><small>{{ $d['type'] }}</small>{{ $d['title'] }}@if($d['period'])<em>{{ $d['period'] }}</em>@endif</span>
                            <span aria-hidden="true">PDF ↗</span>
                        </a>
                    </li>
                @endforeach
                @if(count($docs) > 4)
                    <li><a href="/katalog-pricelist"><span>Lihat semua {{ count($docs) }} dokumen</span><span aria-hidden="true">→</span></a></li>
                @endif
            </ul>
            @endif
        </div>
    </div>
</section>