<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Top Sains Bangunan: Sanitary & TOTO di Bogor')</title>
    <meta name="description" content="@yield('description', 'Katalog dan showroom sanitary TOTO di Bogor. Melayani rumah, renovasi, dan proyek di Bogor, Jakarta, dan BSD.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <script>document.documentElement.classList.add('js')</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    @stack('head')
</head>
<body>
    @include('partials.header')

    <main>@yield('content')</main>

    @include('partials.footer')

    <div class="sticky-wa d-lg-none">
        <a class="btn-main" href="@yield('wa', wa_url('Halo Top Sains, saya ingin bertanya tentang produk sanitary.'))" target="_blank" rel="noopener">WhatsApp Top Sains</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/site.js') }}" defer></script>
</body>
</html>