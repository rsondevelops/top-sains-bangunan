<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    // CONTOH untuk mengisi tampilan. Ubah ke true hanya setelah isinya diganti testimonial ASLI.
    const AKTIF = false;

    public function run(): void
    {
        $rows = [
            ['[Contoh] Bapak Andi', 'Pemilik rumah, Bogor', 'Barang sesuai pesanan dan dibantu memilih tipe yang cocok dengan kamar mandi kami. Kalau ada pertanyaan, dijawab lewat WhatsApp.'],
            ['[Contoh] Ibu Rina', 'Renovasi kamar mandi, Jakarta Selatan', 'Awalnya bingung memilih closet dan kran. Tim menjelaskan perbedaannya dengan sabar, jadi tidak salah beli.'],
            ['[Contoh] Pak Dedi', 'Kontraktor', 'Penawaran untuk kebutuhan proyek cepat dikirim dan rinci. Pengiriman ke lokasi sesuai jadwal.'],
        ];

        foreach ($rows as $i => [$name, $role, $content]) {
            Testimonial::firstOrCreate(['name' => $name], [
                'role_company' => $role, 'content' => $content,
                'is_featured' => true, 'is_active' => self::AKTIF, 'sort_order' => $i,
            ]);
        }
    }
}