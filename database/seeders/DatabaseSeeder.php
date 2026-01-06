<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FirmaSeeder::class,
            UserSeeder::class,
            CariSeeder::class,
            StokSeeder::class,
            FaturaSeeder::class,
        ]);

        $this->command->info('Tüm seederlar başarıyla çalıştırıldı!');
    }
}
