<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratMatkul extends Model
{
    use HasFactory;

    protected $fillable = [
        'syarat_prodi_id',
        'kodemk',
        'status',
    ];

    public function syaratProdi()
    {
        return $this->belongsTo('App\Models\SyaratProdi');
    }
}
