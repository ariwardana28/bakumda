<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelatihan_pembayaran', function (Blueprint $table) {
            // Menambahkan kolom pelatihan_anggota_id setelah user_id
            // Dibuat nullable() agar jika ada data lama, tidak terjadi error
            if (!Schema::hasColumn('pelatihan_pembayaran', 'pelatihan_anggota_id')) {
                $table->unsignedBigInteger('pelatihan_anggota_id')->nullable()->after('user_id');
                
                // (Opsional) Jika Anda ingin menambahkan relasi foreign key
                // $table->foreign('pelatihan_anggota_id')->references('id')->on('pelatihan_anggota')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelatihan_pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pelatihan_pembayaran', 'pelatihan_anggota_id')) {
                // Hapus foreign key dulu jika Anda mengaktifkan kode foreign key di atas
                // $table->dropForeign(['pelatihan_anggota_id']);
                
                $table->dropColumn('pelatihan_anggota_id');
            }
        });
    }
};
