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
        Schema::create('sertifikat_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sertifikat_id')->constrained('sertifikat')->onDelete('cascade');
            $table->foreignId('nilai_id')->constrained('nilai')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_nilai');
    }
};
