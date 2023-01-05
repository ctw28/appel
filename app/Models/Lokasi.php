<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'kuliah_lapangan_lokasis';

    protected $fillable = [
        'kuliah_lapangan_id',
        'lokasi',
        'alamat',
        'keterangan',
    ];

    public function kuliahLapangan()
    {
        return $this->belongsTo('App\Models\KuliahLapangan');
    }

    public function kelompok()
    {
        return $this->hasMany('App\Models\Kelompok', 'lokasi_id');
    }

    public function pembimbingEksternal()
    {
        return $this->hasMany('App\Models\PembimbingEksternal');
    }

    public function anggota()
    {
        return $this->hasManyThrough('App\Models\Kelompok', 'App\Models\KelompokAnggota', 'lokasi_id', 'kelompok_id', 'id');
    }
}
