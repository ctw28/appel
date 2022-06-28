<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PplPendaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_id',
        'iddata',
    ];

    public function ppl()
    {
        return $this->belongsTo('App\Models\Ppl');
    }

    public function pplKelompokAnggota()
    {
        return $this->hasMany('App\Models\PplKelompokAnggota');
    }
}
