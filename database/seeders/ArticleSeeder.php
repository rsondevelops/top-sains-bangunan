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
                'slug' => 'toko-toto-bogor-yang-perlu-ditanyakan',
                'title' => 'Mencari Toko TOTO di Bogor: Yang Perlu Ditanyakan Sebelum Membeli',
                'excerpt' => 'Sebelum membeli produk TOTO di Bogor, tanyakan lima hal ini agar produk yang datang sesuai kebutuhan.',
                'meta_title' => 'Toko TOTO Bogor: 5 Hal yang Perlu Ditanyakan Sebelum Membeli',
                'meta_description' => 'Panduan membeli produk TOTO di Bogor: kode produk, ketersediaan, harga terbaru, spare part, dan layanan setelah pembelian.',
                'days' => 30,
                'content' => <<<'MD'
Produk TOTO punya banyak seri dan kode. Supaya tidak salah beli, ada beberapa hal yang sebaiknya ditanyakan lebih dulu ke toko TOTO di Bogor tempat Anda berbelanja.

## 1. Apakah kode produknya tersedia?

Sebutkan kode lengkap, misalnya CW53 atau LW246. Kode yang sedikit berbeda bisa berarti produk yang berbeda, jadi cocokkan dengan gambar kerja atau daftar belanja Anda.

## 2. Berapa harga terbarunya?

Harga bisa berubah. Cek [pricelist dan katalog TOTO](/katalog-pricelist) sebagai acuan, lalu konfirmasi harga terbaru lewat WhatsApp.

## 3. Apa saja yang perlu dibeli bersamanya?

Closet biasanya dilengkapi jet spray, stopkran, dan flexible hose. Wastafel perlu kran yang lubangnya cocok. Tanyakan daftar pelengkapnya supaya tidak bolak-balik.

## 4. Bagaimana jika butuh spare part nanti?

Fill valve, flush valve, dan jet spray kadang perlu diganti. Pilih toko yang bisa membantu mencarikan part dari foto atau kode produk lama.

## 5. Bisa melihat langsung di showroom?

