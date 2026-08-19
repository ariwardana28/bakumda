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
        Schema::table('referral_transactions', function (Blueprint $table) {
            $table->foreignId('pelatihan_id')->nullable()->after('referred_id')->constrained('pelatihan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referral_transactions', function (Blueprint $table) {
            $table->dropForeign(['pelatihan_id']);
            $table->dropColumn('pelatihan_id');
        });
    }
};