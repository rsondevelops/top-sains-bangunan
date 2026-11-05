<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::updateOrCreate(['slug' => 'toto'], [
            'name' => 'TOTO',
            'description' => 'Brand sanitary dan perlengkapan kamar mandi yang tersedia di Top Sains Bangunan.',
            'is_active' => true,
        ]);
    }
}