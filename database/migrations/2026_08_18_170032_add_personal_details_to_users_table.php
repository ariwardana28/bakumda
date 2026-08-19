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
        Schema::table('users', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('remember_token');
            $table->string('provinsi')->nullable()->after('alamat');
            $table->string('kota')->nullable()->after('provinsi');
            $table->string('kecamatan')->nullable()->after('kota');
            $table->string('kelurahan')->nullable()->after('kecamatan');
            $table->string('no_hp', 20)->nullable()->after('kelurahan');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('no_hp');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('agama', 50)->nullable()->after('tanggal_lahir');
            $table->string('status_perkawinan', 50)->nullable()->after('agama');
            $table->string('pekerjaan', 100)->nullable()->after('status_perkawinan');
            $table->string('kewarganegaraan', 50)->nullable()->after('pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'alamat',
                'provinsi',
                'kota',
                'kecamatan',
                'kelurahan',
                'no_hp',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'agama',
                'status_perkawinan',
                'pekerjaan',
                'kewarganegaraan',
            ]);
        });
    }
};
