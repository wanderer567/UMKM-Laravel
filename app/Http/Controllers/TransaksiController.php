<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('pelanggan')->orderBy('tanggal', 'desc')->get();
        
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'detail.produk'])->findOrFail($id);
        
        if (Auth::user()->role !== 'admin' && $transaksi->id_pelanggan !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        
        if (Auth::user()->role !== 'admin') {
            return view('transaksi.invoice', compact('transaksi'));
        }

       
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete(); 
        return redirect()->route('transaksi.index')->with('success', 'Riwayat transaksi berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();

       
        $request->validate([
            'data_tujuan' => 'required|string|max:255',
            'metode_pembayaran' => 'required|string|in:qris,dana',
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            $itemsToBuy = [];

            // JALUR 1: JIKA CHECKOUT MASSAL DARI HALAMAN KERANJANG
            if ($request->sumber === 'keranjang') {
                $keranjangItems = Keranjang::with('produk')->where('user_id', $userId)->get();
                
                if ($keranjangItems->isEmpty()) {
                    return redirect()->back()->with('error', 'Keranjang belanja Anda masih kosong.');
                }

                foreach ($keranjangItems as $item) {
                    $subtotal = $item->produk->harga * $item->jumlah;
                    $totalHarga += $subtotal;
                    $itemsToBuy[] = [
                        'produk_id' => $item->produk_id,
                        'jumlah' => $item->jumlah,
                        'harga_satuan' => $item->produk->harga,
                        'subtotal' => $subtotal
                    ];
                }

                
                Keranjang::where('user_id', $userId)->delete();

            
            } else {
                $request->validate([
                    'produk_id' => 'required|exists:tb_produk,id',
                    'jumlah' => 'required|integer|min:1'
                ]);

                $produk = Produk::findOrFail($request->produk_id);
                $subtotal = $produk->harga * $request->jumlah;
                $totalHarga = $subtotal;

                $itemsToBuy[] = [
                    'produk_id' => $produk->id,
                    'jumlah' => $request->jumlah,
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $subtotal
                ];
            }

            // --- LOGIKA DISKON VIP (30%) SEBELUM INPUT DATABASE ---
            if ($user && $user->is_vip == 1) {
                $diskon = $totalHarga * 0.30;
                $totalHarga = $totalHarga - $diskon;
            }

            // 1. Masukkan data ke induk tabel: tb_transaksi (Dengan Tambahan Kolom Baru)
            $transaksi = Transaksi::create([
                'id_pelanggan' => $userId,
                'tanggal' => now()->toDateString(),
                'total_harga' => $totalHarga,
                'pesan' => $request->pesan ?? null,
                'metode_pembayaran' => $request->metode_pembayaran,
                'metode_pengiriman' => 'Online (Digital)',
                'data_tujuan' => $request->data_tujuan
            ]);

            // 2. Masukkan rincian barang ke anak tabel: tb_detail_transaksi
            foreach ($itemsToBuy as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            DB::commit();

            $pelanggan = \App\Models\User::find($userId);
            if ($pelanggan) {
                $pelanggan->cekStatusVip();
            }

            // Pesan sukses kustom berdasarkan metode pembayaran yang mereka pilih
            $pesanSukses = $request->metode_pembayaran === 'dana' 
                ? 'Transaksi berhasil dibuat! Silakan transfer manual ke DANA.' 
                : 'Transaksi berhasil dibuat! Silakan lakukan pembayaran via QRIS.';

            return redirect()->route('transaksi.invoice', $transaksi->id_transaksi)
                             ->with('success', $pesanSukses);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }

    public function history()
    {
        $transaksi = Transaksi::with('detail.produk')
            ->where('id_pelanggan', Auth::id())
            ->latest()
            ->get();

        return view('profile.history', compact('transaksi'));
    }
}