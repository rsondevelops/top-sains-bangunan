@php
    $nav = [
        'Produk' => '/produk', 'Solusi' => '/solusi/proyek', 'Project' => '/project',
        'After Sales' => '/after-sales', 'Artikel' => '/artikel', 'Tentang Kami' => '/tentang-kami',
    ];
    $waGeneral = wa_url('Halo Top Sains, saya ingin bertanya tentang produk sanitary.');
@endphp

<header class="site-header">
    <div class="container bar">
        <a href="/" class="brand" aria-label="Top Sains Bangunan">
            <img src="{{ asset('img/logo.svg') }}" alt="Top Sains Bangunan" height="34">
        </a>

        <nav class="nav-d d-none d-lg-flex" aria-label="Navigasi utama">
            @foreach($nav as $label => $href)
                <a href="{{ $href }}">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ $waGeneral }}" target="_blank" rel="noopener" class="btn-main btn-sm-t">WhatsApp</a>
            <button class="menu-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#menu" aria-controls="menu">Menu</button>
        </div>
    </div>
</header>

<div class="offcanvas offcanvas-end w-100" tabindex="-1" id="menu" aria-label="Menu">
    <div class="offcanvas-header container">
        <span class="eyebrow">Menu</span>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
    </div>
    <div class="offcanvas-body container offcanvas-nav">
        @foreach($nav as $label => $href)
            <a href="{{ $href }}">{{ $label }}</a>
        @endforeach
        <a href="/bantu-memilih" class="text-primary" style="color:var(--primary)">Bantu Saya Memilih</a>
        <div class="mt-4">
            <a href="{{ $waGeneral }}" target="_blank" rel="noopener" class="btn-main w-100 justify-content-center">Konsultasi via WhatsApp</a>
        </div>
    </div>
</div>