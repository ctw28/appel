<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PplPembimbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_kelompok_id',
        'pembimbing_internal_id',
        'pembimbing_eksternal_id',
    ];

    public function pplKelompok()
    {
        return $this->belongsTo('App\Models\PplKelompok');
    }
    public function pplPembimbingInternal()
    {
        return $this->belongsTo('App\Models\PplPembimbingInternal', 'pembimbing_internal_id');
    }
}
