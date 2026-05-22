<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->string('metode_pembayaran')->default('qris')->after('total_harga');
            $table->string('metode_pengiriman')->default('digital')->after('metode_pembayaran');
            $table->string('data_tujuan')->nullable()->after('metode_pengiriman'); // Menyimpan ID Game / No HP tujuan
        });
    }

    public function down(): void
    {
        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'metode_pengiriman', 'data_tujuan']);
        });
    }
};