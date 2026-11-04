<?php

namespace Database\Seeders;

use App\Models\{Article, Project, Testimonial};
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // CONTOH. Ganti dengan testimonial asli, lalu aktifkan dan centang Featured.
        Testimonial::firstOrCreate(['name' => '[Contoh] Nama Customer'], [
            'role_company' => '[Contoh] Pemilik rumah, Bogor',
            'content'      => '[Contoh] Ganti dengan testimonial asli dari customer.',
            'is_featured'  => false,
            'is_active'    => false,
            'sort_order'   => 0,
        ]);

        // CONTOH. Ganti dengan project asli.
        Project::firstOrCreate(['slug' => 'contoh-project'], [
            'name'        => '[Contoh] Nama Project',
            'type'        => 'Residential',
            'location'    => 'Bogor',
            'description' => '[Contoh] Ganti dengan deskripsi project yang pernah dilayani.',
            'is_featured' => false,
            'is_active'   => false,
            'sort_order'  => 0,
        ]);

        // Draft, tidak tampil di website sampai Anda terbitkan.
        Article::firstOrCreate(['slug' => 'cara-memilih-closet'], [
            'title'        => 'Cara Memilih Closet untuk Kamar Mandi Anda',
            'excerpt'      => 'Hal yang perlu dicek sebelum membeli closet: jarak pembuangan, ukuran ruang, dan tipe flush.',
            'content'      => "## Cek jarak pembuangan dulu\n\nUkur jarak dari dinding ke pusat lubang pembuangan. Angka ini menentukan tipe closet yang bisa dipasang.\n\n## Perhatikan ukuran ruang\n\nPastikan ada ruang gerak yang cukup di depan dan samping closet.\n\n## Pilih tipe flush\n\nTanyakan ke tim kami tipe yang sesuai dengan kebutuhan dan budget Anda.\n\n[Ganti dengan isi artikel sendiri sebelum diterbitkan.]",
            'is_published' => false,
        ]);
    }
}