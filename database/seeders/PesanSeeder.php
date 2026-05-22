<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesan;
use App\Models\User; // Pastikan model User atau Pelanggan sudah benar

class PesanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user di database, kalau belum ada, kita tembak ke ID 1
        $user = User::first(); 
        
        if (!$user) {
            return; // Berhenti jika tidak ada user sama sekali
        }

        $dataPesan = [
            [
                'id_pelanggan' => $user->id,
                'subjek' => 'Gagal Scan QR Code',
                'isi_pesan' => 'Min, saat saya mau absen/bayar pakai QR, kamera HP saya tidak mau terbuka. Mohon bantuannya.',
                'status' => 'unread',
                'tipe' => 'error',
                'created_at' => now()->subHours(2),
            ],
            [
                'id_pelanggan' => $user->id,
                'subjek' => 'Tanya Stok Keripik Tempe',
                'isi_pesan' => 'Apakah stok keripik tempe untuk UMKM Desa sebelah masih tersedia banyak?',
                'status' => 'read',
                'tipe' => 'tanya',
                'created_at' => now()->subDays(1),
            ],
            [
                'id_pelanggan' => $user->id,
                'subjek' => 'Saran Tampilan Website',
                'isi_pesan' => 'Webnya sudah bagus Syad, mungkin bisa ditambah fitur dark mode biar lebih keren.',
                'status' => 'replied',
                'tipe' => 'saran',
                'created_at' => now()->subDays(2),
            ],
            [
                'id_pelanggan' => $user->id,
                'subjek' => 'Error 500 saat Checkout',
                'isi_pesan' => 'Tadi saya coba checkout produk UMKM, tapi muncul tulisan Internal Server Error.',
                'status' => 'unread',
                'tipe' => 'error',
                'created_at' => now(),
            ],
        ];

        foreach ($dataPesan as $pesan) {
            Pesan::create($pesan);
        }
    }
}