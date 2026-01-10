<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    //
    protected $table = 'curso';

    protected $fillable = [
        'codigo',
        'titulo',
        'descripcion',
        'costo',
        'fecha_inicio',
        'fecha_fin',
        'estado_curso',
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];





}
