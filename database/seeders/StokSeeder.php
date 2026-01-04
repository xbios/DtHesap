<?php

namespace Database\Seeders;

use App\Models\Firma;
use App\Models\StokKategori;
use App\Models\Stok;
use Illuminate\Database\Seeder;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $firmalar = Firma::all();

        foreach ($firmalar as $firma) {
            // Ana kategoriler
            $anaKategoriler = [
                'Elektronik' => ['Bilgisayar', 'Telefon'],
                'Gıda' => ['Temel Gıda', 'İçecek'],
                'Tekstil' => ['Giyim', 'Ayakkabı'],
            ];

            foreach ($anaKategoriler as $anaKat => $altKatlar) {
                // Ana kategori oluştur
                $anaKategori = StokKategori::create([
                    'firma_id' => $firma->id,
                    'parent_id' => null,
                    'ad' => $anaKat,
                    'kod' => strtoupper(substr($anaKat, 0, 3)),
                    'sira' => 1,
                ]);

                // Alt kategoriler oluştur
                foreach ($altKatlar as $index => $altKat) {
                    $altKategori = StokKategori::create([
                        'firma_id' => $firma->id,
                        'parent_id' => $anaKategori->id,
                        'ad' => $altKat,
                        'kod' => strtoupper(substr($altKat, 0, 3)),
                        'sira' => $index + 1,
                    ]);

                    // Her alt kategori için 3-4 stok oluştur
                    Stok::factory()->count(rand(3, 4))->create([
                        'firma_id' => $firma->id,
                        'kategori_id' => $altKategori->id,
                    ]);
                }
            }
        }

        $this->command->info('Her firma için kategoriler ve stoklar oluşturuldu.');
    }
}
