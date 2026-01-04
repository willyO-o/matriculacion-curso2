<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    //

    protected $table = 'estudiante';

    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'ci',
        'foto',
        'fecha_nacimiento',
        'estado',
    ];

    protected $dates = [
        'fecha_nacimiento',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'fecha_nacimiento' => 'date',
    ];




}
