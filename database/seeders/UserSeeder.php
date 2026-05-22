<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Admin
        User::create([
            'nama' => 'Irsyad Admin',
            'email' => 'admin@gmail.com',
            'username' => 'irsyad_admin',
            'password' => Hash::make('password123'),
            'hp' => '08123456789',
            'alamat' => 'Cirebon, Jawa Barat',
            'role' => 'admin',
            'is_vip' => 0,
        ]);

        // 2. Data Pelanggan Reguler
        User::create([
            'nama' => 'Budi Pelanggan',
            'email' => 'budi@gmail.com',
            'username' => 'budi_user',
            'password' => Hash::make('password123'),
            'hp' => '08987654321',
            'alamat' => 'Jakarta Selatan',
            'role' => 'pelanggan',
            'is_vip' => 0,
        ]);

        // 3. Data Pelanggan VIP
        User::create([
            'nama' => 'Siti VIP',
            'email' => 'siti@gmail.com',
            'username' => 'siti_vip',
            'password' => Hash::make('password123'),
            'hp' => '08555544433',
            'alamat' => 'Bandung, Jawa Barat',
            'role' => 'pelanggan',
            'is_vip' => 1, // Status VIP aktif
        ]);
    }
}