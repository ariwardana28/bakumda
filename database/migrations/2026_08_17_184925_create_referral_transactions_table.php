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
        Schema::create('referral_transactions', function (Blueprint $table) {
            $table->id();
            // Diubah constrained-nya ke tabel 'referral_codes' (sesuaikan nama tabel master kode referral Anda)
            $table->foreignId('referral_code_id')->constrained('referral_codes')->onDelete('cascade');

            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade');

            // Menggunakan decimal untuk nominal uang (contoh: total 12 digit, 2 digit di belakang koma)
            $table->decimal('reward_amount', 12, 2)->default(0);

            // Menggunakan string atau enum dengan nilai default 'pending'
            $table->string('status')->default('pending'); // pending, ready_to_claim, claimed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_transactions');
    }
};
