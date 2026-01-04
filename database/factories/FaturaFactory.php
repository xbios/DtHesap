<?php

namespace Database\Factories;

use App\Models\Fatura;
use App\Models\Firma;
use App\Models\Cari;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaturaFactory extends Factory
{
    protected $model = Fatura::class;

    public function definition(): array
    {
        $faturaTip = fake()->randomElement(['alis', 'satis']);
        $tarih = fake()->dateTimeBetween('-6 months', 'now');

        return [
            'firma_id' => Firma::factory(),
            'cari_id' => Cari::factory(),
            'fatura_no' => strtoupper(fake()->unique()->bothify('F-####-???')),
            'fatura_tip' => $faturaTip,
            'tarih' => $tarih,
            'vade_tarih' => fake()->optional()->dateTimeBetween($tarih, '+3 months'),
            'toplam_tutar' => 0, // calculateTotals() ile hesaplanacak
            'kdv_tutar' => 0,
            'genel_toplam' => 0,
            'indirim_tutar' => 0,
            'doviz_tip' => fake()->randomElement(['TRY', 'USD', 'EUR']),
            'doviz_kur' => fake()->randomFloat(4, 1, 35),
            'odeme_durum' => fake()->randomElement(['beklemede', 'kismi', 'tamamlandi']),
            'aciklama' => fake()->optional()->sentence(),
            'created_by' => User::factory(),
        ];
    }

    public function alis(): static
    {
        return $this->state(fn (array $attributes) => [
            'fatura_tip' => 'alis',
        ]);
    }

    public function satis(): static
    {
        return $this->state(fn (array $attributes) => [
            'fatura_tip' => 'satis',
        ]);
    }
}
