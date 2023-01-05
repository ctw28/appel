<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembimbingEksternal extends Model
{
    use HasFactory;

    protected $fillable = [
        'lokasi_id',
        'nama',
        'jabatan',
        'keterangan',
    ];

    public function lokasi()
    {
        return $this->belongsTo('App\Models\nLokasi');
    }

    public function kelompok()
    {
        return $this->hasMany('App\Models\KelompokPembimbing');
    }
}
