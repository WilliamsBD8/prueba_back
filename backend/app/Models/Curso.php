<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
    ];

    public function members()
    {
        return $this->hasMany('App\Models\Member');
    }

    public function agendas()
    {
        return $this->hasMany('App\Models\Schedule');
    }
}
