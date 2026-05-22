<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    // Deklarasi nama tabel sesuai migration
    protected $table = 'tb_detail_transaksi';
    
    // Deklarasi primary key karena kita tidak pakai nama 'id' standar
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_transaksi',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

   
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function produk()
    {
       
        return $this->belongsTo(Produk::class, 'produk_id', 'id'); 
    }
}