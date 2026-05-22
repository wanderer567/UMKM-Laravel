<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('tb_detail', function (Blueprint $table) {
        $table->id('id_detail');
        $table->foreignId('id_transaksi')->constrained('tb_transaksi', 'id_transaksi');
        $table->foreignId('id_produk')->constrained('tb_produk');
        $table->integer('jumlah');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
