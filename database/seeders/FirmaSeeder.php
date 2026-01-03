<?php

namespace Database\Seeders;

use App\Models\Firma;
use App\Models\User;
use Illuminate\Database\Seeder;

class FirmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function up(?User $user = null): void
    {
        // Try to find the test user specifically
        $user = $user ?? User::where('email', 'test@example.com')->first();

        // Fallback to first user
        $user = $user ?? User::first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $firma1 = Firma::create([
            'kod' => 'DEMO01',
            'unvan' => 'Antigravity Teknoloji A.Ş.',
            'vergi_dairesi' => 'Zincirlikuyu',
            'vergi_no' => '1234567890',
            'adres' => 'Levent Plaza Kat:14',
            'il' => 'İstanbul',
            'ilce' => 'Beşiktaş',
            'is_active' => true,
        ]);

        $firma2 = Firma::create([
            'kod' => 'DEMO02',
            'unvan' => 'DeepMind Global Limited',
            'vergi_dairesi' => 'Büyük Mükellefler',
            'vergi_no' => '0987654321',
            'adres' => 'Pancras Square',
            'il' => 'London',
            'ilce' => 'Kings Cross',
            'is_active' => true,
        ]);

        // Link user to both firms
        $user->firmas()->attach($firma1->id, ['rol' => 'admin', 'yetki_seviyesi' => 5]);
        $user->firmas()->attach($firma2->id, ['rol' => 'manager', 'yetki_seviyesi' => 3]);

        // Set current firma for the user
        $user->current_firma_id = $firma1->id;
        $user->save();
    }

    /**
     * Compatibility wrapper for call()
     */
    public function run(): void
    {
        $this->up();
    }
}
