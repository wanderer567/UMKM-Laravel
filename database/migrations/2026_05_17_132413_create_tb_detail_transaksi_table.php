<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail');
            // Menghubungkan ke id_transaksi di tb_transaksi
            $table->foreignId('id_transaksi')->constrained('tb_transaksi', 'id_transaksi')->onDelete('cascade');
            // Menghubungkan ke tb_produk
            $table->foreignId('produk_id')->constrained('tb_produk')->onDelete('cascade');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_detail_transaksi');
    }
};