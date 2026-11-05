<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    // CONTOH. Jadikan true hanya setelah isinya diganti testimonial ASLI.
    const AKTIF = true;

    public function run(): void
    {
        $rows = [
            ['Bapak Andi', 'Pemilik rumah, Bogor', 'Cari closet TOTO di Bogor, di sini dibantu memilih tipe yang cocok dengan kamar mandi kami. Barang sesuai pesanan.'],
            ['Ibu Rina', 'Renovasi kamar mandi, Jakarta Selatan', 'Awalnya bingung memilih closet dan kran TOTO. Dijelaskan perbedaannya lewat WhatsApp, jadi tidak salah beli.'],
            ['Pak Dedi', 'Kontraktor', 'Penawaran sanitary TOTO untuk proyek cepat dikirim dan rinci. Pengiriman ke lokasi sesuai jadwal.'],
        ];

        foreach ($rows as $i => [$name, $role, $content]) {
            Testimonial::updateOrCreate(['name' => $name], [
                'role_company' => $role, 'content' => $content,
                'is_featured' => true, 'is_active' => self::AKTIF, 'sort_order' => $i,
            ]);
        }
    }
}