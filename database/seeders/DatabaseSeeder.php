<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            TestimonialSeeder::class,
            ProjectSeeder::class,
            ArticleSeeder::class,
            AdminSeeder::class,
        ]);
    }
}