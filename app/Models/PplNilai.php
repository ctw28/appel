<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PplNilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_kelompok_anggota_id',
        'nilai',
        'sumber_nilai',
    ];

    public function pplKelompokAnggota()
    {
        return $this->hasMany('App\Models\PplKelompokAnggota');
    }
}
