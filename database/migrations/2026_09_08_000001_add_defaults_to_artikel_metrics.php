<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->integer('views')->default(0)->change();
            $table->integer('likes')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->integer('views')->default(null)->change();
            $table->integer('likes')->default(null)->change();
        });
    }
};