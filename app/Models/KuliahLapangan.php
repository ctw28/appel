<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuliahLapangan extends Model
{
    // use HasFactory;
    protected $fillable = [
        'tahun_akademik_id',
        'created_by',
        'kuliah_lapangan_nama',
        'waktu_daftar_mulai',
        'waktu_daftar_selesai',
        'waktu_publikasi_kelompok',
        'waktu_pelaksanaan_mulai',
        'waktu_pelaksanaan_selesai',
        'waktu_tugas_mulai',
        'waktu_tugas_selesai',
        'waktu_penilaian_mulai',
        'waktu_penilaian_selesai',
        'keterangan',
        'is_daftar_open',
        'is_active',
        'is_ppl',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function tahunAkademik()
    {
        return $this->belongsTo('App\Models\MasterTahunAkademik', 'tahun_akademik_id');
    }


    public function ppl()
    {
        return $this->hasOne('App\Models\Ppl');
    }

    public function lokasi()
    {
        return $this->hasMany('App\Models\Lokasi');
    }

    public function pembimbing()
    {
        return $this->hasMany('App\Models\PplPembimbingInternal');
    }

    public function pendaftar()
    {
        return $this->hasMany('App\Models\KuliahLapanganPendaftar');
    }

    public function syaratProdi()
    {
        return $this->hasMany('App\Models\KuliahLapanganSyarat');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
}
