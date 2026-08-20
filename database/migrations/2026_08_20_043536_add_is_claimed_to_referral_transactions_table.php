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
            $table->boolean('is_claimed')->default(0)->after('status'); // sesuaikan posisi kolom jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('referral_transactions', function (Blueprint $table) {
            $table->dropColumn('is_claimed');
        });
    }
};
