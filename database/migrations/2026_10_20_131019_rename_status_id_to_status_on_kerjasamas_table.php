<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Jika kolom masih bernama status_id, ubah dulu menjadi status
        Schema::table('kerjasamas', function (Blueprint $table) {
            if (Schema::hasColumn('kerjasamas', 'status_id') && !Schema::hasColumn('kerjasamas', 'status')) {
                $table->renameColumn('status_id', 'status');
            }
        });

        // 2. Ubah tipe kolom 'status' menjadi VARCHAR secara langsung via SQL agar aman dari error tipe integer
        DB::statement("ALTER TABLE kerjasamas MODIFY COLUMN status VARCHAR(50) NULL DEFAULT 'pending'");

        // 3. Normalisasi data lama: ubah nilai yang tidak valid atau null menjadi 'pending'
        DB::table('kerjasamas')
            ->whereNotIn('status', ['pending', 'aktif', 'selesai', 'dibatalkan'])
            ->orWhereNull('status')
            ->update(['status' => 'pending']);

        // 4. Ubah tipe kolom akhir menjadi ENUM
        Schema::table('kerjasamas', function (Blueprint $table) {
            if (Schema::hasColumn('kerjasamas', 'status')) {
                $table->enum('status', ['pending', 'aktif', 'selesai', 'dibatalkan'])->default('pending')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('kerjasamas', function (Blueprint $table) {
            if (Schema::hasColumn('kerjasamas', 'status')) {
                $table->string('status')->nullable()->change();
            }
        });
    }
};