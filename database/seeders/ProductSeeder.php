<?php

namespace Database\Seeders;

use App\Models\{Brand, Category, Product};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    // Harga perkiraan hanyalah TEBAKAN. Biarkan false sampai Anda punya harga asli.
    const PAKAI_HARGA_PERKIRAAN = false;

    public function run(): void
    {
        $toto = Brand::where('slug', 'toto')->first();
        $cats = Category::pluck('id', 'name');

        // cat, nama, sku, brand?, ringkas, gaya, penggunaan, cocok untuk, best seller, perkiraan harga
        $rows = [
            // ----- Closet -----
            ['Closet', 'Closet CW53', 'CW53', true, 'Closet duduk untuk kamar mandi rumah dan renovasi.', ['minimalis', 'modern'], ['rumah-baru', 'renovasi'], ['Rumah', 'Renovasi'], true, 2500000],
            ['Closet', 'Closet CW633', 'CW633', true, 'Closet duduk dengan bentuk sederhana, mudah dipadukan dengan berbagai gaya.', ['minimalis', 'modern-minimalis'], ['rumah-baru', 'renovasi', 'developer'], ['Rumah', 'Renovasi', 'Proyek perumahan'], true, 2800000],
            ['Closet', 'Closet CW421', 'CW421', true, 'Closet untuk kebutuhan rumah dan proyek.', ['minimalis'], ['rumah-baru', 'renovasi', 'developer'], ['Rumah', 'Proyek perumahan'], true, 2200000],
            ['Closet', 'Closet CW823RJ', 'CW823RJ', true, 'Closet dengan tampilan modern untuk kamar mandi yang lebih rapi.', ['modern', 'modern-minimalis', 'premium'], ['rumah-baru', 'renovasi', 'villa', 'apartment'], ['Rumah', 'Villa', 'Apartment'], true, 6500000],
            ['Closet', 'Neorest', null, true, 'Seri closet premium untuk kamar mandi dengan standar lebih tinggi.', ['premium', 'luxury', 'modern-minimalis'], ['villa', 'hotel', 'rumah-baru'], ['Villa', 'Hotel', 'Rumah premium'], true, 45000000],

            // ----- Wastafel -----
            ['Wastafel', 'Wastafel LW246', 'LW246', true, 'Wastafel untuk kamar mandi rumah dan renovasi.', ['minimalis', 'modern'], ['rumah-baru', 'renovasi'], ['Rumah', 'Renovasi'], true, 1200000],
            ['Wastafel', 'Wastafel LW247', 'LW247', true, 'Wastafel dengan bentuk sederhana untuk berbagai gaya kamar mandi.', ['minimalis', 'modern-minimalis'], ['rumah-baru', 'renovasi', 'apartment'], ['Rumah', 'Apartment'], true, 1400000],

            // ----- Kran -----
            ['Kran', 'Kran Tembok T23B13', 'T23B13', true, 'Kran tembok untuk area cuci dan kebutuhan umum.', ['minimalis'], ['rumah-baru', 'renovasi', 'developer'], ['Rumah', 'Proyek'], true, 450000],
            ['Kran', 'Kran Cabang TX423MEB', 'TX423MEB', true, 'Kran cabang untuk membagi aliran air ke lebih dari satu titik, misalnya ke shower.', ['modern', 'modern-minimalis'], ['rumah-baru', 'renovasi'], ['Rumah', 'Renovasi'], true, 1500000],
            ['Kran', 'Kran Up Down TX109KEA', 'TX109KEA', true, 'Kran wastafel dengan tuas naik turun.', ['modern', 'modern-minimalis'], ['rumah-baru', 'renovasi', 'apartment'], ['Rumah', 'Apartment'], true, 1100000],
            ['Kran', 'Kran Up Down TX109LRS', 'TX109LRS', true, 'Kran wastafel dengan tuas naik turun, tipe lebih tinggi.', ['modern', 'premium'], ['rumah-baru', 'renovasi', 'villa'], ['Rumah', 'Villa'], true, 1300000],
            ['Kran', 'Sensor TLE25006A', 'TLE25006A', true, 'Kran sensor untuk area umum yang mengutamakan kebersihan.', ['modern', 'premium'], ['kantor', 'restaurant', 'hotel'], ['Kantor', 'Restaurant', 'Hotel', 'Area umum'], true, 5500000],

            // ----- Shower -----
            ['Shower', 'Kran Shower TX471SRS', 'TX471SRS', true, 'Kran shower untuk kamar mandi rumah dan renovasi.', ['modern', 'modern-minimalis'], ['rumah-baru', 'renovasi', 'villa'], ['Rumah', 'Renovasi'], true, 1800000],
            ['Shower', 'Hand Shower THX48', 'THX48', true, 'Hand shower pelengkap kamar mandi.', ['minimalis', 'modern'], ['rumah-baru', 'renovasi', 'hotel'], ['Rumah', 'Renovasi', 'Hotel'], true, 650000],

            // ----- Urinoir -----
            ['Urinoir', 'Urinoir U57M', 'U57M', true, 'Urinoir untuk toilet pria di kantor, restoran, dan fasilitas umum.', ['modern'], ['kantor', 'restaurant', 'hotel'], ['Kantor', 'Restaurant', 'Fasilitas umum'], true, 1800000],
            ['Urinoir', 'Urinoir UW58JM', 'UW58JM', true, 'Urinoir tipe lain untuk toilet pria di bangunan komersial.', ['modern'], ['kantor', 'restaurant', 'hotel'], ['Kantor', 'Restaurant', 'Hotel'], true, 2200000],

            // ----- Accessories -----
            ['Accessories', 'Jet Spray THX20NB#W', 'THX20NB#W', true, 'Jet spray pelengkap closet untuk kebersihan sehari-hari.', ['minimalis', 'modern'], ['rumah-baru', 'renovasi', 'hotel'], ['Rumah', 'Renovasi', 'Hotel'], true, 550000],
            ['Accessories', 'Floor Drain TX1DB', 'TX1DB', true, 'Floor drain untuk saluran pembuangan lantai kamar mandi.', [], ['rumah-baru', 'renovasi', 'developer'], ['Rumah', 'Proyek'], true, 350000],
            ['Accessories', 'Stopkran', null, false, 'Stopkran untuk memutus aliran air ke closet, wastafel, atau kran.', [], ['rumah-baru', 'renovasi', 'developer'], ['Rumah', 'Renovasi', 'Proyek'], false, 80000],
            ['Accessories', 'Flexible Hose', null, false, 'Selang flexible untuk sambungan air ke closet atau kran. Tanyakan panjang yang tersedia.', [], ['rumah-baru', 'renovasi', 'developer'], ['Rumah', 'Renovasi', 'Proyek'], false, 60000],
            ['Accessories', 'Tempat Tisu', null, true, 'Tempat tisu untuk kamar mandi.', ['minimalis', 'modern'], ['rumah-baru', 'renovasi', 'hotel'], ['Rumah', 'Hotel'], false, 450000],
            ['Accessories', 'Gantungan Handuk', null, true, 'Gantungan handuk untuk dinding kamar mandi.', ['minimalis', 'modern'], ['rumah-baru', 'renovasi', 'hotel'], ['Rumah', 'Hotel'], false, 350000],

            // ----- Spare Part -----
            ['Spare Part', 'Spare Part THX69V5', 'THX69V5', true, 'Spare part untuk produk TOTO. Kirim foto atau kode produk lama Anda untuk memastikan kecocokan.', [], ['renovasi'], ['Perawatan', 'Penggantian part'], true, null],
            ['Spare Part', 'Spare Part THX69V7', 'THX69V7', true, 'Spare part untuk produk TOTO. Kirim foto atau kode produk lama Anda untuk memastikan kecocokan.', [], ['renovasi'], ['Perawatan', 'Penggantian part'], true, null],
            ['Spare Part', 'Fill Valve Closet', null, false, 'Fill valve (pengisi air tangki) pengganti untuk closet. Tanyakan kecocokan dengan tipe closet Anda.', [], ['renovasi'], ['Perawatan', 'Penggantian part'], false, null],
            ['Spare Part', 'Flush Valve Closet', null, false, 'Flush valve (pembuang air tangki) pengganti untuk closet. Tanyakan kecocokan dengan tipe closet Anda.', [], ['renovasi'], ['Perawatan', 'Penggantian part'], false, null],
        ];

        $order = 0;
        foreach ($rows as [$cat, $name, $sku, $withBrand, $short, $styles, $usages, $suit, $best, $price]) {
            Product::firstOrCreate(['slug' => Str::slug($name)], [
                'category_id'       => $cats[$cat],
                'brand_id'          => $withBrand ? $toto?->id : null,
                'name'              => $name,
                'sku'               => $sku,
                'short_description' => $short,
                'description'       => $short . "\n\nHarga dan ketersediaan dapat berubah. Hubungi tim Top Sains via WhatsApp untuk informasi terbaru.",
                'price'             => self::PAKAI_HARGA_PERKIRAAN ? $price : null,
                'specifications'    => $this->specs($cat, $withBrand, $sku),
                'suitable_for'      => $suit,
                'styles'            => $styles,
                'usages'            => $usages,
                'is_best_seller'    => $best,
                'is_featured'       => false,
                'is_active'         => true,
                'sort_order'        => $order++,
            ]);
        }

        $this->relations();
    }

    // Spesifikasi teknis (ukuran, bahan, dll.) sengaja tidak diisi: isi dari katalog resmi.
    private function specs(string $cat, bool $withBrand, ?string $sku): array
    {
        return array_values(array_filter([
            ['label' => 'Kategori', 'value' => $cat],
            $withBrand ? ['label' => 'Brand', 'value' => 'TOTO'] : null,
            $sku ? ['label' => 'Kode produk', 'value' => $sku] : null,
        ]));
    }

    // Produk yang sering digunakan bersama (satu arah). Cek kecocokannya sebelum tayang.
    private function relations(): void
    {
        $pairs = [
            'Closet CW53'        => ['Jet Spray THX20NB#W', 'Stopkran', 'Flexible Hose'],
            'Closet CW633'       => ['Jet Spray THX20NB#W', 'Stopkran', 'Flexible Hose'],
            'Closet CW421'       => ['Jet Spray THX20NB#W', 'Stopkran', 'Flexible Hose'],
            'Closet CW823RJ'     => ['Jet Spray THX20NB#W', 'Stopkran', 'Flexible Hose'],
            'Neorest'            => ['Jet Spray THX20NB#W'],
            'Wastafel LW246'     => ['Kran Up Down TX109KEA', 'Stopkran', 'Flexible Hose'],
            'Wastafel LW247'     => ['Kran Up Down TX109LRS', 'Stopkran', 'Flexible Hose'],
            'Kran Cabang TX423MEB' => ['Kran Shower TX471SRS', 'Hand Shower THX48'],
            'Kran Shower TX471SRS' => ['Hand Shower THX48', 'Floor Drain TX1DB'],
            'Stopkran'           => ['Flexible Hose'],
        ];

        foreach ($pairs as $name => $related) {
            $product = Product::where('slug', Str::slug($name))->first();
            if (! $product) continue;

            $sync = [];
            foreach ($related as $i => $relName) {
                if ($rel = Product::where('slug', Str::slug($relName))->first()) {
                    $sync[$rel->id] = ['sort_order' => $i];
                }
            }
            $product->related()->sync($sync);
        }
    }
}