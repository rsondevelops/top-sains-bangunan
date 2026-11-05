<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'slug' => 'cara-memilih-closet',
                'title' => 'Cara Memilih Closet untuk Kamar Mandi Anda',
                'excerpt' => 'Tiga hal yang perlu dicek sebelum membeli closet: jarak pembuangan, ukuran ruang, dan tipe flush.',
                'days' => 21,
                'content' => <<<'MD'
Closet yang bagus tetap bermasalah kalau tidak cocok dengan kamar mandinya. Cek tiga hal ini sebelum membeli.

## 1. Jarak pembuangan

Ukur jarak dari dinding ke pusat lubang pembuangan di lantai. Angka ini menentukan apakah closet harus bertipe S-trap (pembuangan ke lantai) atau P-trap (pembuangan ke dinding), dan seberapa jauh jarak lubangnya.

## 2. Ukuran ruang

Sisakan ruang gerak yang nyaman di depan dan samping closet. Kamar mandi kecil biasanya lebih cocok dengan bentuk closet yang ramping.

## 3. Tipe flush

Closet ada yang memakai tangki terpisah, ada yang menyatu. Pilih sesuai ketinggian plafon, tekanan air, dan selera tampilan.

## Tidak yakin?

Kirim foto kamar mandi dan ukuran jarak pembuangan ke tim kami lewat WhatsApp, kami bantu cek tipe yang cocok.
MD,
            ],
            [
                'slug' => 'memilih-kran-wastafel',
                'title' => 'Memilih Kran yang Cocok dengan Wastafel',
                'excerpt' => 'Kran dan wastafel harus cocok. Ini yang perlu dicek sebelum membeli keduanya.',
                'days' => 14,
                'content' => <<<'MD'
Kran yang bagus belum tentu bisa dipasang di wastafel pilihan Anda. Pastikan hal-hal berikut cocok.

## Lubang kran pada wastafel

Wastafel ada yang tanpa lubang kran, dengan satu lubang, atau tiga lubang. Kran yang dipasang di wastafel harus sesuai jumlah dan jarak lubangnya. Kran tembok tidak memerlukan lubang di wastafel.

## Tinggi kran

Kran yang terlalu rendah menyulitkan cuci tangan, sedangkan yang terlalu tinggi memercikkan air. Perhatikan juga tinggi leher kran terhadap mangkuk wastafel.

## Tekanan air

Jika tekanan air di rumah kecil, beberapa tipe kran akan terasa lemah. Sebutkan hal ini saat bertanya agar kami bisa menyarankan tipe yang sesuai.

## Sambungan air

Siapkan stopkran dan flexible hose, supaya air bisa diputus saat perawatan tanpa mematikan seluruh rumah.
MD,
            ],
            [
                'slug' => 'kegunaan-jet-spray',
                'title' => 'Jet Spray: Apa Fungsinya dan Apa yang Perlu Dipasang Bersamanya',
                'excerpt' => 'Jet spray hampir selalu dibeli bersama closet. Pahami kebutuhannya agar tidak ada yang terlewat.',
                'days' => 7,
                'content' => <<<'MD'
Jet spray adalah semprotan air di samping closet untuk membersihkan diri. Banyak pembeli closet sekalian memasangnya.

## Yang dibutuhkan

- Jet spray itu sendiri
- Kran cabang atau stopkran sebagai sumber air
- Flexible hose, jika sambungannya memakainya

## Tanyakan sebelum membeli

Pastikan tipe jet spray cocok dengan tempat pemasangan di kamar mandi Anda. Kirim foto area di samping closet ke tim kami jika ragu.
MD,
            ],
            [
                'slug' => 'tips-renovasi-kamar-mandi',
                'title' => 'Tips Menyiapkan Daftar Sanitary Sebelum Renovasi Kamar Mandi',
                'excerpt' => 'Daftar belanja yang rapi menghindari bolak-balik membeli barang yang terlewat.',
                'days' => 2,
                'content' => <<<'MD'
Renovasi kamar mandi sering molor gara-gara ada barang yang kurang. Susun daftar ini lebih dulu.

## Catat yang sudah ada

Foto kondisi sekarang: letak pembuangan, titik air, dan ukuran ruang. Informasi ini membantu memilih produk yang cocok.

## Susun daftar inti

Closet, wastafel, kran, dan shower adalah yang paling umum. Jangan lupa aksesori kecil seperti floor drain, stopkran, dan flexible hose.

## Tentukan budget per item

Bagi budget per kelompok produk supaya tidak habis di satu barang saja.

## Tanyakan ketersediaan

Beberapa produk tidak selalu ada stok. Tanyakan sebelum tukang mulai bekerja.
MD,
            ],
        ];

        foreach ($articles as $a) {
            Article::firstOrCreate(['slug' => $a['slug']], [
                'title' => $a['title'], 'excerpt' => $a['excerpt'], 'content' => $a['content'],
                'is_published' => true, 'published_at' => now()->subDays($a['days']),
            ]);
        }
    }
}