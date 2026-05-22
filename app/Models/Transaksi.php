<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id_transaksi';
    
    protected $fillable = ['id_pelanggan', 'tanggal', 'total_harga', 'pesan', 'metode_pembayaran', 'metode_pengiriman', 'data_tujuan'];

    
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }

    // Relasi ke detail item yang dibeli
    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
}