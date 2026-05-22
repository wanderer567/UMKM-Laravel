<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balasan extends Model
{
    // Nama tabel sesuai yang kita buat di migration tadi
    protected $table = 'tb_balasan';

    protected $fillable = [
        'id_pesan',
        'pesan_balasan',
        'pengirim'
    ];

    // Relasi balik ke Pesan (Optional tapi bagus untuk dimiliki)
    public function pesan()
    {
        return $this->belongsTo(Pesan::class, 'id_pesan');
    }
}