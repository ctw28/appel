<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratProdi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppl_id',
        'prodi_id',
        'sks',
    ];

    public function ppl()
    {
        return $this->belongsTo('App\Models\Ppl');
    }
    public function syaratMataKuliah()
    {
        return $this->hasMany('App\Models\SyaratMatkul');
    }
}
