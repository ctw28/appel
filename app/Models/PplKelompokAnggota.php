<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PplKelompokAnggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_kelompok_id',
        'ppl_pendaftar_id',
        'kelompok_jabatan_id',
    ];

    public function pplKelompok()
    {
        return $this->belongsTo('App\Models\PplKelompok');
    }

    public function pplPendaftar()
    {
        return $this->belongsTo('App\Models\PplPendaftar');
    }

    public function kelompokJabatan()
    {
        return $this->belongsTo('App\Models\KelompokJabatan');
    }

    public function pplLkh()
    {
        return $this->hasMany('App\Models\PplLkh');
    }

    public function pplNilai()
    {
        return $this->hasOne('App\Models\PplNilai');
    }
}
