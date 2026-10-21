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
        Schema::create('kerjasama_dokumen', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel kerjasamas dengan foreign key constraint
            $table->foreignId('kerjasama_id')->constrained('kerjasamas')->onDelete('cascade');
            $table->string('dokumen'); // Kolom untuk menyimpan nama/path file dokumen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerjasama_dokumen');
    }
};
