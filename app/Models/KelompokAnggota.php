<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokAnggota extends Model
{
    use HasFactory;

    protected $table = 'kuliah_lapangan_kelompok_anggotas';

    protected $fillable = [
        'kelompok_id',
        'pendaftar_id',
        'jabatan_id',
    ];

    public function kelompok()
    {
        return $this->belongsTo('App\Models\Kelompok');
    }

    public function pendaftar()
    {
        return $this->belongsTo('App\Models\KuliahLapanganPendaftar', 'pendaftar_id');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Models\KuliahLapanganJabatan');
    }

    public function lkh()
    {
        return $this->hasMany('App\Models\Lkh');
    }

    public function nilai()
    {
        return $this->hasOne('App\Models\Nilai');
    }

    public function laporan()
    {
        return $this->hasMany('App\Models\Laporan');
    }
}
