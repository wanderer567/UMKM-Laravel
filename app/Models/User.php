<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    protected $table = 'tb_users';

    protected $fillable = [
        'nama',
        'email',
        'username',
        'password',
        'hp',
        'alamat',
        'role',
        'is_vip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    
    public function getNameAttribute()
    {
        return $this->nama;
    }

    public function cekStatusVip()
    {
        // Jika user sudah VIP, tidak perlu dicek lagi
        if ($this->is_vip == 1) {
            return true;
        }

        // Ambil semua transaksi sukses milik user ini beserta detail itemnya
        // Pastikan nama relasi 'transaksi' dan status sukses disesuaikan dengan web kamu
        $transaksiSukses = \App\Models\Transaksi::where('id_pelanggan', $this->id)
            ->where('status', 'sukses') // Sesuaikan jika statusnya 'lunas' atau 'success'
            ->with('detail.produk')
            ->get();

        // --- SYARAT 1: Sekali beli dengan total harga >= 250.000 ---
        foreach ($transaksiSukses as $trx) {
            if ($trx->total_harga >= 250000) {
                $this->update(['is_vip' => 1]);
                return true;
            }
        }

        // --- SYARAT 2: Membeli minimal 5 produk yang harganya di atas 50.000 ---
        $jumlahProdukMahal = 0;
        foreach ($transaksiSukses as $trx) {
            foreach ($trx->detail as $detail) {
                // Cek apakah harga satuan produk tersebut > 50.000
                if (($detail->produk->harga ?? 0) > 50000) {
                    // Akumulasikan berdasarkan kuantitas (jumlah) yang dibeli
                    $jumlahProdukMahal += $detail->jumlah;
                }
            }
        }

        if ($jumlahProdukMahal >= 5) {
            $this->update(['is_vip' => 1]);
            return true;
        }

        return false;
    }
}