<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'judul',
        'gambar',
        'tautan',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'aktif' => 'boolean',
    ];
}