<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->boolean('tampilkan_di_banner')->default(true)->after('gambar');
        });
    }

    public function down(): void
    {
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->dropColumn('tampilkan_di_banner');
        });
    }
};