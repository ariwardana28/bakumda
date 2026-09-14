<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelatihan_pembayaran', function (Blueprint $table) {
            $table->string('xendit_invoice_id')->nullable()->unique()->after('status_pembayaran');
            $table->text('xendit_invoice_url')->nullable()->after('xendit_invoice_id');
        });
    }

    public function down(): void
    {
        Schema::table('pelatihan_pembayaran', function (Blueprint $table) {
            $table->dropUnique(['xendit_invoice_id']);
            $table->dropColumn(['xendit_invoice_id', 'xendit_invoice_url']);
        });
    }
};