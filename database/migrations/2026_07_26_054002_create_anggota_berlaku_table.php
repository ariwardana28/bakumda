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
        Schema::create('anggota_berlaku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_card_id')->constrained('anggota_card')->onDelete('cascade');
            $table->string('diterbitkan')->nullable();
            $table->string('berlaku')->nullable();
            $table->string('status_kartu')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_berlaku');
    }
};
