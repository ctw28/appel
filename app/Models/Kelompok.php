<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'kuliah_lapangan_kelompoks';
    protected $fillable = [
        'lokasi_id',
        'pembimbing_id',
        'pembimbing_eks_id',
        'nama_kelompok',
        'pembimbing_eksternal',
        'keterangan',
    ];

    public function lokasi()
    {
        return $this->belongsTo('App\Models\Lokasi', 'lokasi_id');
    }

    public function pembimbing()
    {
        return $this->belongsTo('App\Models\Pembimbing');
    }
    public function pembimbingEksternal()
    {
        return $this->belongsTo('App\Models\PembimbingEksternal');
    }
    public function anggota()
    {
        return $this->hasMany('App\Models\KelompokAnggota');
    }
}
