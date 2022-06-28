<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PplPembimbingInternal extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_id',
        'idpeg',
    ];

    public function ppl()
    {
        return $this->belongsTo('App\Models\Ppl');
    }

    public function pplPembimbing()
    {
        return $this->hasMany('App\Models\PplPembimbing', 'pembimbing_internal_id');
    }
}
