<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkhLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'lkh_id',
        'jenis',
        'file_path'
    ];

    public function lkh()
    {
        return $this->belongsTo('App\Models\Lkh');
    }
}
