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
        Schema::create('kerjasama_status', function (Blueprint $table) {
            $table->id();
            
            // Kolom relasi user_id diubah menjadi nullable
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('kerjasama_id'); // Sesuaikan tipe data jika primary key tabel kerjasamas berbeda (misal: uuid)
            $table->enum('status', ['pending', 'aktif', 'selesai', 'dibatalkan'])->default('pending'); // Disesuaikan juga dengan enum jika diperlukan
            $table->text('keterangan')->nullable();
            
            $table->timestamps();

            // Jika tabel kerjasamas sudah ada, Anda bisa aktifkan foreign key di bawah ini:
            // $table->foreign('kerjasama_id')->references('id')->on('kerjasamas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerjasama_status');
    }
};