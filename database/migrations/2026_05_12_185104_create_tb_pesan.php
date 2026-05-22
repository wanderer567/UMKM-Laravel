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
    Schema::create('tb_pesan', function (Blueprint $table) {
        $table->id('id_pesan');
        $table->foreignId('id_pelanggan')->constrained('tb_users'); // Siapa yang mengirim/menerima
        $table->string('subjek'); // Contoh: "Error Pembayaran", "Tanya Produk"
        $table->text('isi_pesan');
        $table->enum('status', ['unread', 'read', 'replied'])->default('unread');
        $table->enum('tipe', ['error', 'tanya', 'saran'])->default('tanya');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pesan');
    }
};
