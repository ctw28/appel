<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiKategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_kategori_nama',
        'singkatan',
        'sebutan_nomor_pegawai',
        'is_asn',
    ];

    public function pegawai()
    {
        return $this->hasOne('App\Models\UserPegawai');
    }
}
