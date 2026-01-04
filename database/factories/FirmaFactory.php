<?php

namespace Database\Factories;

use App\Models\Firma;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Firma>
 */
class FirmaFactory extends Factory
{
    protected $model = Firma::class;

    public function definition(): array
    {
        $firmaTipleri = ['Teknoloji', 'Gıda', 'Tekstil', 'İnşaat', 'Otomotiv', 'Enerji'];
        $firmaEkleri = ['A.Ş.', 'Ltd. Şti.', 'San. ve Tic. A.Ş.', 'Tic. Ltd. Şti.'];
        
        $sehirler = ['İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya', 'Adana', 'Konya'];
        $sehir = fake()->randomElement($sehirler);
        
        $ilceler = [
            'İstanbul' => ['Kadıköy', 'Beşiktaş', 'Şişli', 'Üsküdar'],
            'Ankara' => ['Çankaya', 'Keçiören', 'Yenimahalle'],
            'İzmir' => ['Konak', 'Bornova', 'Karşıyaka'],
        ];

        return [
            'kod' => strtoupper(fake()->unique()->lexify('FRM-???')),
            'unvan' => fake()->randomElement(['Yıldız', 'Anadolu', 'Ege', 'Marmara', 'Akdeniz']) . ' ' . 
                       fake()->randomElement($firmaTipleri) . ' ' . 
                       fake()->randomElement($firmaEkleri),
            'vergi_dairesi' => $sehir . ' ' . fake()->randomElement(['Merkez', 'Büyük Mükellefler', 'Kurumlar']),
            'vergi_no' => fake()->numerify('##########'),
            'adres' => fake()->streetAddress(),
            'il' => $sehir,
            'ilce' => fake()->randomElement($ilceler[$sehir] ?? ['Merkez']),
            'telefon' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'website' => fake()->optional()->domainName(),
            'logo_path' => null,
            'is_active' => true,
            'ayarlar' => [
                'fatura_seri' => fake()->randomElement(['A', 'B', 'C']),
                'kdv_orani' => 20,
            ],
        ];
    }
}
