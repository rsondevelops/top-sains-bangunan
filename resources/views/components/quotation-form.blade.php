<div id="form">
@if(session('wa'))
    <div class="notice" id="sukses">
        <h3 class="fs-4 mb-2">Permintaan Anda sudah kami terima.</h3>
        <p class="text-muted">Agar lebih cepat, kirim juga rinciannya langsung ke WhatsApp tim Top Sains.</p>
        <a href="{{ session('wa') }}" target="_blank" rel="noopener" class="btn-main">Lanjutkan di WhatsApp</a>
    </div>
    <script>document.getElementById('sukses').scrollIntoView({behavior:'smooth',block:'center'});</script>
@else
    <form method="post" action="/permintaan-penawaran" class="q-form" novalidate>
        @csrf
        <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
        <input type="hidden" name="source_page" value="{{ request()->path() }}">

        <div class="row g-3">
            <div class="col-md-6 field">
                <label for="f-name">Nama</label>
                <input id="f-name" name="name" value="{{ old('name') }}" required autocomplete="name">
                @error('name')<small class="err">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6 field">
                <label for="f-wa">Nomor WhatsApp</label>
                <input id="f-wa" name="whatsapp" value="{{ old('whatsapp') }}" inputmode="tel" required autocomplete="tel" placeholder="08xxxxxxxxxx">
                @error('whatsapp')<small class="err">{{ $message }}</small>@enderror
            </div>
            <div class="col-12 field">
                <label for="f-co">Nama perusahaan <span class="text-muted">(opsional)</span></label>
                <input id="f-co" name="company" value="{{ old('company') }}" autocomplete="organization">
            </div>
            <div class="col-md-6 field">
                <label for="f-type">Jenis proyek</label>
                <select id="f-type" name="project_type" required>
                    <option value="">Pilih</option>
                    @foreach(['Rumah / residential','Perumahan (developer)','Hotel','Villa','Apartment','Restaurant','Kantor / commercial','Lainnya'] as $o)
                        <option @selected(old('project_type') === $o)>{{ $o }}</option>
                    @endforeach
                </select>
                @error('project_type')<small class="err">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6 field">
                <label for="f-loc">Lokasi proyek</label>
                <input id="f-loc" name="project_location" value="{{ old('project_location') }}" required placeholder="Contoh: BSD, Tangerang">
                @error('project_location')<small class="err">{{ $message }}</small>@enderror
            </div>
            <div class="col-12 field">
                <label for="f-prod">Produk yang dibutuhkan</label>
                <textarea id="f-prod" name="products_needed" rows="3" required placeholder="Contoh: Closet CW53, Wastafel LW246, Kran Tembok T23B13">{{ old('products_needed') }}</textarea>
                @error('products_needed')<small class="err">{{ $message }}</small>@enderror
            </div>
            <div class="col-12 field">
                <label for="f-qty">Estimasi quantity <span class="text-muted">(opsional)</span></label>
                <input id="f-qty" name="quantity" value="{{ old('quantity') }}" placeholder="Contoh: 40 unit closet, 40 unit wastafel">
            </div>
            <div class="col-12 field">
                <label for="f-notes">Catatan <span class="text-muted">(opsional)</span></label>
                <textarea id="f-notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn-main w-100 justify-content-center">Kirim Permintaan Penawaran</button>
            </div>
        </div>
    </form>
@endif
</div>