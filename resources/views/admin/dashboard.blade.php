@extends('layouts.admin')
@section('title', 'Dashboard')

@php
    $user = auth()->user();
    $newLeads = \App\Models\Lead::where('status', 'new')->count();

    // Leads 14 hari terakhir
    $days = collect(range(13, 0))->map(fn ($i) => now()->subDays($i)->startOfDay());
    $byDay = \App\Models\Lead::where('created_at', '>=', $days->first())->get()
        ->groupBy(fn ($l) => $l->created_at->format('Y-m-d'));
    $series = $days->map(fn ($d) => ['d' => $d, 'n' => isset($byDay[$d->format('Y-m-d')]) ? $byDay[$d->format('Y-m-d')]->count() : 0]);
    $peak  = max(1, $series->max('n'));
    $total = $series->sum('n');

    // Checklist kesiapan website
    $checks = [
        ['Nomor WhatsApp', setting('whatsapp_number'), '/dashboard/settings'],
        ['Alamat toko', setting('address'), '/dashboard/settings'],
        ['Jam buka', setting('opening_hours'), '/dashboard/settings'],
        ['Link & embed Google Maps', setting('maps_url') && setting('maps_embed'), '/dashboard/settings'],
        ['Poin after-sales', setting('aftersales_points'), '/dashboard/settings'],
        ['Testimonial pertama', $stats['Testimonial'] > 0, route('admin.testimonials.create')],
        ['Project pertama', $stats['Project'] > 0, route('admin.projects.create')],
    ];
    $doneCount = collect($checks)->filter(fn ($c) => (bool) $c[1])->count();
    $pct = (int) round($doneCount / count($checks) * 100);

    $labels = ['new' => 'Baru', 'contacted' => 'Dihubungi', 'closed' => 'Selesai'];
@endphp

@section('content')

<div class="pg-head">
    <div>
        <h1>Halo, {{ $user->name }}</h1>
        <p>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }} · Ringkasan website Top Sains</p>
    </div>
    <div class="pg-actions">
        <a href="{{ route('admin.products.create') }}" class="btn btn-dark"><x-icon name="plus" size="16" /> Tambah Produk</a>
    </div>
</div>

{{-- KPI --}}
<div class="kpis">
    <a href="/dashboard/leads" class="kpi {{ $newLeads ? 'hot' : '' }}">
        <div class="kpi-top">Leads baru <span class="kpi-ico"><x-icon name="users" size="16" /></span></div>
        <div class="kpi-n">{{ $newLeads }}</div>
        <div class="kpi-sub">{{ $newLeads ? 'Perlu di-follow up' : 'Tidak ada yang menunggu' }}</div>
    </a>
    <a href="/dashboard/products" class="kpi">
        <div class="kpi-top">Produk <span class="kpi-ico"><x-icon name="box" size="16" /></span></div>
        <div class="kpi-n">{{ number_format($stats['Produk']) }}</div>
        <div class="kpi-sub">{{ $stats['Best seller'] }} best seller</div>
    </a>
    <a href="/dashboard/testimonials" class="kpi">
        <div class="kpi-top">Testimonial <span class="kpi-ico"><x-icon name="message" size="16" /></span></div>
        <div class="kpi-n">{{ $stats['Testimonial'] }}</div>
        <div class="kpi-sub">Dari customer</div>
    </a>
    <a href="/dashboard/articles" class="kpi">
        <div class="kpi-top">Artikel <span class="kpi-ico"><x-icon name="file" size="16" /></span></div>
        <div class="kpi-n">{{ $stats['Artikel'] }}</div>
        <div class="kpi-sub">Konten SEO</div>
    </a>
    <a href="/dashboard/projects" class="kpi">
        <div class="kpi-top">Project <span class="kpi-ico"><x-icon name="briefcase" size="16" /></span></div>
        <div class="kpi-n">{{ $stats['Project'] }}</div>
        <div class="kpi-sub">Portfolio</div>
    </a>
</div>

<div class="dash-grid">

    {{-- KIRI --}}
    <div class="stack">

        <section class="panel">
            <div class="panel-h">
                <h3>Leads masuk<small>14 hari terakhir</small></h3>
                <a href="/dashboard/leads">Lihat semua</a>
            </div>
            <div class="panel-b">
                <div class="chart-total"><b>{{ $total }}</b><span>permintaan penawaran</span></div>
                <div class="chart" role="img" aria-label="Grafik leads 14 hari terakhir">
                    @foreach($series as $s)
                        <div class="bar-col" title="{{ $s['d']->format('d M') }}: {{ $s['n'] }} lead">
                            <div class="bar {{ $s['n'] ? '' : 'zero' }}" style="height:{{ $s['n'] ? max(8, round($s['n'] / $peak * 100)) : 3 }}%"></div>
                        </div>
                    @endforeach
                </div>
                <div class="chart-x">
                    @foreach($series as $s)<span>{{ $loop->first || $loop->last || $loop->iteration % 4 === 1 ? $s['d']->format('d/m') : '' }}</span>@endforeach
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-h">
                <h3>Leads terbaru</h3>
                <a href="/dashboard/leads">Kelola</a>
            </div>
            @if($leads->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>Nama</th><th>Proyek</th><th>Waktu</th><th>Status</th></tr></thead>
                        <tbody>
                        @foreach($leads as $l)
                            <tr>
                                <td><span class="l-name">{{ $l->name }}</span><span class="l-sub">{{ $l->company ?: $l->whatsapp }}</span></td>
                                <td>{{ $l->project_type }}<span class="l-sub">{{ $l->project_location }}</span></td>
                                <td class="text-muted text-nowrap">{{ $l->created_at->locale('id')->diffForHumans() }}</td>
                                <td><span class="pill {{ $l->status }}">{{ $labels[$l->status] ?? $l->status }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty"><b>Belum ada lead</b>Permintaan penawaran dari form proyek akan muncul di sini.</div>
            @endif
        </section>
    </div>

    {{-- KANAN --}}
    <div class="stack">

        <section class="panel">
            <div class="panel-h">
                <h3>Kesiapan website<small>{{ $doneCount }} dari {{ count($checks) }} langkah selesai</small></h3>
                <b style="color:var(--primary)">{{ $pct }}%</b>
            </div>
            <div class="panel-b">
                <div class="progress-x"><i style="width:{{ $pct }}%"></i></div>
                <ul class="check-list">
                    @foreach($checks as [$label, $ok, $href])
                        <li>
                            @if($ok)
                                <div class="done"><span class="tick"><x-icon name="check" size="12" /></span><span>{{ $label }}</span></div>
                            @else
                                <a href="{{ $href }}"><span class="tick"></span><span>{{ $label }}</span><span class="go"><x-icon name="chevron" size="16" /></span></a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <section class="panel">
            <div class="panel-h"><h3>Aksi cepat</h3></div>
            <div class="panel-b">
                <div class="quick">
                    <a class="q-btn" href="{{ route('admin.products.create') }}"><x-icon name="box" /> Produk</a>
                    <a class="q-btn" href="{{ route('admin.articles.create') }}"><x-icon name="file" /> Artikel</a>
                    <a class="q-btn" href="{{ route('admin.testimonials.create') }}"><x-icon name="message" /> Testimonial</a>
                    <a class="q-btn" href="{{ route('admin.projects.create') }}"><x-icon name="briefcase" /> Project</a>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection