<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerjasama extends Model
{
    use HasFactory;

    protected $table = 'kerjasamas';

    protected $fillable = [
        'judul',
        'mitra',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'file_dokumen',
    ];
}