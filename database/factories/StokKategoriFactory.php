<?php

namespace Database\Factories;

use App\Models\StokKategori;
use App\Models\Firma;
use Illuminate\Database\Eloquent\Factories\Factory;

class StokKategoriFactory extends Factory
{
    protected $model = StokKategori::class;

    public function definition(): array
    {
        $kategoriler = [
            'Elektronik', 'Gıda', 'Tekstil', 'Mobilya', 'Kırtasiye',
            'Temizlik', 'Kozmetik', 'Oyuncak', 'Spor', 'Kitap'
        ];

        return [
            'firma_id' => Firma::factory(),
            'parent_id' => null,
            'ad' => fake()->randomElement($kategoriler),
            'kod' => strtoupper(fake()->unique()->lexify('KAT-???')),
            'sira' => fake()->numberBetween(1, 100),
        ];
    }

    public function altKategori(): static
    {
        return $this->state(function (array $attributes) {
            $altKategoriler = [
                'Bilgisayar', 'Telefon', 'Tablet', // Elektronik
                'Temel Gıda', 'İçecek', 'Atıştırmalık', // Gıda
                'Giyim', 'Ayakkabı', 'Aksesuar', // Tekstil
            ];

            return [
                'ad' => fake()->randomElement($altKategoriler),
                'parent_id' => StokKategori::factory(),
            ];
        });
    }
}
