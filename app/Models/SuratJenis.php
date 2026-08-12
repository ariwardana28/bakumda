<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJenis extends Model
{
    protected $table = 'surat_jenis';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
