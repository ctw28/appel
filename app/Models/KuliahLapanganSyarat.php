<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuliahLapanganSyarat extends Model
{
    protected $fillable = [
        'kuliah_lapangan_id',
        'master_prodi_id',
        'sks',
        'tahun_penawaran',
    ];

    public function kuliahlapangan()
    {
        return $this->belongsTo('App\Models\Kuliahlapangan');
    }
    public function prodi()
    {
        return $this->belongsTo('App\Models\MasterProdi');
    }

    public function syaratMataKuliah()
    {
        return $this->hasMany('App\Models\KuliahLapanganSyaratMk');
    }
}
