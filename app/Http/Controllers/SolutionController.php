<?php

namespace App\Http\Controllers;

class SolutionController extends Controller
{
    const SEGMENTS = [
        'proyek' => [
            'title' => 'Supplier Sanitary untuk Proyek',
            'description' => 'Kebutuhan sanitary untuk proyek di Bogor, Jakarta, BSD, dan sekitarnya. Kirim daftar kebutuhan dan lokasi, tim Top Sains menyiapkan penawaran.',
            'h1' => 'Kebutuhan Sanitary untuk Proyek',
            'intro' => 'Kirim daftar kebutuhan dan lokasi proyek Anda. Tim Top Sains akan menyiapkan penawaran lewat WhatsApp.',
            'prep' => ['Daftar produk beserta tipe atau SKU-nya', 'Jumlah per produk', 'Lokasi dan jadwal kebutuhan', 'Gambar kerja atau BoQ, jika ada'],
        ],
        'kontraktor' => [
            'title' => 'Sanitary untuk Kontraktor',
            'description' => 'Penawaran sanitary untuk kontraktor: closet, wastafel, kran, dan shower. Kirim BoQ atau daftar material, kami bantu hitungkan.',
            'h1' => 'Sanitary untuk Kontraktor',
            'intro' => 'Punya BoQ atau daftar material dari owner dan konsultan? Kirimkan, kami cocokkan dengan produk yang tersedia.',
            'prep' => ['BoQ atau daftar material', 'Spesifikasi dari owner atau konsultan', 'Jumlah per tipe produk', 'Jadwal pemasangan di lapangan'],
        ],
        'developer' => [
            'title' => 'Sanitary untuk Developer',
            'description' => 'Pengadaan sanitary untuk proyek perumahan dan developer. Sampaikan jumlah unit dan standar spesifikasi, kami siapkan penawaran.',
            'h1' => 'Sanitary untuk Developer',
            'intro' => 'Sampaikan jumlah unit dan standar spesifikasi per tipe rumah. Kami bantu menyusun daftar produk dan penawarannya.',
            'prep' => ['Jumlah unit dan tipe rumah', 'Standar sanitary per tipe', 'Tahapan pengadaan', 'Lokasi proyek'],
        ],
        'hotel-villa' => [
            'title' => 'Sanitary untuk Hotel & Villa',
            'description' => 'Sanitary untuk hotel dan villa: kamar tamu hingga area umum. Ceritakan konsep dan jumlah kamar, kami bantu pilihkan produknya.',
            'h1' => 'Sanitary untuk Hotel & Villa',
            'intro' => 'Ceritakan konsep kamar mandi dan jumlah kamar Anda. Kami bantu memilihkan produk untuk kamar tamu dan area umum.',
            'prep' => ['Jumlah kamar atau unit', 'Konsep atau gaya kamar mandi', 'Kebutuhan area umum (lobi, restoran, dll.)', 'Jadwal pembukaan atau renovasi'],
        ],
    ];

    public function show(string $segment)
    {
        abort_unless(isset(self::SEGMENTS[$segment]), 404);

        return view('solutions.show', ['seg' => self::SEGMENTS[$segment], 'slug' => $segment]);
    }
}