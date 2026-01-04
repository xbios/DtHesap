<?php

namespace Database\Factories;

use App\Models\Cari;
use App\Models\Firma;
use Illuminate\Database\Eloquent\Factories\Factory;

class CariFactory extends Factory
{
    protected $model = Cari::class;

    public function definition(): array
    {
        $tip = fake()->randomElement(['musteri', 'tedarikci', 'her_ikisi']);
        
        $firmaIsimleri = [
            'Yıldız Market', 'Anadolu Gıda', 'Ege Tekstil', 'Marmara İnşaat',
            'Akdeniz Turizm', 'Karadeniz Balık', 'Doğu Mobilya', 'Batı Otomotiv'
        ];
        
        $firmaEkleri = ['A.Ş.', 'Ltd. Şti.', 'San. ve Tic. Ltd. Şti.'];

        return [
            'firma_id' => Firma::factory(),
            'kod' => strtoupper(fake()->unique()->bothify('CR-###??')),
            'unvan' => fake()->randomElement($firmaIsimleri) . ' ' . fake()->randomElement($firmaEkleri),
            'tip' => $tip,
            'vergi_dairesi' => fake()->randomElement(['İstanbul', 'Ankara', 'İzmir']) . ' ' . 
                               fake()->randomElement(['Merkez', 'Kurumlar']),
            'vergi_no' => fake()->optional(0.7)->numerify('##########'),
            'tc_kimlik_no' => fake()->optional(0.3)->numerify('###########'),
            'adres' => fake()->address(),
            'il' => fake()->randomElement(['İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya']),
            'ilce' => fake()->randomElement(['Merkez', 'Kadıköy', 'Çankaya', 'Konak']),
            'telefon' => fake()->phoneNumber(),
            'email' => fake()->optional()->safeEmail(),
            'yetkili_kisi' => fake()->name(),
            'aciklama' => fake()->optional()->sentence(),
            'borc_limiti' => fake()->randomFloat(2, 5000, 100000),
            'is_active' => fake()->boolean(90), // %90 aktif
        ];
    }

    public function musteri(): static
    {
        return $this->state(fn (array $attributes) => [
            'tip' => 'musteri',
        ]);
    }

    public function tedarikci(): static
    {
        return $this->state(fn (array $attributes) => [
            'tip' => 'tedarikci',
        ]);
    }
}
