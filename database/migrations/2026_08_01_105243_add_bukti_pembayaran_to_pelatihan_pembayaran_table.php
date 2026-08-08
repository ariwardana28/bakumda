<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelatihan_pembayaran', function (Blueprint $table) {
            // Tambahkan kolom bukti_pembayaran (nullable agar tidak error untuk data lama)
            if (!Schema::hasColumn('pelatihan_pembayaran', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->after('tanggal_pembayaran');
            }
            
            // Tambahkan kolom catatan jika diperlukan
            if (!Schema::hasColumn('pelatihan_pembayaran', 'catatan')) {
                $table->text('catatan')->nullable()->after('bukti_pembayaran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelatihan_pembayaran', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'catatan']);
        });
    }
};