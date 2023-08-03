<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelompok_anggota_id',
        'kategori',
        'file_path',
    ];

    public function anggota()
    {
        return $this->belongsTo('App\Models\KelompokAnggota');
    }
}
