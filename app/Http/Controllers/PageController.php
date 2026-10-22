<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PageController extends Controller
{
    // Isi landing lokal. Setiap halaman punya sudut pandang berbeda, bukan template ganti nama kota.
    const LOCAL = [
        'sanitary-bogor' => [
            'title' => 'Toko Sanitary di Bogor: Closet, Wastafel, Kran & Shower',
            'description' => 'Toko sanitary dan perlengkapan kamar mandi di Bogor. Lihat produk langsung di showroom Top Sains atau tanyakan harga via WhatsApp.',
            'h1' => 'Toko sanitary di Bogor untuk rumah dan proyek',
            'intro' => 'Top Sains Bangunan berlokasi di Bogor. Anda bisa melihat produk langsung di showroom, atau menanyakan harga dan ketersediaan lewat WhatsApp sebelum datang.',
            'body' => [
                'Closet, wastafel, kran, shower, urinoir, aksesori, hingga spare part tersedia dalam satu katalog. Cocok untuk rumah baru, renovasi kamar mandi, maupun kebutuhan proyek.',
                'Sebelum berkunjung, siapkan ukuran kamar mandi atau foto kondisi saat ini. Dengan begitu tim kami lebih mudah membantu memilih produk yang pas.',
            ],
        ],
        'toto-bogor' => [
            'title' => 'Produk TOTO di Bogor: Closet, Wastafel, Kran & Shower',
            'description' => 'Jual produk TOTO di Bogor: closet, wastafel, kran, shower, dan urinoir. Tanyakan harga dan ketersediaan via WhatsApp.',
            'h1' => 'Produk TOTO di Bogor',
            'intro' => 'Top Sains Bangunan menjual produk TOTO untuk kebutuhan rumah dan proyek. Cari berdasarkan tipe atau SKU, lalu tanyakan harga dan ketersediaan terbaru.',
            'body' => [
                'Produk TOTO punya banyak seri dan kode. Jika Anda sudah punya SKU dari gambar kerja atau katalog, kirimkan ke kami dan kami cek ketersediaannya.',
                'Belum tahu tipe yang cocok? Gunakan halaman Bantu Saya Memilih, atau ceritakan kebutuhan Anda langsung lewat WhatsApp.',
            ],
        ],
        'sanitary-jakarta' => [
            'title' => 'Sanitary untuk Customer Jakarta | Top Sains Bangunan',
            'description' => 'Top Sains Bangunan melayani customer dari Jakarta untuk sanitary TOTO, retail maupun proyek. Tanyakan harga dan ketersediaan via WhatsApp.',
            'h1' => 'Sanitary untuk customer Jakarta',
            'intro' => 'Showroom kami berada di Bogor, dan kami juga melayani customer dari Jakarta untuk kebutuhan retail maupun proyek.',
            'body' => [
                'Untuk pembelian dari Jakarta, mulailah dengan menanyakan produk dan ketersediaan lewat WhatsApp. Soal pengiriman ke lokasi Anda, tanyakan langsung ke tim kami.',
                'Untuk proyek di Jakarta, gunakan form Request Quotation. Sertakan lokasi proyek dan daftar kebutuhan agar penawaran bisa disiapkan.',
            ],
        ],
        'sanitary-bsd' => [
            'title' => 'Sanitary untuk Customer BSD & Tangerang | Top Sains Bangunan',
            'description' => 'Top Sains Bangunan melayani customer BSD dan sekitarnya untuk sanitary TOTO, retail maupun proyek. Tanyakan via WhatsApp.',
            'h1' => 'Sanitary untuk customer BSD dan sekitarnya',
            'intro' => 'Kami melayani customer dari BSD dan sekitarnya. Showroom berada di Bogor, dan konsultasi bisa dimulai dari WhatsApp.',
            'body' => [
                'Kirim nama produk, SKU, atau foto referensi kamar mandi Anda. Tim kami akan membantu mengecek ketersediaan dan harga.',
                'Untuk kebutuhan proyek atau perumahan di area BSD, sampaikan jumlah unit dan lokasi lewat form Request Quotation.',
            ],
        ],
    ];

    public function afterSales() { return view('pages.after-sales'); }
    public function about()      { return view('pages.about'); }
    public function contact()    { return view('pages.contact'); }

    public function local(string $slug)
    {
        $products = Product::with(['category', 'brand'])
            ->where('is_active', true)->where('is_best_seller', true)
            ->orderBy('sort_order')->take(4)->get();

        return view('pages.local', ['page' => self::LOCAL[$slug], 'slug' => $slug, 'products' => $products]);
    }
}