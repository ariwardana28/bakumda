<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalJawaban extends Model
{
    protected $table = 'soal_jawaban';

    protected $fillable = [
        'soal_id',
        'jawaban_id',
    ];

    // Tambahkan relasi ini
    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class, 'jawaban_id', 'id');
    }
}