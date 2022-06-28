<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppl extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun_ajar_id',
        'ppl_nama',
        'ppl_waktu_daftar_mulai',
        'ppl_waktu_daftar_selesai',
        'ppl_waktu_publikasi',
        'ppl_waktu_pelaksanaan_mulai',
        'ppl_waktu_pelaksanaan_selesai',
        'ppl_waktu_tugas_mulai',
        'ppl_waktu_tugas_selesai',
        'ppl_waktu_penilaian_mulai',
        'ppl_waktu_penilaian_selesai',
        'keterangan',
    ];

    public function tahunAjar()
    {
        return $this->belongsTo('App\Models\MasterTahunAjar', 'tahun_ajar_id');
    }
    public function pplLokasi()
    {
        return $this->hasMany('App\Models\PplLokasi');
    }

    public function pplPembimbingInternal()
    {
        return $this->hasMany('App\Models\PplPembimbingInternal');
    }

    public function pplPendaftar()
    {
        return $this->hasMany('App\Models\PplPendaftar');
    }
    public function syaratProdi()
    {
        return $this->hasMany('App\Models\SyaratProdi');
    }
}
