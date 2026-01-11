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
        'fecha_nacimiento' => 'date',
    ];


    static $rules = [
        'nombre' => 'required|string|max:150',
        'paterno'=> 'nullable|required_if:materno,null|string|max:150',
        'materno' => 'nullable|required_if:paterno,null|string|max:150',
        'ci' => 'required|regex:/^\d{6,15}(-[A-Za-z0-9]*)?$/|unique:estudiante,ci',
        'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'fecha_nacimiento' => 'required|date',
        'estado' => 'required|in:ACTIVO,INACTIVO',

    ];


    public function cursos()
    {
        return $this->belongsToMany(
            Curso::class,
            'matriculacion',
            'id_estudiante',
            'id_curso'
        )
        ->withPivot('nro_matricula', 'estado_matriculacion', 'fecha_matriculacion');
    }




}
