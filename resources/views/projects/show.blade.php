@extends('layouts.app')

@section('title', $project->name.($project->location ? ', '.$project->location : '').' | Project Top Sains Bangunan')
@section('description', \Illuminate\Support\Str::limit($project->description ?: 'Project sanitary '.$project->name.' yang dilayani Top Sains Bangunan.', 158))

@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <x-breadcrumb :items="[['Beranda','/'],['Project','/project'],[$project->name,null]]" />

        <div class="row g-5 mt-1">
            <div class="col-lg-5">
                <p class="eyebrow mb-2">{{ $project->type }}{{ $project->type && $project->location ? ' — ' : '' }}{{ $project->location }}</p>
                <h1 class="h-section mb-4">{{ $project->name }}</h1>
                @if($project->description)<div class="text-muted">{!! nl2br(e($project->description)) !!}</div>@endif
                <a href="{{ wa_url('Halo Top Sains, saya melihat project '.$project->name.' dan ingin berdiskusi tentang kebutuhan sanitary proyek saya.') }}" target="_blank" rel="noopener" class="btn-main mt-4">Diskusikan Proyek Anda</a>
            </div>
            <div class="col-lg-7">
                @if($project->image)
                    <div class="proj-img"><img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->name }}" width="1200" height="900" fetchpriority="high"></div>
                @endif
                @foreach($project->gallery ?? [] as $g)
                    <div class="proj-img"><img src="{{ asset('storage/'.$g) }}" alt="{{ $project->name }}, foto {{ $loop->iteration + 1 }}" width="1200" height="900" loading="lazy"></div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection