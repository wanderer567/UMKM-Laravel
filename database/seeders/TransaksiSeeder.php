<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pelanggan yang sudah kita buat tadi
        $budi = User::where('username', 'budi_user')->first();
        $siti = User::where('username', 'siti_vip')->first();

        if ($budi) {
            // Skenario Budi: Transaksi besar (Instan VIP)
            Transaksi::create([
        'id_pelanggan' => $budi->id,
        'tanggal' => Carbon::now(),
        'total_harga' => 260000,
        'pesan' => 'Tolong dicek kembali barangnya sebelum dikirim, terima kasih!'
]);

            // Cek Logika VIP Instan
            if (260000 >= 250000) {
                $budi->update(['is_vip' => 1]);
            }
        }

        if ($siti) {
            // Skenario Siti: Sudah 5 kali transaksi (Akumulasi VIP)
            for ($i = 1; $i <= 5; $i++) {
                Transaksi::create([
                    'id_pelanggan' => $siti->id,
                    'tanggal' => Carbon::now()->subDays($i),
                    'total_harga' => 60000, // Di atas 50rb
                ]);
            }

            // Hitung jumlah transaksi siti yang di atas 50rb
            $jumlahTrx = Transaksi::where('id_pelanggan', $siti->id)
                                  ->where('total_harga', '>=', 50000)
                                  ->count();

            if ($jumlahTrx >= 5) {
                $siti->update(['is_vip' => 1]);
            }
        }
    }
}