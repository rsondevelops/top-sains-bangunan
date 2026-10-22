@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="h4 mb-4">Dashboard</h1>

<div class="row g-3 mb-4">
    @foreach($stats as $label => $n)
        <div class="col-6 col-md-4 col-xl">
            <div class="bg-white border rounded p-3 h-100">
                <div class="text-muted small">{{ $label }}</div>
                <div class="fs-2 fw-semibold">{{ $n }}</div>
            </div>
        </div>
    @endforeach
</div>

@php
    $todo = collect([
        'whatsapp_number' => 'Nomor WhatsApp', 'address' => 'Alamat toko', 'opening_hours' => 'Jam buka',
        'maps_url' => 'Link Google Maps', 'maps_embed' => 'Embed Google Maps', 'aftersales_points' => 'Poin after-sales',
    ])->reject(fn ($label, $key) => setting($key));
@endphp
@if($todo->isNotEmpty())
    <div class="alert alert-warning">
        <strong>Data website yang belum diisi:</strong> {{ $todo->join(', ') }}.
        <a href="/dashboard/settings" class="alert-link">Isi di Settings</a>
    </div>
@endif

<div class="bg-white border rounded">
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <strong>Leads terbaru</strong>
        <a href="/dashboard/leads" class="small">Lihat semua</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <tbody>
            @forelse($leads as $l)
                <tr>
                    <td>{{ $l->name }}<div class="small text-muted">{{ $l->company ?: $l->project_type }}</div></td>
                    <td>{{ $l->project_location }}</td>
                    <td class="text-muted small">{{ $l->created_at->diffForHumans() }}</td>
                    <td><span class="badge text-bg-{{ $l->status === 'new' ? 'danger' : 'secondary' }}">{{ $l->status }}</span></td>
                </tr>
            @empty
                <tr><td class="text-muted p-3">Belum ada lead.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection