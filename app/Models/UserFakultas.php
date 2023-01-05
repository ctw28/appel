<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFakultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'master_fakultas_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function masterFakultas()
    {
        return $this->belongsTo('App\Models\MasterFakultas');
    }

    // public function ppl()
    // {
    //     return $this->hasMany('App\Models\Ppl');
    // }
}
