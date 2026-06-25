<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SiteSettingsSeeder::class,
            ProgrammesSeeder::class,
            NewsArticlesSeeder::class,
            PartnersSeeder::class,
        ]);
    }
}
