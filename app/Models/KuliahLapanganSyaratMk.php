<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuliahLapanganSyaratMk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kuliah_lapangan_syarat_id',
        'kode_mk',
        'is_ditawar',
    ];

    public function kuliahlapanganSyarat()
    {
        return $this->belongsTo('App\Models\KuliahlapanganSyarat');
    }
}
