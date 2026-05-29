<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Models\Produk;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



Route::get('/', function (Request $request) {
    $semuaKategori = Produk::pluck('kategori')->unique()->filter();
    $query = Produk::query();

    if ($request->has('kategori') && $request->kategori != '') {
        $query->where('kategori', $request->kategori);
    }

    if ($request->has('cari') && $request->cari != '') {
        $query->where('nama', 'like', '%' . $request->cari . '%');
    }

    $produk = $query->latest()->get();

    return view('home', compact('produk', 'semuaKategori'));
})->name('home');

// Route detail produkkkk
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');



Route::middleware('auth')->group(function () {
    
    // Dashboard standar bawaan Breeze
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Manajemen Akun / Profile Pelanggan & Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/riwayat-transaksi', [TransaksiController::class, 'history'])->name('transaksi.history');

    // Fitur Transaksi Belanja
    Route::post('/checkout', [TransaksiController::class, 'store']);
    Route::get('/pesanan-saya', [TransaksiController::class, 'history']);
});


//PELNGGANN
Route::middleware(['auth'])->group(function () {
    //keranjanggg
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::put('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    // Fitur Transaksi Belanja
    Route::post('/checkout', [TransaksiController::class, 'store'])->name('checkout.store');
    Route::get('/transaksi/invoice/{id}', [TransaksiController::class, 'show'])->name('transaksi.invoice');
    Route::get('/pesanan-saya', [TransaksiController::class, 'history'])->name('transaksi.history');

    // Fitur Customer Service Sisi Pelanggan
Route::get('/layanan-pelanggan', [App\Http\Controllers\PelangganPesanController::class, 'index'])->name('cs.index');
Route::post('/layanan-pelanggan/kirim', [App\Http\Controllers\PelangganPesanController::class, 'store'])->name('cs.store');
Route::get('/layanan-pelanggan/{id}', [App\Http\Controllers\PelangganPesanController::class, 'show'])->name('cs.show');

    //ulasannn
    Route::post('/ulasan/store', [App\Http\Controllers\UlasanController::class, 'storePelanggan'])->name('ulasan.storePelanggan');

});


//adminn
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // produkkk
    Route::get('/admin/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/admin/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/admin/produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/admin/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // pelanggann
    Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
    Route::put('/admin/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/admin/user/hapus/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('/admin/user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');

    // bagiann transaksii di admn
    Route::get('/admin/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/admin/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('/admin/transaksi/{id}/konfirmasi', [TransaksiController::class, 'konfirmasiTransaksi'])->name('transaksi.konfirmasi');
    Route::delete('/admin/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    // chattttt adminn
    Route::get('/admin/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::get('/admin/pesan/{id}', [PesanController::class, 'show'])->name('pesan.show');
    Route::delete('/admin/pesan/{id}', [PesanController::class, 'destroy'])->name('pesan.destroy');
    Route::post('/admin/pesan/{id}/balas', [PesanController::class, 'balasPesan'])->name('pesan.balas');

    // rating atau ulasann para pelanggan
    Route::get('/admin/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
    Route::get('/admin/ulasan/filter/{rating}', [UlasanController::class, 'filter'])->name('ulasan.filter');
});

// Sistem Autentikasi bawaan Breeze (Login, Register, Logout, dll)
require __DIR__.'/auth.php';