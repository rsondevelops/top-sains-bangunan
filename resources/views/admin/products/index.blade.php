@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Products <span class="text-muted fs-6">({{ $products->total() }})</span></h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark btn-sm">+ Tambah Produk</a>
</div>

<form class="row g-2 mb-3" method="get">
    <div class="col-md-5"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau SKU"></div>
    <div class="col-md-4">
        <select name="category" class="form-select">
            <option value="">Semua kategori</option>
            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-outline-dark">Cari</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-link">Reset</a>
    </div>
</form>

<div class="table-responsive bg-white border rounded">
    <table class="table align-middle mb-0">
        <thead><tr><th style="width:64px"></th><th>Produk</th><th>Kategori</th><th>Harga</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($products as $p)
            <tr>
                <td>@if($p->image_url)<img src="{{ $p->image_url }}" width="48" height="48" style="object-fit:contain" alt="">@endif</td>
                <td>
                    <a href="{{ route('admin.products.edit', $p) }}" class="fw-semibold text-dark text-decoration-none">{{ $p->name }}</a>
                    <div class="small text-muted">{{ $p->sku ?: '-' }}</div>
                </td>
                <td>{{ $p->category->name }}</td>
                <td>{{ $p->price ? rupiah($p->price) : '-' }}</td>
                <td>
                    @if($p->is_best_seller)<span class="badge text-bg-dark">Best seller</span>@endif
                    @unless($p->is_active)<span class="badge text-bg-secondary">Nonaktif</span>@endunless
                </td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                    <form method="post" action="{{ route('admin.products.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Hapus produk ini? Tidak bisa dibatalkan.')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted p-4">Tidak ada produk.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $products->links() }}</div>
@endsection