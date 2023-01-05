<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelompok_anggota_id',
        'nilai',
        'sumber_nilai'
    ];

    public function anggota()
    {
        return $this->belongsTo('App\Models\KelompokAnggota');
    }
}
