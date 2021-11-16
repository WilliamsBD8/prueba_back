<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'aforo',
    ];

    public function agendas()
    {
        return $this->hasMany('App\Models\Schedule');
    }
}
