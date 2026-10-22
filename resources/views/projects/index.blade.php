@extends('layouts.app')

@section('title', 'Project yang Pernah Kami Layani | Top Sains Bangunan')
@section('description', 'Daftar project yang pernah dilayani Top Sains Bangunan: residential, villa, hotel, dan commercial di Bogor, Jakarta, dan sekitarnya.')

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Project',null]]" />
        <h1 class="h-section my-4">Project yang Pernah Kami Layani</h1>

        @if($projects->isNotEmpty())
            <div class="row g-4 g-lg-5">
                @foreach($projects as $pr)
                    <div class="col-md-6 col-lg-4">
                        <a href="/project/{{ $pr->slug }}" class="d-block">
                            <div class="proj-img">
                                @if($pr->image)<img src="{{ asset('storage/'.$pr->image) }}" alt="{{ $pr->name }}, {{ $pr->location }}" width="800" height="600" loading="lazy">@else<span class="ph">Foto project</span>@endif
                            </div>
                            <div class="eyebrow">{{ $pr->type }}{{ $pr->type && $pr->location ? ' — ' : '' }}{{ $pr->location }}</div>
                            <h2 class="fs-5 mt-1">{{ $pr->name }}</h2>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 d-flex justify-content-center">{{ $projects->links() }}</div>
        @else
            <div class="empty-box">Daftar project akan segera ditambahkan.</div>
        @endif

        <div class="consult mt-5">
            <div>
                <h2 class="fs-3 mb-1">Punya proyek yang sedang berjalan?</h2>
                <p class="mb-0 text-muted">Kirim kebutuhan dan lokasinya, kami siapkan penawaran.</p>
            </div>
            <a href="/solusi/proyek" class="btn-main">Request Quotation</a>
        </div>
    </div>
</section>
@endsection