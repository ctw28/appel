<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuliahLapanganPendaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'kuliah_lapangan_id',
        'mahasiswa_id',
        'is_memenuhi',
    ];

    public function kuliahLapangan()
    {
        return $this->belongsTo('App\Models\KuliahLapangan');
    }
    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa');
    }
    public function anggota()
    {
        return $this->hasOne('App\Models\KelompokAnggota', 'pendaftar_id');
    }
}
