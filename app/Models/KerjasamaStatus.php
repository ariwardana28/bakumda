<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KerjasamaStatus extends Model
{
    use HasFactory;

    protected $table = 'kerjasama_status';

    protected $fillable = [
        'user_id',
        'kerjasama_id',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}