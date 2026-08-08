<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';

    protected $fillable = [
        'materi_id',
        'soal',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function jawaban()
    {
        return $this->belongsToMany(Jawaban::class, 'soal_jawaban', 'soal_id', 'jawaban_id')
                    ->withPivot('id'); // PENTING: Beritahu Laravel bahwa tabel pivot punya kolom id
    }
}
