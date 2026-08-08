<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawaban';

    protected $fillable = [
        'jawaban',
        'status',
    ];

    public function soal()
    {
        return $this->belongsToMany(Soal::class, 'soal_jawaban', 'jawaban_id', 'soal_id')
                    ->withPivot('id'); // PENTING
    }
}
