<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $table = 'kuliah_lapangan_pembimbings';
    protected $fillable = [
        'kuliah_lapangan_id',
        'pegawai_id',
    ];

    public function kuliahLapangan()
    {
        return $this->belongsTo('App\Models\KuliahLapangan');
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }

    public function bimbingan()
    {
        return $this->hasMany('App\Models\KelompokPembimbing');
    }

    public function kelompok()
    {
        return $this->hasMany('App\Models\Kelompok');
    }
}
