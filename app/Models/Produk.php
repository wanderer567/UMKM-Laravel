<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'tb_produk';
    protected $fillable = ['nama', 'harga', 'stok', 'poto', 'kategori', 'deskripsi'];

    public function getHargaDiskonAttribute()
{
    // Jika user login dan dia adalah VIP, berikan diskon 30%
    if (auth()->check() && auth()->user()->is_vip) {
        return $this->harga * 0.7; // Potongan 30%
    }
    return $this->harga;
}
}
