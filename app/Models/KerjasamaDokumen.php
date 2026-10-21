<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KerjasamaDokumen extends Model
{
    protected $table = 'kerjasama_dokumen';

    protected $fillable = [
        'kerjasama_id',
        'dokumen',
    ];

    public function kerjasama()
    {
        return $this->belongsTo(Kerjasama::class, 'kerjasama_id');
    }
}
