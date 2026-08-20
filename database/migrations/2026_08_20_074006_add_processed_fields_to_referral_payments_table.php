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
        Schema::table('referral_payments', function (Blueprint $table) {
            // Menambahkan kolom untuk ID admin yang memproses, terhubung ke tabel users.
            // onDelete('set null') berarti jika admin dihapus, nilai di sini akan menjadi NULL.
            $table->foreignId('processed_by')->nullable()->after('rejection_reason')->constrained('users')->onDelete('set null');
            
            // Menambahkan kolom untuk waktu pemrosesan.
            $table->timestamp('processed_at')->nullable()->after('processed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referral_payments', function (Blueprint $table) {
            // Hapus foreign key constraint sebelum menghapus kolom
            $table->dropForeign(['processed_by']);
            $table->dropColumn(['processed_by', 'processed_at']);
        });
    }
};
