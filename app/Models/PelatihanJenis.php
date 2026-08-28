<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanJenis extends Model
{
    protected $table = 'pelatihan_jenis';

    protected $fillable = [
        'nama'
    ];

    public function pelatihans()
    {
        return $this->hasMany(Pelatihan::class, 'pelatihan_jenis_id');
    }
}
