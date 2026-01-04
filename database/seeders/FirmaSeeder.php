<?php

namespace Database\Seeders;

use App\Models\Firma;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FirmaSeeder extends Seeder
{
    public function run(): void
    {
        // 2 firma oluştur
        $firmalar = Firma::factory()->count(2)->create();

        // Her firma için bir admin kullanıcı oluştur
        foreach ($firmalar as $index => $firma) {
            $user = User::create([
                'name' => 'Admin ' . ($index + 1),
                'email' => 'admin' . ($index + 1) . '@' . str_replace(' ', '', strtolower($firma->unvan)) . '.com',
                'password' => Hash::make('password'),
            ]);

            // Kullanıcıyı firmaya bağla
            $firma->users()->attach($user->id, [
                'rol' => 'admin',
                'yetki_seviyesi' => 10,
            ]);
        }

        $this->command->info('2 firma ve admin kullanıcıları oluşturuldu.');
    }
}
