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
        Schema::create('pelatihan_pembayaran', function (Blueprint $table) {
            $table->id();
            // Mengubah ke pelatihan_id dan merujuk ke tabel pelatihan
            $table->foreignId('pelatihan_id')->constrained('pelatihan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('jumlah_pembayaran', 15, 2);
            $table->string('status_pembayaran'); // misal: 'pending', 'success', 'failed'
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_pembayaran');
    }
};
