<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    
    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:tb_produk,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $userId = Auth::id(); // Ambil ID pelanggan yang login

        // Cek dulu, apakah barang yang sama sudah pernah dimasukkan ke keranjang oleh user ini?
        $cekKeranjang = Keranjang::where('user_id', $userId)
                                 ->where('produk_id', $request->produk_id)
                                 ->first();

        if ($cekKeranjang) {
            // Jika sudah ada, jumlahnya tinggal kita akumulasikan (ditambah)
            $cekKeranjang->update([
                'jumlah' => $cekKeranjang->jumlah + $request->jumlah
            ]);
        } else {
            // Jika belum ada, buat record baru di tb_keranjang
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil dimasukkan ke dalam keranjang belanja HOYOHOYO!');
    }
    public function index()
    {
        
        $keranjang = Keranjang::with('produk')
                              ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                              ->get();

        // Hitung total belanjaan sebelum diskon
        $totalBelanja = 0;
        foreach ($keranjang as $item) {
            $totalBelanja += $item->produk->harga * $item->jumlah;
        }

        // Hitung nominal diskon jika user adalah VIP
        $diskon = 0;
        
        
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user && $user->is_vip == 1) {
            $diskon = $totalBelanja * 0.30; // Diskon 30%
            $totalBelanja = $totalBelanja - $diskon; // Total akhir setelah dipotong diskon
        }

        return view('keranjang.index', compact('keranjang', 'totalBelanja', 'diskon'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'jumlah' => 'required|integer|min:1'
    ]);

    $item = Keranjang::where('user_id', auth()->id())->findOrFail($id);
    $item->update([
        'jumlah' => $request->jumlah
    ]);

    return redirect()->back()->with('success', 'Jumlah barang berhasil diperbarui!');
}

    public function destroy($id)
{
    
    $item = Keranjang::where('user_id', auth()->id())->findOrFail($id);
    $item->delete();

    
    return redirect()->route('keranjang.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
}

}