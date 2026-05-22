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
    Schema::table('tb_transaksi', function (Blueprint $table) {
        // Kita gunakan text agar pelanggan bisa menulis pesan yang agak panjang
        $table->text('pesan')->nullable()->after('total_harga');
    });
}

    public function down(): void
{
    Schema::table('tb_transaksi', function (Blueprint $table) {
        $table->dropColumn('pesan');
    });
}
};
