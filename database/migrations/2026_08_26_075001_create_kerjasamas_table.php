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
        Schema::create('kerjasamas', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Judul atau nama kerjasama
            $table->string('mitra'); // Nama instansi/perusahaan mitra
            $table->text('deskripsi')->nullable(); // Keterangan atau isi ringkas kerjasama
            $table->date('tanggal_mulai'); // Tanggal mulai berlaku
            $table->date('tanggal_selesai'); // Tanggal berakhir kerjasama
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif'); // Status kerjasama
            $table->string('file_dokumen')->nullable(); // Path/nama file dokumen MOU/MoA (PDF)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerjasamas');
    }
};
