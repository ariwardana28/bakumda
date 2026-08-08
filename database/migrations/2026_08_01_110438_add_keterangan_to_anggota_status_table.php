<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelatihan_anggota_status', function (Blueprint $table) {
            if (!Schema::hasColumn('pelatihan_anggota_status', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelatihan_anggota_status', function (Blueprint $table) {
            if (Schema::hasColumn('pelatihan_anggota_status', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};
