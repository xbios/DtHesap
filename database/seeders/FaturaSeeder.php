<?php

namespace Database\Seeders;

use App\Models\Firma;
use App\Models\Fatura;
use App\Models\FaturaDetay;
use App\Models\Cari;
use App\Models\Stok;
use Illuminate\Database\Seeder;

class FaturaSeeder extends Seeder
{
    public function run(): void
    {
        $firmalar = Firma::all();

        foreach ($firmalar as $firma) {
            $cariler = $firma->caris;
            $stoklar = $firma->stoks;
            $user = $firma->users->first();

            if ($cariler->isEmpty() || $stoklar->isEmpty()) {
                continue;
            }

            // 10 satış faturası
            for ($i = 0; $i < 10; $i++) {
                $fatura = Fatura::create([
                    'firma_id' => $firma->id,
                    'cari_id' => $cariler->where('tip', '!=', 'tedarikci')->random()->id,
                    'fatura_no' => 'SF-' . date('Y') . '-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                    'fatura_tip' => 'satis',
                    'tarih' => now()->subDays(rand(1, 180)),
                    'doviz_tip' => 'TRY',
                    'doviz_kur' => 1,
                    'odeme_durum' => fake()->randomElement(['beklemede', 'kismi', 'tamamlandi']),
                    'created_by' => $user->id,
                ]);

                // 2-4 detay ekle
                for ($j = 0; $j < rand(2, 4); $j++) {
                    $detay = FaturaDetay::create([
                        'firma_id' => $firma->id,
                        'fatura_id' => $fatura->id,
                        'stok_id' => $stoklar->random()->id,
                        'aciklama' => 'Satış kalemi ' . ($j + 1),
                        'miktar' => rand(1, 20),
                        'birim' => 'Adet',
                        'birim_fiyat' => rand(50, 500),
                        'kdv_oran' => 20,
                        'sira' => $j + 1,
                    ]);

                    $detay->calculateTotals();
                }

                $fatura->calculateTotals();
            }

            // 5 alış faturası
            for ($i = 0; $i < 5; $i++) {
                $fatura = Fatura::create([
                    'firma_id' => $firma->id,
                    'cari_id' => $cariler->where('tip', '!=', 'musteri')->random()->id,
                    'fatura_no' => 'AF-' . date('Y') . '-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                    'fatura_tip' => 'alis',
                    'tarih' => now()->subDays(rand(1, 180)),
                    'doviz_tip' => 'TRY',
                    'doviz_kur' => 1,
                    'odeme_durum' => fake()->randomElement(['beklemede', 'tamamlandi']),
                    'created_by' => $user->id,
                ]);

                // 2-3 detay ekle
                for ($j = 0; $j < rand(2, 3); $j++) {
                    $detay = FaturaDetay::create([
                        'firma_id' => $firma->id,
                        'fatura_id' => $fatura->id,
                        'stok_id' => $stoklar->random()->id,
                        'aciklama' => 'Alış kalemi ' . ($j + 1),
                        'miktar' => rand(10, 50),
                        'birim' => 'Adet',
                        'birim_fiyat' => rand(30, 300),
                        'kdv_oran' => 20,
                        'sira' => $j + 1,
                    ]);

                    $detay->calculateTotals();
                }

                $fatura->calculateTotals();
            }
        }

        $this->command->info('Her firma için 15 fatura oluşturuldu (10 satış, 5 alış).');
    }
}
