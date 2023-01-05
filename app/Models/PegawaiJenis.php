<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiJenis extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_jenis_nama',
        'singkatan',
        'alias',
        'is_dosen',
        'if_asn',
    ];

    public function pegawai()
    {
        return $this->hasOne('App\Models\UserPegawai');
    }
}
