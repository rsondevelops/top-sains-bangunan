<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    // CONTOH. Jadikan true hanya setelah isinya diganti project ASLI.
    const AKTIF = true;

    public function run(): void
    {
        $rows = [
            ['contoh-rumah-tinggal-bogor', 'Pengadaan Sanitary TOTO Rumah Tinggal, Bogor', 'Residential', 'Bogor',
                'Pengadaan closet, wastafel, kran, dan shower TOTO untuk rumah tinggal di Bogor. Ganti dengan detail project asli: jumlah kamar mandi, produk yang dipakai, dan tahun pengerjaan.'],
            ['contoh-villa-bsd', 'Sanitary TOTO untuk Villa, BSD', 'Villa', 'BSD',
                'Pengadaan sanitary TOTO untuk beberapa kamar mandi villa. Ganti dengan detail project asli.'],
            ['contoh-kantor-jakarta', 'Sanitary TOTO untuk Gedung Kantor, Jakarta', 'Commercial', 'Jakarta',
                'Pengadaan closet, urinoir, wastafel, dan kran sensor TOTO untuk toilet kantor, dikirim dari Bogor. Ganti dengan detail project asli.'],
        ];

        foreach ($rows as $i => [$slug, $name, $type, $loc, $desc]) {
            Project::updateOrCreate(['slug' => $slug], [
                'name' => $name, 'type' => $type, 'location' => $loc, 'description' => $desc,
                'is_featured' => true, 'is_active' => self::AKTIF, 'sort_order' => $i,
            ]);
        }
    }
}