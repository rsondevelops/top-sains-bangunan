<div class="row g-5 align-items-center">
    <div class="col-lg-5">
        <h2 class="h-section mb-4">Kunjungi Showroom Top Sains</h2>
        <div class="info-row"><div class="eyebrow">Alamat</div>{!! nl2br(e(setting('address', '[ISI ALAMAT TOKO]'))) !!}</div>
        <div class="info-row"><div class="eyebrow">Jam buka</div>{!! nl2br(e(setting('opening_hours', '[ISI JAM BUKA]'))) !!}</div>
        <div class="info-row"><div class="eyebrow">Area layanan</div>Bogor, Jakarta, BSD, dan sekitarnya</div>
        <div class="d-flex flex-wrap gap-2 mt-4">
            @if(setting('maps_url'))<a href="{{ setting('maps_url') }}" target="_blank" rel="noopener" class="btn-main">Buka Google Maps</a>@endif
            <a href="{{ wa_url('Halo Top Sains, saya ingin berkunjung ke showroom. Boleh tahu jam buka dan lokasinya?') }}" target="_blank" rel="noopener" class="btn-line">Hubungi WhatsApp</a>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="map-box">
            @if(setting('maps_embed'))
                <iframe src="{{ setting('maps_embed') }}" title="Lokasi Top Sains Bangunan di Google Maps" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            @else
                <span class="ph">[ISI GOOGLE MAPS EMBED]</span>
            @endif
        </div>
    </div>
</div>