<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'kuliah_lapangan_nilais';
    protected $fillable = [
        'kelompok_anggota_id',
        'nilai_pembimbing',
        'nilai_eksternal'
    ];

    public function anggota()
    {
        return $this->belongsTo('App\Models\KelompokAnggota');
    }
}
