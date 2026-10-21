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
            $table->renameColumn('keterangan', 'biaya_pelatihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('kerjasamas', function (Blueprint $table) {
            $table->renameColumn('biaya_pelatihan', 'keterangan');
        });
    }
};
