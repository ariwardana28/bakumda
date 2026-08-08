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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // ID pengguna yang menerima notifikasi (bisa disesuaikan dengan nama foreign key users Anda)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Judul dan isi pesan notifikasi
            $table->string('title');
            $table->text('message');
            
            // Kategori notifikasi (contoh: 'maintenance', 'pelatihan', 'anggota', 'sistem')
            $table->string('type')->default('info');
            
            // Menyimpan nama route Laravel atau URL tujuan saat notifikasi diklik
            $table->string('route')->nullable();
            
            // Parameter tambahan untuk route jika diperlukan (dalam bentuk JSON)
            $table->json('route_params')->nullable();
            
            // Status dibaca atau belum
            $table->timestamp('read_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
