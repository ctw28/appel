<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuliahLapanganFakultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'master_fakultas_id',
        'sebutan',
        'singkatan',
        'sebutan_eksternal',
    ];

    public function fakultas()
    {
        return $this->belongsTo('App\Models\MasterFakultas', 'master_fakultas_id');
    }
}
