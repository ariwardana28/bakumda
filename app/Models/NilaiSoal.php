<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiSoal extends Model
{
    protected $table = 'nilai_soal';

    protected $fillable = [
        'nilai_id',
        'soal_id',
        'jawaban_id',
        'nilai',
    ];

    public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'nilai_id');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id');
    }

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class, 'jawaban_id');
    }
}
