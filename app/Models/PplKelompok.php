<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PplKelompok extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_lokasi_id',
        'nama_kelompok',
        'keterangan',
    ];

    public function pplLokasi()
    {
        return $this->belongsTo('App\Models\PplLokasi');
    }

    public function pplPembimbing()
    {
        return $this->hasOne('App\Models\PplPembimbing');
    }

    public function pplKelompokAnggota(){
        return $this->hasMany('App\Models\PplKelompokAnggota');
    }
}
