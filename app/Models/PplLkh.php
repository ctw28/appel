<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PplLkh extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_kelompok_anggota_id',
        'tgl_lkh',
        'kegiatan',
        'foto_path',
    ];

    public function pplKelompokAnggota()
    {
        return $this->belongsTo('App\Models\PplKelompokAnggota');
    }
}
