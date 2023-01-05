<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppl extends Model
{
    use HasFactory;
    protected $fillable = [
        'kuliah_lapangan_id',
        'master_fakultas_id',

    ];

    public function kuliahLapangan()
    {
        return $this->belongsTo('App\Models\KuliahLapangan');
    }

    public function fakultasData()
    {
        return $this->belongsTo('App\Models\MasterFakultas');
    }
}
