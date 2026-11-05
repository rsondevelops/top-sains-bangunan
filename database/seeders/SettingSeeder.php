<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'whatsapp_number'  => '625280660193',
            'phone'            => '625280660193',
            'address'          => "TOP SAINS BANGUNAN, Jl. Raya Tajur No.202, RT.03/RW.07, Tajur 2, Kec. Bogor Sel., Kota Bogor, Jawa Barat 16137",
            'opening_hours'    => 'Setiap Hari 08:00-17:00',
            'maps_url'         => 'https://maps.app.goo.gl/QMpxbbZZ4p6nx1Ur8',
            'maps_embed'       => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.0712868149117!2d106.82890507515565!3d-6.638069564891915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c9c41bcc1e89%3A0x235274227349a04c!2sTOP%20SAINS%20BANGUNAN!5e0!3m2!1sid!2sid!4v1793833915999!5m2!1sid!2sid',
            'year_established' => '2023',
            'about_story'      => <<<'TXT'
Top Sains Bangunan berdiri pada 2023 di Bogor, dengan satu fokus: membantu customer mendapatkan sanitary yang tepat untuk rumah maupun proyek mereka.

Sejak awal, kami mengutamakan kualitas. Produk yang kami tawarkan adalah produk yang kami yakin layak dipasang dan dipakai bertahun-tahun, terutama dari brand TOTO.

Setiap tahun, kami melayani lebih dari 100 klien yang berbeda, mulai dari pemilik rumah yang sedang renovasi sampai kontraktor dan pengelola proyek. Pengalaman dengan beragam kebutuhan itu membuat kami terbiasa membantu customer memilih produk yang sesuai dengan ruang dan budget mereka.

Hubungan dengan customer tidak berhenti setelah pembelian. Jika ada pertanyaan soal pemasangan, spare part, atau produk yang sudah dibeli, tim kami siap membantu.
TXT,
            'aftersales_points' => implode("\n", [
                'Bantuan klaim garansi ke distributor atau pabrik jika produk cacat',
                'Penyediaan spare part: fill valve, flush valve, tombol flush, jet spray, cartridge kran, flexible, dan lainnya',
                'Bantuan mencarikan part atau pengganti yang cocok dari foto atau kode produk lama',
                'Konsultasi teknis pemasangan: jarak pembuangan closet, tekanan air, kecocokan kran dan wastafel',
                'Penanganan jika barang yang diterima salah atau rusak',
            ]),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Key opsional: dibuat kosong hanya jika belum ada
        Setting::firstOrCreate(['key' => 'instagram'], ['value' => null]);
    }
}