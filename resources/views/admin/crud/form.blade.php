@extends('layouts.admin')
@section('title', $title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">{{ $title }}</h1>
    <a href="{{ route($base.'.index') }}" class="small">← Kembali</a>
</div>

@if($errors->any())<div class="alert alert-danger">Ada isian yang perlu diperbaiki. Lihat pesan merah di bawah.</div>@endif

<form method="post" enctype="multipart/form-data" class="bg-white border rounded p-3 p-md-4" style="max-width:820px"
      action="{{ $model->exists ? route($base.'.update', $model) : route($base.'.store') }}">
    @csrf
    @if($model->exists) @method('PUT') @endif

    @foreach($fields as $f)
        @php
            $n = $f['name']; $t = $f['type'];
            $v = $t === 'checkbox'
                ? (session()->hasOldInput() ? old($n) : ($model->exists ? $model->{$n} : ($f['default'] ?? false)))
                : old($n, $model->{$n} ?? ($f['default'] ?? null));
        @endphp
        <div class="mb-3">
            @if($t === 'checkbox')
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="{{ $n }}" value="1" id="f-{{ $n }}" @checked($v)>
                    <label class="form-check-label" for="f-{{ $n }}">{{ $f['label'] }}</label>
                </div>
            @else
                <label class="form-label" for="f-{{ $n }}">{{ $f['label'] }}</label>

                @if($t === 'textarea')
                    <textarea id="f-{{ $n }}" name="{{ $n }}" rows="{{ $f['rows'] ?? 4 }}" class="form-control @error($n) is-invalid @enderror">{{ $v }}</textarea>

                @elseif($t === 'file')
                    @if($model->{$n})
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$model->{$n}) }}" alt="" class="border rounded" style="max-height:140px">
                            <label class="d-block small mt-1"><input type="checkbox" name="remove_{{ $n }}" value="1"> Hapus gambar ini</label>
                        </div>
                    @endif
                    <input id="f-{{ $n }}" type="file" name="{{ $n }}" accept="image/*" class="form-control @error($n) is-invalid @enderror">

                @elseif($t === 'gallery')
                    @if(! empty($model->gallery))
                        <div class="row g-2 mb-2">
                            @foreach($model->gallery as $path)
                                <div class="col-4 col-md-3">
                                    <img src="{{ asset('storage/'.$path) }}" alt="" class="img-fluid border rounded">
                                    <label class="small d-block mt-1"><input type="checkbox" name="delete_gallery[]" value="{{ $path }}"> Hapus</label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input id="f-{{ $n }}" type="file" name="gallery[]" accept="image/*" multiple class="form-control @error('gallery.*') is-invalid @enderror">
                    @error('gallery.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

                @else
                    <input id="f-{{ $n }}" type="{{ $t }}" name="{{ $n }}" value="{{ $v }}" class="form-control @error($n) is-invalid @enderror" @if($f['required'] ?? false) required @endif>
                @endif
            @endif

            @if(! empty($f['help']))<div class="form-text">{{ $f['help'] }}</div>@endif
            @error($n)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
    @endforeach

    <div class="d-flex gap-2 pt-2">
        <button type="submit" class="btn btn-dark px-4">Simpan</button>
        <a href="{{ route($base.'.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection