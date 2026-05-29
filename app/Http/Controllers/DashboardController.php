<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Models\Transaksi; 
use App\Models\User;
use App\Models\Produk;

class DashboardController extends Controller
{
   public function index()
{
    // 1. Mengambil total semua transaksi
    $totalTransaksi = Transaksi::count();
    
    // 2. Menghitung total pendapatan (sementara hitung total semua karena belum ada kolom status)
    $totalPendapatan = Transaksi::sum('total_harga');
    
    // 3. Menghitung order berhasil (disamakan dengan total transaksi dulu)
    $orderBerhasil = Transaksi::count();
    
    // 4. Order pending di-default ke 0 dulu agar tidak error
    $orderPending = 0;
    
    // 5. Mengambil jumlah pelanggan
    $userAktif = User::where('role', 'pelanggan')->count();
    
    // 6. Mengisi Data Grafik Mingguan secara otomatis berdasarkan hari (Senin - Minggu)
    $dataMingguan = [];
    for ($i = 0; $i < 7; $i++) {
        // WEEKDAY() di MySQL: 0 = Senin, 1 = Selasa, ..., 6 = Minggu
        $dataMingguan[] = Transaksi::whereRaw("WEEKDAY(tanggal) = ?", [$i])->count();
    }
    
    // 7. Ambil 5 aktivitas transaksi terbaru
    // Kita manipulasi datanya agar sesuai dengan variabel $log->keterangan di Blade kamu
    $transaksiTerakhir = Transaksi::with('pelanggan')->latest()->take(5)->get();
    
    $aktivitasTerakhir = $transaksiTerakhir->map(function($item) {
        return (object) [
            'keterangan' => 'Pelanggan ' . ($item->pelanggan->name ?? 'Umum') . ' melakukan checkout sebesar Rp ' . number_format($item->total_harga, 0, ',', '.'),
            'created_at' => $item->created_at
        ];
    });

    // 8. Mengambil produk terlaris via Query Builder ke tb_detail_transaksi agar lebih aman dari salah nama relasi model
    $produkTerlarisRaw = \DB::table('tb_detail_transaksi')
        ->join('tb_produk', 'tb_detail_transaksi.produk_id', '=', 'tb_produk.id')
        ->select('tb_produk.nama', \DB::raw('SUM(tb_detail_transaksi.jumlah) as total_terjual'))
        ->groupBy('tb_produk.nama')
        ->orderBy('total_terjual', 'desc')
        ->first();

    // Bungkus ke object biar aman dibaca oleh Blade ($produkTerlaris->nama)
    $produkTerlaris = (object) [
        'nama' => $produkTerlarisRaw ? $produkTerlarisRaw->nama : '-'
    ];

    return view('admin.dashboard', compact(
        'totalTransaksi', 
        'totalPendapatan', 
        'orderBerhasil', 
        'orderPending', 
        'userAktif', 
        'produkTerlaris',
        'dataMingguan',
        'aktivitasTerakhir'
    ));
}

        // Tambahkan fungsi ini di dalam DashboardController.php
        public function konfirmasiTransaksi($id)
        {
            // Cari data transaksi berdasarkan ID
            $transaksi = Transaksi::findOrFail($id);
            
            // Ubah statusnya menjadi berhasil (atau 'sukses' sesuai string di migration-mu)
            $transaksi->status = 'sukses';
            $transaksi->save();

            // Kembalikan ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('success', 'Transaksi #' . $transaksi->id_transaksi . ' berhasil dikonfirmasi!');
        }
}
