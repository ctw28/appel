<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lkh extends Model
{
    use HasFactory;
    protected $table = 'kuliah_lapangan_lkhs';

    protected $fillable = [
        'kelompok_anggota_id',
        'tgl_lkh',
        'kegiatan',
    ];

    public function anggota()
    {
        return $this->belongsTo('App\Models\KelompokAnggota');
    }
    public function dokumentasi()
    {
        return $this->hasMany('App\Models\LkhDokumentasi');
    }

    public function link()
    {
        return $this->hasOne('App\Models\LkhLink');
    }
}
