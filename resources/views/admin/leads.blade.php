@extends('layouts.admin')
@section('title', 'Leads')

@section('content')
<h1 class="h4 mb-3">Leads</h1>

<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="/dashboard/leads" class="btn btn-sm {{ ! request('status') ? 'btn-dark' : 'btn-outline-dark' }}">Semua</a>
    @foreach(['new' => 'Baru', 'contacted' => 'Sudah dihubungi', 'closed' => 'Selesai'] as $k => $l)
        <a href="/dashboard/leads?status={{ $k }}" class="btn btn-sm {{ request('status') === $k ? 'btn-dark' : 'btn-outline-dark' }}">{{ $l }} ({{ $counts[$k] ?? 0 }})</a>
    @endforeach
</div>

@forelse($leads as $l)
    <div class="bg-white border rounded p-3 p-md-4 mb-3">
        <div class="d-flex flex-wrap justify-content-between gap-2">
            <div>
                <div class="fw-semibold fs-5">{{ $l->name }}
                    @if($l->status === 'new')<span class="badge text-bg-danger align-middle">Baru</span>@endif
                </div>
                <div class="text-muted small">{{ $l->created_at->format('d M Y H:i') }} · {{ $l->company ?: 'Tanpa perusahaan' }} · {{ $l->whatsapp }}</div>
            </div>
            <a target="_blank" rel="noopener" class="btn btn-success btn-sm align-self-start"
               href="{{ wa_customer($l->whatsapp, 'Halo '.$l->name.', kami dari Top Sains Bangunan. Terima kasih atas permintaan penawaran Anda. Boleh kami konfirmasi beberapa detail kebutuhannya?') }}">Chat WhatsApp</a>
        </div>

        <dl class="row mt-3 mb-0 small">
            <dt class="col-sm-3">Jenis proyek</dt><dd class="col-sm-9">{{ $l->project_type }}</dd>
            <dt class="col-sm-3">Lokasi</dt><dd class="col-sm-9">{{ $l->project_location }}</dd>
            <dt class="col-sm-3">Kebutuhan</dt><dd class="col-sm-9">{!! nl2br(e($l->products_needed)) !!}</dd>
            @if($l->quantity)<dt class="col-sm-3">Quantity</dt><dd class="col-sm-9">{{ $l->quantity }}</dd>@endif
            @if($l->notes)<dt class="col-sm-3">Catatan</dt><dd class="col-sm-9">{!! nl2br(e($l->notes)) !!}</dd>@endif
            @if($l->source_page)<dt class="col-sm-3">Dari halaman</dt><dd class="col-sm-9">/{{ $l->source_page }}</dd>@endif
        </dl>

        <div class="d-flex gap-2 mt-3 pt-3 border-top">
            <form method="post" action="{{ route('admin.leads.update', $l) }}" class="d-flex gap-2">
                @csrf @method('PUT')
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    @foreach(['new' => 'Baru', 'contacted' => 'Sudah dihubungi', 'closed' => 'Selesai'] as $k => $label)
                        <option value="{{ $k }}" @selected($l->status === $k)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
            <form method="post" action="{{ route('admin.leads.destroy', $l) }}" onsubmit="return confirm('Hapus lead ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
        </div>
    </div>
@empty
    <div class="bg-white border rounded p-4 text-muted">Belum ada lead.</div>
@endforelse

{{ $leads->links() }}
@endsection