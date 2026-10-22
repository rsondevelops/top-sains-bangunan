@extends('layouts.admin')
@section('title', $title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">{{ $title }} <span class="text-muted fs-6">({{ $rows->count() }})</span></h1>
    <a href="{{ route($base.'.create') }}" class="btn btn-dark btn-sm">+ Tambah</a>
</div>

<div class="table-responsive bg-white border rounded">
    <table class="table align-middle mb-0">
        <thead><tr>@foreach($cols as $label => $fn)<th>{{ $label }}</th>@endforeach<th></th></tr></thead>
        <tbody>
        @forelse($rows as $r)
            <tr>
                @foreach($cols as $fn)<td>{{ $fn($r) }}</td>@endforeach
                <td class="text-end text-nowrap">
                    <a href="{{ route($base.'.edit', $r) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                    <form method="post" action="{{ route($base.'.destroy', $r) }}" class="d-inline" onsubmit="return confirm('Hapus data ini? Tidak bisa dibatalkan.')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="{{ count($cols) + 1 }}" class="text-muted p-4">Belum ada data.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection