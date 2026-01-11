<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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


    public function estudiantes()
    {
        return $this->belongsToMany(
            Estudiante::class,
            'matriculacion',
            'id_curso',
            'id_estudiante'
        )
        ->withPivot('nro_matricula', 'estado_matriculacion', 'fecha_matriculacion');

    }

    static function boot(){

        parent::boot();

        static::creating(function ($curso){
            $codigo = self::generarCodigoCurso();
            $curso->codigo = $codigo;
        });

    }

    static function generarCodigoCurso(){

        $codigo = 'CUR-'. Str::upper(Str::random(4));

        $existe = Curso::where('codigo', $codigo)->exists();

        if($existe) {
            return self::generarCodigoCurso();
        }

        return $codigo;

    }








}
