<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['whatsapp_number','phone','address','opening_hours','maps_url','maps_embed','instagram','year_established','aftersales_points'] as $k) {
            Setting::firstOrCreate(['key' => $k], ['value' => null]);
        }

        $cats = [];
        foreach (['Closet','Wastafel','Shower','Kran','Urinoir','Accessories','Spare Part'] as $i => $n) {
            $cats[$n] = Category::firstOrCreate(['slug' => Str::slug($n)], ['name' => $n, 'sort_order' => $i]);
        }

        $toto = Brand::firstOrCreate(['slug' => 'toto'], ['name' => 'TOTO']);

        // [kategori, nama, sku]. Kategori hanya tebakan awal, bisa diubah nanti lewat CMS.
        $products = [
            ['Closet','Closet CW53','CW53'], ['Closet','Closet CW633','CW633'], ['Closet','Closet CW421','CW421'],
            ['Closet','Closet CW823RJ','CW823RJ'], ['Urinoir','Urinoir U57M','U57M'],
            ['Accessories','Floor Drain TX1DB','TX1DB'], ['Accessories','Jet Spray THX20NB#W','THX20NB#W'],
            ['Kran','Kran Tembok T23B13','T23B13'], ['Shower','Kran Shower TX471SRS','TX471SRS'],
            ['Closet','Neorest',null], ['Shower','Hand Shower THX48','THX48'],
            ['Kran','Kran Cabang TX423MEB','TX423MEB'], ['Urinoir','Urinoir UW58JM','UW58JM'],
            ['Wastafel','Wastafel LW246','LW246'], ['Wastafel','Wastafel LW247','LW247'],
            ['Kran','Kran Up Down TX109KEA','TX109KEA'], ['Kran','Kran Up Down TX109LRS','TX109LRS'],
            ['Kran','Sensor TLE25006A','TLE25006A'],
            ['Spare Part','Spare Part THX69V5','THX69V5'], ['Spare Part','Spare Part THX69V7','THX69V7'],
        ];

        foreach ($products as $i => [$cat, $name, $sku]) {
            Product::firstOrCreate(['slug' => Str::slug($name)], [
                'category_id' => $cats[$cat]->id, 'brand_id' => $toto->id,
                'name' => $name, 'sku' => $sku,
                'is_best_seller' => true, 'sort_order' => $i,
            ]);
        }
    }
}
