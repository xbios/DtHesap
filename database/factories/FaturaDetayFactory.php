<?php

namespace Database\Factories;

use App\Models\FaturaDetay;
use App\Models\Firma;
use App\Models\Fatura;
use App\Models\Stok;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaturaDetayFactory extends Factory
{
    protected $model = FaturaDetay::class;

    public function definition(): array
    {
        $miktar = fake()->randomFloat(2, 1, 100);
        $birimFiyat = fake()->randomFloat(2, 10, 1000);
        $kdvOran = fake()->randomElement([1, 8, 18, 20]);
        $indirimOran = fake()->optional(0.3)->randomFloat(2, 0, 20); // %30 ihtimalle indirim

        return [
            'firma_id' => Firma::factory(),
            'fatura_id' => Fatura::factory(),
            'stok_id' => Stok::factory(),
            'aciklama' => fake()->sentence(3),
            'miktar' => $miktar,
            'birim' => fake()->randomElement(['Adet', 'Kg', 'Lt', 'Paket']),
            'birim_fiyat' => $birimFiyat,
            'kdv_oran' => $kdvOran,
            'kdv_tutar' => 0, // calculateTotals() ile hesaplanacak
            'indirim_oran' => $indirimOran ?? 0,
            'indirim_tutar' => 0, // calculateTotals() ile hesaplanacak
            'toplam' => 0, // calculateTotals() ile hesaplanacak
            'sira' => fake()->numberBetween(1, 10),
        ];
    }
}
