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
        Schema::create('referral_payments', function (Blueprint $table) {
            $table->id();
            // Pemilik referral yang melakukan pencairan dana
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Total nominal uang yang dicairkan
            $table->decimal('amount', 12, 2);

            // Status pencairan (pending, processing, success, rejected)
            $table->string('status')->default('pending');

            // Informasi Rekening Tujuan Pencairan
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_payments');
    }
};
