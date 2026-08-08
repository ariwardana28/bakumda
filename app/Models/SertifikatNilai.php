<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SertifikatNilai extends Model
{
    protected $table = 'sertifikat_nilai';

    protected $fillable = [
        'sertifikat_id',
        'nilai_id',
    ];

    public function sertifikat()
    {
        return $this->belongsTo(Sertifikat::class, 'sertifikat_id');
    }

    public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'nilai_id');
    }
}
