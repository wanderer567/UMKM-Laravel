<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'tb_ulasan';
    protected $primaryKey = 'id_ulasan';
   
    protected $fillable = ['id_users', 'id_produk', 'rating', 'komentar'];

 
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}