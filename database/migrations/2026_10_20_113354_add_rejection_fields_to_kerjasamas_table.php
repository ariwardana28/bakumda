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
        Schema::table('kerjasamas', function (Blueprint $table) {
            // Tambahkan kolom user_id (relasi ke tabel users)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Kolom keterangan
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kerjasamas', function (Blueprint $table) {
            // Hapus foreign key dan kolom jika rollback
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'keterangan']);
        });
    }
};