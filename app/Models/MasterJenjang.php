<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJenjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenjang_nama',
        'jenjang_gelar',
        'jenjang_singkatan',
        'jenjang_kode_dikti',
        'sebutan_tugas_akhir',
    ];

    public function fakultas()
    {
        return $this->hasMany('App\Models\MasterFakultas');
    }
}