Top Sains Bangunan berada di Jl. Raya Tajur, Bogor Selatan, buka setiap hari 08:00-17:00. Lihat [halaman TOTO Bogor](/toto-bogor) untuk alamat dan peta, atau tanyakan ketersediaan dulu lewat WhatsApp sebelum datang.
MD,
            ],
            [
                'slug' => 'cara-memilih-closet-toto',
                'title' => 'Cara Memilih Closet TOTO untuk Kamar Mandi Anda',
                'excerpt' => 'Tiga hal yang perlu dicek sebelum membeli closet TOTO: jarak pembuangan, ukuran ruang, dan tipe flush.',
                'meta_title' => 'Cara Memilih Closet TOTO: Jarak Pembuangan, Ukuran, Flush',
                'meta_description' => 'Panduan memilih closet TOTO untuk rumah dan renovasi di Bogor: cek jarak pembuangan, ukuran ruang, dan tipe flush.',
                'days' => 21,
                'content' => <<<'MD'
Closet yang bagus tetap bermasalah kalau tidak cocok dengan kamar mandinya. Cek tiga hal ini sebelum membeli closet TOTO.

## 1. Jarak pembuangan

Ukur jarak dari dinding ke pusat lubang pembuangan di lantai. Angka ini menentukan apakah closet harus bertipe S-trap (pembuangan ke lantai) atau P-trap (pembuangan ke dinding).

## 2. Ukuran ruang

Sisakan ruang gerak yang nyaman di depan dan samping closet. Kamar mandi kecil biasanya lebih cocok dengan bentuk closet yang ramping.

## 3. Tipe flush

Closet ada yang memakai tangki terpisah, ada yang menyatu. Pilih sesuai ketinggian plafon, tekanan air, dan selera tampilan.

## Tidak yakin?

Kirim foto kamar mandi dan ukuran jarak pembuangan ke tim kami lewat WhatsApp. Lihat juga [koleksi closet](/produk/closet) yang paling banyak dicari di Top Sains Bangunan, Bogor.
MD,
            ],
            [
                'slug' => 'memilih-kran-wastafel-toto',
                'title' => 'Memilih Kran dan Wastafel TOTO yang Saling Cocok',
                'excerpt' => 'Kran dan wastafel harus cocok. Ini yang perlu dicek sebelum membeli keduanya.',
                'meta_title' => 'Memilih Kran dan Wastafel TOTO yang Cocok | Top Sains Bangunan',
                'meta_description' => 'Cara memilih kran dan wastafel TOTO yang cocok: lubang kran, tinggi kran, tekanan air, dan sambungan.',
                'days' => 14,
                'content' => <<<'MD'
Kran yang bagus belum tentu bisa dipasang di wastafel pilihan Anda. Pastikan hal berikut cocok.

## Lubang kran pada wastafel

Wastafel ada yang tanpa lubang kran, dengan satu lubang, atau tiga lubang. Kran yang dipasang harus sesuai jumlah dan jarak lubangnya. Kran tembok tidak memerlukan lubang di wastafel.

## Tinggi kran

Kran yang terlalu rendah menyulitkan cuci tangan, yang terlalu tinggi memercikkan air. Perhatikan juga tinggi leher kran terhadap mangkuk wastafel.

## Tekanan air

Jika tekanan air di rumah kecil, beberapa tipe kran terasa lemah. Sebutkan ini saat bertanya agar kami bisa menyarankan tipe yang sesuai.

## Sambungan air

Siapkan stopkran dan flexible hose supaya air bisa diputus saat perawatan tanpa mematikan seluruh rumah.

Lihat pilihan [wastafel](/produk/wastafel) dan [kran](/produk/kran) di Top Sains Bangunan Bogor, atau tanyakan kecocokannya lewat WhatsApp.
MD,
            ],
            [
                'slug' => 'kegunaan-jet-spray',
                'title' => 'Jet Spray: Fungsi dan Apa yang Perlu Dipasang Bersamanya',
                'excerpt' => 'Jet spray hampir selalu dibeli bersama closet. Pahami kebutuhannya agar tidak ada yang terlewat.',
                'meta_title' => null,
                'meta_description' => null,
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
                'slug' => 'sanitary-toto-untuk-kontraktor-bogor',
                'title' => 'Sanitary TOTO untuk Proyek di Bogor: Menyiapkan Daftar Kebutuhan',
                'excerpt' => 'Panduan singkat bagi kontraktor dan developer menyusun daftar sanitary TOTO agar penawaran cepat dan akurat.',
                'meta_title' => 'Sanitary TOTO untuk Proyek di Bogor | Panduan untuk Kontraktor',
                'meta_description' => 'Cara menyiapkan daftar kebutuhan sanitary TOTO untuk proyek di Bogor, Jakarta, dan BSD supaya penawaran cepat dan akurat.',
                'days' => 5,
                'content' => <<<'MD'
Penawaran proyek jadi lebih cepat kalau daftar kebutuhannya jelas. Berikut yang sebaiknya disiapkan sebelum menghubungi toko TOTO di Bogor.

## Siapkan data berikut

- Daftar produk beserta kode atau SKU
- Jumlah per produk
- Lokasi proyek dan jadwal kebutuhan
- BoQ atau gambar kerja, jika ada

## Jangan lupa pelengkap

Closet, wastafel, dan kran hanya sebagian. Stopkran, flexible hose, floor drain, dan jet spray sering terlewat di BoQ.

## Kirim lewat form

Gunakan [form Request Quotation](/solusi/proyek) atau hubungi kami lewat WhatsApp. Kami melayani proyek di Bogor, Jakarta, BSD, dan sekitarnya.
MD,
            ],
            [
                'slug' => 'pricelist-toto-cara-mengecek-harga',
                'title' => 'Pricelist TOTO: Cara Mengecek Harga yang Berlaku',
                'excerpt' => 'Pricelist adalah acuan, bukan harga final. Begini cara memastikan harga terbaru produk TOTO.',
                'meta_title' => 'Pricelist TOTO: Cara Mengecek Harga Terbaru',
                'meta_description' => 'Cara memakai pricelist TOTO dan memastikan harga serta ketersediaan terbaru sebelum membeli di Bogor.',
                'days' => 3,
                'content' => <<<'MD'
Pricelist membantu memperkirakan budget, tetapi harga dan ketersediaan bisa berubah.

## Cek periode berlaku

Lihat tanggal atau periode yang tertera di dokumen. Pricelist lama bisa sudah tidak berlaku.

## Cocokkan kode produk

Cari berdasarkan kode, bukan hanya nama. Kode yang mirip bisa berarti produk berbeda.

## Konfirmasi sebelum memesan

Kirim kode produk ke WhatsApp kami untuk harga dan stok terbaru. Dokumen terbaru tersedia di halaman [Pricelist & Katalog](/katalog-pricelist).
MD,
            ],
        ];

        foreach ($articles as $a) {
            Article::updateOrCreate(['slug' => $a['slug']], [
                'title' => $a['title'], 'excerpt' => $a['excerpt'], 'content' => $a['content'],
                'meta_title' => $a['meta_title'], 'meta_description' => $a['meta_description'],
                'is_published' => true, 'published_at' => now()->subDays($a['days']),
            ]);
        }

        // Slug lama yang digantikan versi baru di atas
        Article::whereIn('slug', ['cara-memilih-closet', 'memilih-kran-wastafel', 'tips-renovasi-kamar-mandi'])->delete();
    }
}