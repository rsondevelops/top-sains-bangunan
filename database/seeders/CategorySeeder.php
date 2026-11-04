<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            'Closet' => 'Closet duduk dan closet monoblok untuk rumah, renovasi, hotel, dan proyek. Tanyakan harga dan ketersediaan via WhatsApp.',
            'Wastafel' => 'Wastafel untuk kamar mandi dan area umum, dari tipe tanam, gantung, hingga pedestal.',
            'Shower' => 'Kran shower, hand shower, dan perlengkapan mandi untuk kamar mandi rumah maupun hotel.',
            'Kran' => 'Kran wastafel, kran tembok, kran cabang, dan kran sensor untuk berbagai kebutuhan.',
            'Urinoir' => 'Urinoir untuk toilet pria di kantor, restoran, hotel, dan fasilitas umum.',
            'Accessories' => 'Jet spray, floor drain, stopkran, flexible, dan aksesori kamar mandi lainnya.',
            'Spare Part' => 'Spare part untuk produk yang sudah terpasang: fill valve, flush valve, tombol flush, dan lainnya.',
        ];

        $i = 0;
        foreach ($cats as $name => $desc) {
            Category::updateOrCreate(['slug' => Str::slug($name)], [
                'name' => $name, 'description' => $desc, 'sort_order' => $i++, 'is_active' => true,
            ]);
        }
    }
}