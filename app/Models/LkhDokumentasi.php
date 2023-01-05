<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkhDokumentasi extends Model
{
    use HasFactory;
    protected $table = "kuliah_lapangan_lkh_fotos";
    protected $fillable = [
        'lkh_id',
        'foto_path'
    ];

    public function lkh()
    {
        return $this->belongsTo('App\Models\Lkh');
    }
}
