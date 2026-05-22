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
    Schema::create('tb_users', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('email');
        $table->string('username')->nullable();
        $table->string('password');
        $table->string('hp');
        $table->string('alamat');
        $table->enum('role', ['admin', 'pelanggan']);
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
