<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PplLokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_id',
        'lokasi',
        'alamat',
        'keterangan'
    ];

    public function ppl()
    {
        return $this->belongsTo('App\Models\Ppl');
    }

    public function pplKelompok()
    {
        return $this->hasMany('App\Models\PplKelompok');
    }

    // public function pplPembimbingInternal()
    // {
    //     return $this->hasMany('App\Models\PplPembimbingInternal');
    // }
}
