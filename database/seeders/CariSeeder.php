<?php

namespace Database\Seeders;

use App\Models\Firma;
use App\Models\Cari;
use Illuminate\Database\Seeder;

class CariSeeder extends Seeder
{
    public function run(): void
    {
        $firmalar = Firma::all();

        foreach ($firmalar as $firma) {
            // Her firma için 10 cari oluştur
            // 5 müşteri, 3 tedarikçi, 2 her ikisi
            Cari::factory()->count(5)->musteri()->create(['firma_id' => $firma->id]);
            Cari::factory()->count(3)->tedarikci()->create(['firma_id' => $firma->id]);
            Cari::factory()->count(2)->create(['firma_id' => $firma->id, 'tip' => 'her_ikisi']);
        }

        $this->command->info('Her firma için 10 cari oluşturuldu.');
    }
}
