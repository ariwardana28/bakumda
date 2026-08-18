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
        Schema::create('referral_payment_details', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel referral_payments
            $table->foreignId('referral_payment_id')->constrained('referral_payments')->onDelete('cascade');

            // Relasi ke tabel transaksi referral spesifik yang dibayarkan
            $table->foreignId('referral_transaction_id')->constrained('referral_transactions')->onDelete('cascade');

            // Nominal bonus dari transaksi tersebut pada saat dicairkan
            $table->decimal('reward_amount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_payment_details');
    }
};
