<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
{
    
    $semuaKategori = \App\Models\Produk::pluck('kategori')->unique()->filter();

    // 2. Query dasar untuk menampilkan produk
    $query = \App\Models\Produk::query();

    // 3. Filter berdasarkan kategori yang diklik jika ada parameter di URL
    if ($request->has('kategori') && $request->kategori != '') {
        $query->where('kategori', $request->kategori);
    }

    // 4. Filter pencarian kata kunci jika ada
    if ($request->has('cari') && $request->cari != '') {
        $query->where('nama', 'like', '%' . $request->cari . '%');
    }

    $produk = $query->latest()->get();

    // 5. Lempar variabel ke view home
    return view('home', compact('produk', 'semuaKategori'));
}
}
