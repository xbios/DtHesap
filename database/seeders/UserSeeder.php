<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Firma;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ana admin kullanıcısını oluştur veya güncelle
        $admin = User::updateOrCreate(
            ['email' => 'admin@dthesap.com'],
            [
                'name' => 'Erol Örnek',
                'password' => Hash::make('password'),
            ]
        );

        // Mevcut firmaları al
        $firmalar = Firma::all();

        // Eğer hiç firma yoksa bir tane oluştur
        if ($firmalar->isEmpty()) {
            $firma = Firma::create([
                'kod' => 'DT001',
                'unvan' => 'DT Hesap Yazılım LTD STI',
                'vergi_no' => '1234567890',
                'vergi_dairesi' => 'Kadıköy',
            ]);
            $firmalar = collect([$firma]);
        }

        // Admini tüm firmalara bağla
        foreach ($firmalar as $firma) {
            $firma->users()->attach($admin->id, [
                'rol' => 'admin',
                'yetki_seviyesi' => 10,
            ]);
        }

        $this->command->info('Admin kullanıcısı (admin@dthesap.com) oluşturuldu ve firmalara bağlandı.');
    }
}
