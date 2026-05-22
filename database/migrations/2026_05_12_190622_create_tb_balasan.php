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
    Schema::create('tb_balasan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_pesan')->constrained('tb_pesan', 'id_pesan')->onDelete('cascade');
        $table->text('pesan_balasan');
        $table->enum('pengirim', ['admin', 'sistem'])->default('admin');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_balasan');
    }
};
