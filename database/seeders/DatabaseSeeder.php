<?php

namespace Database\Seeders;

use App\Models\BerasPrice;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun admin utama untuk keperluan uji coba & operasional.
        $admin = User::create([
            'name' => 'Admin BAZNAS',
            'email' => 'admin@zakatbanua.test',
            'password' => 'password123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Harga beras acuan awal (sumber data kalkulator zakat fitrah).
        BerasPrice::create([
            'price' => 16000,
            'note' => 'Harga acuan awal BAZNAS',
            'updated_by' => $admin->id,
        ]);
    }
}
