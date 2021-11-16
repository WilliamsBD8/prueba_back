<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'date',
        'start',
        'end',
        'status',
        'salon_id',
        'curso_id',
    ];

    public function curso(){
        return $this->belongsTo('App\Models\Curso');
    }

    public function salon(){
        return $this->belongsTo('App\Models\Salon');
    }
}
