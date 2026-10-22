<footer class="site-footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <a href="/" class="brand d-inline-block mb-3"><img src="{{ asset('img/logo.svg') }}" alt="Top Sains Bangunan" height="34"></a>
                <p style="max-width:22rem">Toko sanitary dan perlengkapan kamar mandi di Bogor. Melayani kebutuhan rumah, renovasi, dan proyek di Bogor, Jakarta, BSD, dan sekitarnya.</p>
            </div>
            <div class="col-6 col-lg-2">
                <h4>Produk</h4>
                <ul>
                    @foreach(['Closet','Wastafel','Shower','Kran','Urinoir','Accessories','Spare Part'] as $c)
                        <li><a href="/produk/{{ Str::slug($c) }}">{{ $c }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h4>Halaman</h4>
                <ul>
                    <li><a href="/bantu-memilih">Bantu Saya Memilih</a></li>
                    <li><a href="/solusi/proyek">Solusi Proyek</a></li>
                    <li><a href="/project">Project</a></li>
                    <li><a href="/after-sales">After Sales</a></li>
                    <li><a href="/artikel">Artikel</a></li>
                    <li><a href="/tentang-kami">Tentang Kami</a></li>
                    <li><a href="/sanitary-bogor">Sanitary Bogor</a></li>
                    <li><a href="/toto-bogor">TOTO Bogor</a></li>
                    <li><a href="/sanitary-jakarta">Sanitary Jakarta</a></li>
                    <li><a href="/sanitary-bsd">Sanitary BSD</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h4>Kontak</h4>
                <ul>
                    <li>{!! nl2br(e(setting('address', '[ISI ALAMAT TOKO]'))) !!}</li>
                    <li><a href="{{ wa_url('Halo Top Sains, saya ingin bertanya.') }}" target="_blank" rel="noopener">WhatsApp: {{ setting('whatsapp_number', '[ISI NOMOR WHATSAPP]') }}</a></li>
                    @if(setting('phone'))<li>Telepon: {{ setting('phone') }}</li>@endif
                    <li>{!! nl2br(e(setting('opening_hours', '[ISI JAM BUKA]'))) !!}</li>
                    @if(setting('maps_url'))<li><a href="{{ setting('maps_url') }}" target="_blank" rel="noopener">Buka Google Maps</a></li>@endif
                    @if(setting('instagram'))<li><a href="{{ setting('instagram') }}" target="_blank" rel="noopener">Instagram</a></li>@endif
                </ul>
            </div>
        </div>
        <div class="foot-bottom">© {{ date('Y') }} Top Sains Bangunan. Hak cipta dilindungi.</div>
    </div>
</footer>