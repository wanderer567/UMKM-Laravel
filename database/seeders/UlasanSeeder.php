<?php

namespace Database\Seeders;

use App\Models\Ulasan;
use App\Models\User;   // Pastikan ini mengarah ke model tb_users
use App\Models\Produk; // Pastikan ini mengarah ke model tb_produk
use Illuminate\Database\Seeder;

class UlasanSeeder extends Seeder
{
    public function run()
    {
        // Mencari user pertama yang role-nya pelanggan
        $pelanggan = User::where('role', 'pelanggan')->first();
        // Mencari produk pertama yang ada di toko
        $produk = Produk::first();

        if ($pelanggan && $produk) {
            Ulasan::create([
                'id_users' => $pelanggan->id,
                'id_produk' => $produk->id,
                'rating' => 5.0,
                'komentar' => 'Barangnya bagus banget, Irsyad! Respon admin cepat.'
            ]);
            
            $this->command->info("Seeding ulasan berhasil!");
        } else {
            $this->command->error("Gagal: Kamu harus punya minimal 1 user pelanggan dan 1 produk!");
        }
    }
}