@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<h1 class="h4 mb-3">Settings</h1>
@if($errors->any())<div class="alert alert-danger">Ada isian yang perlu diperbaiki. Lihat pesan merah di bawah.</div>@endif

<form method="post" action="{{ route('admin.settings.update') }}" class="bg-white border rounded p-3 p-md-4" style="max-width:820px">
    @csrf @method('PUT')

    @foreach($fields as $key => [$label, $type, $help])
        <div class="mb-3">
            <label class="form-label" for="s-{{ $key }}">{{ $label }}</label>
            @if($type === 'textarea')
                <textarea id="s-{{ $key }}" name="{{ $key }}" rows="{{ in_array($key, ['about_story', 'aftersales_points', 'maps_embed']) ? 5 : 3 }}" class="form-control @error($key) is-invalid @enderror">{{ old($key, setting($key)) }}</textarea>
            @else
                <input id="s-{{ $key }}" name="{{ $key }}" value="{{ old($key, setting($key)) }}" class="form-control @error($key) is-invalid @enderror">
            @endif
            @if($help)<div class="form-text">{{ $help }}</div>@endif
            @error($key)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
    @endforeach

    <button class="btn btn-dark px-4" type="submit">Simpan</button>
</form>
@endsection