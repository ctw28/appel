<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFakultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'master_jenjang_id',
        'fakultas_nama',
        'fakultas_singkatan',
        'is_fakultas',
        'fakultas_visi',
        'fakultas_misi',
        'fakultas_keterangan',
    ];
    public function masterJenjang()
    {
        return $this->belongsTo('App\Models\MasterJenjang');
    }

    public function adminFakultas()
    {
        return $this->hasMany('App\Models\AdminFakultas');
    }

    public function prodi()
    {
        return $this->hasMany('App\Models\MasterProdi');
    }

    public function ppl()
    {
        return $this->hasMany('App\Models\Ppl', 'master_fakultas_id');
    }
}
