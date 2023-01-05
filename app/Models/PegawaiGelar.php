<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiGelar extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'gelar_depan',
        'gelar_belakang',
        'gelar_tanggal',
        'is_aktif',
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
