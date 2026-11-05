<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    // CONTOH. Ubah ke true hanya setelah isinya diganti project ASLI.
    const AKTIF = false;

    public function run(): void
    {
        $rows = [
            ['contoh-rumah-tinggal-bogor', '[Contoh] Rumah Tinggal', 'Residential', 'Bogor', 'Pengadaan closet, wastafel, kran, dan shower untuk rumah tinggal baru.'],
            ['contoh-villa-bsd', '[Contoh] Villa', 'Villa', 'BSD', 'Pengadaan sanitary untuk beberapa kamar mandi villa.'],
            ['contoh-kantor-jakarta', '[Contoh] Gedung Kantor', 'Commercial', 'Jakarta', 'Pengadaan closet, urinoir, wastafel, dan kran sensor untuk toilet kantor.'],
        ];

        foreach ($rows as $i => [$slug, $name, $type, $loc, $desc]) {
            Project::firstOrCreate(['slug' => $slug], [
                'name' => $name, 'type' => $type, 'location' => $loc, 'description' => $desc,
                'is_featured' => true, 'is_active' => self::AKTIF, 'sort_order' => $i,
            ]);
        }
    }
}