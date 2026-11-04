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
                <span class="ph"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2356.456799313313!2d106.83067260838857!3d-6.637962271240364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c9c41bcc1e89%3A0x235274227349a04c!2sTOP%20SAINS%20BANGUNAN!5e0!3m2!1sid!2sid!4v1793273671752!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe></span>
            @endif
        </div>
    </div>
</div>