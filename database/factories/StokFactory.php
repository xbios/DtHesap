<?php

namespace Database\Factories;

use App\Models\Stok;
use App\Models\Firma;
use App\Models\StokKategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class StokFactory extends Factory
{
    protected $model = Stok::class;

    public function definition(): array
    {
        $urunler = [
            'Laptop', 'Mouse', 'Klavye', 'Monitör', 'Kulaklık',
            'Ekmek', 'Süt', 'Yoğurt', 'Peynir', 'Zeytin',
            'Tişört', 'Pantolon', 'Ayakkabı', 'Çanta', 'Kemer',
            'Masa', 'Sandalye', 'Dolap', 'Raf', 'Koltuk'
        ];

        $birimler = ['Adet', 'Kg', 'Lt', 'Paket', 'Kutu', 'Metre'];

        return [
            'firma_id' => Firma::factory(),
            'kod' => strtoupper(fake()->unique()->bothify('STK-###??')),
            'ad' => fake()->randomElement($urunler) . ' ' . fake()->optional()->word(),
            'kategori_id' => StokKategori::factory(),
            'birim' => fake()->randomElement($birimler),
            'barkod' => fake()->optional()->ean13(),
            'kdv_oran' => fake()->randomElement([1, 8, 18, 20]),
            'alis_fiyat' => $alisFiyat = fake()->randomFloat(2, 10, 1000),
            'satis_fiyat' => $alisFiyat * fake()->randomFloat(2, 1.2, 2.5), // %20-150 kar marjı
            'min_stok' => fake()->numberBetween(5, 20),
            'max_stok' => fake()->numberBetween(50, 200),
            'aciklama' => fake()->optional()->sentence(),
            'resim_path' => null,
            'is_active' => fake()->boolean(95), // %95 aktif
        ];
    }
}
