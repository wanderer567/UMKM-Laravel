<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    // Menampilkan semua ulasan
    public function index()
    {
        $ulasan = Ulasan::with(['pelanggan', 'produk'])->orderBy('created_at', 'desc')->get();
        return view('admin.ulasan.index', compact('ulasan'));
    }

    // Fitur Cepat: Filter berdasarkan jumlah bintang
    public function filter($rating)
    {
        // Mengambil ulasan yang ratingnya sesuai (misal: 5.0)
        $ulasan = Ulasan::with(['pelanggan', 'produk'])
                        ->where('rating', $rating)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.ulasan.index', compact('ulasan'));
    }

    public function storePelanggan(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:tb_produk,id',
            'rating'    => 'required|numeric|min:1|max:5',
            'komentar'  => 'required|string|min:5',
        ]);

        
        $cekUlasan = \App\Models\Ulasan::where('id_users', \Illuminate\Support\Facades\Auth::id())
                                       ->where('id_produk', $request->id_produk)
                                       ->first();

        if ($cekUlasan) {
            return redirect()->back()->with('error', 'Kamu sudah pernah memberikan ulasan untuk produk ini!');
        }

        
        \App\Models\Ulasan::create([
            'id_users'  => \Illuminate\Support\Facades\Auth::id(),
            'id_produk' => $request->id_produk,
            'rating'    => $request->rating,
            'komentar'  => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan bintang ' . $request->rating . ' kamu berhasil dikirim.');
    }

    // Menghapus ulasan jika ada spam atau kata-kata kasar
    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->delete();

        return redirect()->route('admin.ulasan.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}