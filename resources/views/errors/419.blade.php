@extends('layouts.app')
@section('title', 'Sesi berakhir | Top Sains Bangunan')
@section('robots', 'noindex,nofollow')

@section('content')
<section class="section">
    <div class="container" style="max-width:640px">
        <p class="eyebrow mb-3">Error 419</p>
        <h1 class="h-section mb-3">Sesi halaman sudah berakhir.</h1>
        <p class="lead-t mb-4">Halaman terlalu lama terbuka. Kembali, muat ulang halaman, lalu kirim lagi.</p>
        <a href="javascript:history.back()" class="btn-main">Kembali</a>
    </div>
</section>
@endsection