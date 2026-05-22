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
    Schema::create('tb_ulasan', function (Blueprint $table) {
        $table->id('id_ulasan');
        // id() di tb_users adalah 'id', jadi kita hubungkan ke 'id'
        $table->foreignId('id_users')->constrained('tb_users', 'id')->onDelete('cascade');
        // id() di tb_produk adalah 'id', jadi kita hubungkan ke 'id'
        $table->foreignId('id_produk')->constrained('tb_produk', 'id')->onDelete('cascade');
        $table->float('rating', 2, 1);
        $table->text('komentar');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_ulasan');
    }
};
