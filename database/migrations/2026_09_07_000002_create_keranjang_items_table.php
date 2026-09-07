<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keranjang_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keranjang_id')->constrained('keranjangs')->cascadeOnDelete();
            $table->foreignId('produk_id')->constrained('produk')->cascadeOnDelete();
            $table->foreignId('produk_ukuran_id')->nullable()->constrained('produk_ukuran')->nullOnDelete();
            $table->unsignedInteger('jumlah');
            $table->decimal('harga', 12, 2);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['keranjang_id', 'produk_id', 'produk_ukuran_id'], 'keranjang_item_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang_items');
    }
};
