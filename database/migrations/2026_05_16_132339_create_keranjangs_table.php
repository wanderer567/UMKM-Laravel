<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('tb_keranjang', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tb_users (sesuaikan nama kolom id-nya)
        $table->foreignId('user_id')->constrained('tb_users')->onDelete('cascade');
        // Menghubungkan ke tb_produk
        $table->foreignId('produk_id')->constrained('tb_produk')->onDelete('cascade');
        // Jumlah item yang dibeli
        $table->integer('jumlah');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('tb_keranjang');
}
};
