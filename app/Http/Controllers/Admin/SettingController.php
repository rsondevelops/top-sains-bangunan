<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // key => [label, tipe, bantuan]
    const FIELDS = [
        'whatsapp_number'   => ['Nomor WhatsApp', 'text', 'Contoh: 628123456789. Angka 0 di depan otomatis jadi 62. Semua tombol WhatsApp memakai nomor ini.'],
        'phone'             => ['Telepon (opsional)', 'text', ''],
        'address'           => ['Alamat toko', 'textarea', 'Tampil di footer, kontak, dan schema Google.'],
        'opening_hours'     => ['Jam buka', 'textarea', 'Satu baris per kelompok hari. Contoh: Senin-Sabtu 08.00-17.00'],
        'maps_url'          => ['Link Google Maps', 'text', 'Link untuk tombol "Buka Google Maps" (boleh link pendek maps.app.goo.gl).'],
        'maps_embed'        => ['Embed Google Maps', 'textarea', 'Google Maps > Bagikan > Sematkan peta > salin HTML iframe, tempel semuanya di sini.'],
        'instagram'         => ['Link Instagram (opsional)', 'text', 'Contoh: https://instagram.com/namaakun'],
        'year_established'  => ['Tahun berdiri (opsional)', 'text', 'Isi hanya jika sudah pasti. Kosong = tidak ditampilkan.'],
        'about_story'       => ['Cerita Top Sains (halaman Tentang Kami)', 'textarea', 'Sejarah, siapa yang mengelola, fokus bisnis. Isi fakta saja.'],
        'aftersales_points' => ['Layanan after-sales', 'textarea', 'Satu layanan per baris. Tampil sebagai daftar bernomor di homepage dan halaman After Sales.'],
    ];

    public function index()
    {
        return view('admin.settings', ['fields' => self::FIELDS]);
    }

    public function update(Request $request)
    {
        // Jika yang ditempel adalah HTML iframe lengkap, ambil src-nya saja
        $embed = $request->input('maps_embed');
        if ($embed && preg_match('/src="([^"]+)"/', $embed, $m)) {
            $request->merge(['maps_embed' => html_entity_decode($m[1])]);
        }

        $d = $request->validate([
            'whatsapp_number'   => ['nullable', 'regex:/^\+?[0-9\s\-]{8,20}$/'],
            'phone'             => 'nullable|string|max:40',
            'address'           => 'nullable|string|max:500',
            'opening_hours'     => 'nullable|string|max:300',
            'maps_url'          => 'nullable|url|max:500',
            'maps_embed'        => ['nullable', 'url', 'max:1500', 'starts_with:https://www.google.com/maps/'],
            'instagram'         => 'nullable|url|max:200',
            'year_established'  => 'nullable|integer|between:1900,' . date('Y'),
            'about_story'       => 'nullable|string|max:5000',
            'aftersales_points' => 'nullable|string|max:2000',
        ], id_messages() + [
            'starts_with' => 'Embed harus dari Google Maps (Bagikan > Sematkan peta).',
            'between'     => ':attribute tidak valid.',
        ]);

        foreach (array_keys(self::FIELDS) as $key) {
            $value = $d[$key] ?? null;

            if ($key === 'whatsapp_number' && $value) {
                $value = preg_replace('/\D/', '', $value);
                if (str_starts_with($value, '0')) $value = '62' . substr($value, 1);
            }

            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('ok', 'Pengaturan disimpan.');
    }
}