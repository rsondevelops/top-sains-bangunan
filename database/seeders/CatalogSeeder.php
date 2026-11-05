<?php

namespace Database\Seeders;

use App\Models\{Brand, Category, Product};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $cats = [];
        foreach (['Closet', 'Wastafel', 'Shower', 'Kran', 'Urinoir', 'Accessories', 'Spare Part'] as $i => $n) {
            $cats[$n] = Category::updateOrCreate(
                ['slug' => Str::slug($n)],
                ['name' => $n, 'sort_order' => $i, 'is_active' => true]
            );
        }

        $toto = Brand::updateOrCreate(
            ['slug' => 'toto'],
            ['name' => 'TOTO', 'is_active' => true]
        );

        // [kategori, nama, sku]. Kategori hanya tebakan awal, koreksi lewat CMS.
        $products = [
            ['Closet', 'Closet CW53', 'CW53'],
            ['Closet', 'Closet CW633', 'CW633'],
            ['Closet', 'Closet CW421', 'CW421'],
            ['Urinoir', 'Urinoir U57M', 'U57M'],
            ['Accessories', 'Floor Drain TX1DB', 'TX1DB'],
            ['Accessories', 'Jet Spray THX20NB#W', 'THX20NB#W'],
            ['Closet', 'Closet CW823RJ', 'CW823RJ'],
            ['Kran', 'Kran Tembok T23B13', 'T23B13'],
            ['Shower', 'Kran Shower TX471SRS', 'TX471SRS'],
            ['Closet', 'Neorest', null],
            ['Shower', 'Hand Shower THX48', 'THX48'],
            ['Kran', 'Kran Cabang TX423MEB', 'TX423MEB'],
            ['Urinoir', 'Urinoir UW58JM', 'UW58JM'],
            ['Wastafel', 'Wastafel LW246', 'LW246'],
            ['Wastafel', 'Wastafel LW247', 'LW247'],
            ['Kran', 'Kran Up Down TX109KEA', 'TX109KEA'],
            ['Kran', 'Kran Up Down TX109LRS', 'TX109LRS'],
            ['Kran', 'Sensor TLE25006A', 'TLE25006A'],
            ['Spare Part', 'Spare Part THX69V5', 'THX69V5'],
            ['Spare Part', 'Spare Part THX69V7', 'THX69V7'],
        ];

        foreach ($products as $i => [$cat, $name, $sku]) {
            $isPart = $cat === 'Spare Part';

            Product::updateOrCreate(['slug' => Str::slug($name)], [
                'category_id'       => $cats[$cat]->id,
                'brand_id'          => $toto->id,
                'name'              => $name,
                'sku'               => $sku,
                'short_description' => $isPart ? 'Spare part untuk produk TOTO.' : null,
                'suitable_for'      => $isPart ? [] : ['Rumah', 'Renovasi'],
                'usages'            => $isPart ? [] : ['rumah-baru', 'renovasi'],
                'styles'            => [],
                'is_best_seller'    => true,
                'is_featured'       => false,
                'is_active'         => true,
                'sort_order'        => $i,
            ]);
        }

        // Produk yang sering digunakan bersama (satu arah). Cek kecocokannya sebelum tayang.
        $pairs = [
            'CW53'      => ['THX20NB#W'],
            'CW633'     => ['THX20NB#W'],
            'CW421'     => ['THX20NB#W'],
            'CW823RJ'   => ['THX20NB#W'],
            'LW246'     => ['TX109KEA', 'TX109LRS'],
            'LW247'     => ['TX109KEA', 'TX109LRS'],
            'TX423MEB'  => ['TX471SRS', 'THX48'],
        ];

        foreach ($pairs as $sku => $related) {
            $product = Product::where('sku', $sku)->first();
            if (! $product) continue;

            $sync = [];
            foreach ($related as $i => $relSku) {
                if ($rel = Product::where('sku', $relSku)->first()) {
                    $sync[$rel->id] = ['sort_order' => $i];
                }
            }
            $product->related()->sync($sync);
        }
    }
}