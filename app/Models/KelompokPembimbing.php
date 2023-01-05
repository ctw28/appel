<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokPembimbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelompok_id',
        'pembimbing_id',
        'pembimbing_eksternal_id',
    ];

    public function kelompok()
    {
        return $this->belongsTo('App\Models\Kelompok');
    }
    public function pembimbing()
    {
        return $this->belongsTo('App\Models\Pembimbing');
    }
    public function pembimbingEksternal()
    {
        return $this->belongsTo('App\Models\PembimbingEksternal');
    }
}
