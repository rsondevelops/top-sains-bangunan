@php
    $newLeads = \App\Models\Lead::where('status', 'new')->count();
    $menu = [
        ['Dashboard', '/dashboard', 'dashboard', 'home'],
        'Catalog',
        ['Products', '/dashboard/products', 'dashboard/products*', 'box'],
        ['Categories', '/dashboard/categories', 'dashboard/categories*', 'tag'],
        ['Brands', '/dashboard/brands', 'dashboard/brands*', 'award'],
        'Content',
        ['Testimonials', '/dashboard/testimonials', 'dashboard/testimonials*', 'message'],
        ['Articles', '/dashboard/articles', 'dashboard/articles*', 'file'],
        ['Projects', '/dashboard/projects', 'dashboard/projects*', 'briefcase'],
        'Sales',
        ['Leads', '/dashboard/leads', 'dashboard/leads*', 'users', $newLeads],
        'Sistem',
        ['Settings', '/dashboard/settings', 'dashboard/settings*', 'settings'],
    ];
    $user = auth()->user();
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'Admin') · Top Sains</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}" rel="stylesheet">
</head>
<body class="adm-body">
<div class="shell">

    <aside class="side" id="side" aria-label="Navigasi admin">
        <div class="side-top">
            <div class="logo-mark">TS</div>
            <div class="logo-text">Top Sains<small>Admin panel</small></div>
        </div>

        <nav class="side-nav">
            @foreach($menu as $m)
                @if(is_string($m))
                    <div class="nav-h">{{ $m }}</div>
                @else
                    <a href="{{ $m[1] }}" class="nav-a {{ request()->is($m[2]) ? 'on' : '' }}">
                        <x-icon :name="$m[3]" />
                        <span>{{ $m[0] }}</span>
                        @if(! empty($m[4]))<span class="nav-count">{{ $m[4] }}</span>@endif
                    </a>
                @endif
            @endforeach
        </nav>

        <div class="side-user">
            <div class="avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</div>
            <div class="u-info"><b>{{ $user->name }}</b><span>{{ $user->email }}</span></div>
            <form method="post" action="/logout">@csrf
                <button class="icon-btn" type="submit" title="Keluar" aria-label="Keluar"><x-icon name="logout" /></button>
            </form>
        </div>
    </aside>
    <div class="scrim" id="scrim"></div>

    <div class="content">
        <header class="topbar">
            <button class="icon-btn menu-toggle" id="menuBtn" type="button" aria-label="Buka menu"><x-icon name="menu" size="20" /></button>
            <h2>@yield('title', 'Admin')</h2>
            <span class="sp"></span>
            <a href="/" target="_blank" class="btn btn-outline-dark btn-sm">Lihat website <x-icon name="external" size="14" /></a>
        </header>

        <main class="main">
            @if(session('ok'))<div class="alert alert-success alert-dismissible fade show">{{ session('ok') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
            @if(session('err'))<div class="alert alert-danger alert-dismissible fade show">{{ session('err') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const b = document.body;
    document.getElementById('menuBtn').addEventListener('click', () => b.classList.toggle('nav-open'));
    document.getElementById('scrim').addEventListener('click', () => b.classList.remove('nav-open'));
</script>
@stack('scripts')
</body>
</html>