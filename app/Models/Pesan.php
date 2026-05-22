<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Balasan;

class Pesan extends Model
{
    protected $table = 'tb_pesan';
    protected $primaryKey = 'id_pesan';
    protected $fillable = ['id_pelanggan', 'subjek', 'isi_pesan', 'status', 'tipe'];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }

    public function balasan() {
    return $this->hasMany(Balasan::class, 'id_pesan');
}
}
