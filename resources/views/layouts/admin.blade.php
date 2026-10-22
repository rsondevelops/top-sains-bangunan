@php
    $newLeads = \App\Models\Lead::where('status', 'new')->count();
    $menu = [
        ['Dashboard', '/dashboard', 'dashboard'],
        'Catalog',
        ['Products', '/dashboard/products', 'dashboard/products*'],
        ['Categories', '/dashboard/categories', 'dashboard/categories*'],
        ['Brands', '/dashboard/brands', 'dashboard/brands*'],
        'Content',
        ['Testimonials', '/dashboard/testimonials', 'dashboard/testimonials*'],
        ['Articles', '/dashboard/articles', 'dashboard/articles*'],
        ['Projects', '/dashboard/projects', 'dashboard/projects*'],
        'Lainnya',
        ['Leads', '/dashboard/leads', 'dashboard/leads*', $newLeads],
        ['Settings', '/dashboard/settings', 'dashboard/settings*'],
    ];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'Admin') · Top Sains</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f6f6f8}
        .adm-side{background:#fff;border-right:1px solid #dee2e6;padding:1rem}
        .side-h{font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6c757d;margin:1.25rem 0 .35rem;padding:0 .75rem}
        .side-a{display:flex;justify-content:space-between;align-items:center;padding:.45rem .75rem;border-radius:6px;color:#212529;text-decoration:none;font-size:.95rem;border:0;background:none;width:100%;text-align:left}
        .side-a:hover{background:#f1f3f5;color:#212529}
        .side-a.on{background:#212529;color:#fff}
        .adm-main{padding:1.25rem;flex:1;min-width:0}
        @media(min-width:992px){.adm{display:flex}.adm-side{width:250px;flex:none;position:sticky;top:0;height:100vh;overflow:auto}.adm-main{padding:2rem}}
    </style>
</head>
<body>
<nav class="navbar bg-white border-bottom d-lg-none px-3">
    <span class="fw-semibold">Top Sains Admin</span>
    <button class="btn btn-sm btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#side">Menu</button>
</nav>

<div class="adm">
    <aside id="side" class="adm-side collapse d-lg-block">
        <div class="fw-semibold fs-5 px-2 mb-2 d-none d-lg-block">Top Sains Admin</div>
        @foreach($menu as $m)
            @if(is_string($m))
                <div class="side-h">{{ $m }}</div>
            @else
                <a href="{{ $m[1] }}" class="side-a {{ request()->is($m[2]) ? 'on' : '' }}">
                    <span>{{ $m[0] }}</span>
                    @if(! empty($m[3]))<span class="badge text-bg-danger">{{ $m[3] }}</span>@endif
                </a>
            @endif
        @endforeach
        <div class="side-h">Akun</div>
        <a href="/" target="_blank" class="side-a">Lihat website ↗</a>
        <form method="post" action="/logout">@csrf<button class="side-a" type="submit">Keluar</button></form>
    </aside>

    <main class="adm-main">
        @if(session('ok'))<div class="alert alert-success alert-dismissible fade show">{{ session('ok') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('err'))<div class="alert alert-danger alert-dismissible fade show">{{ session('err') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>