<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matriculacion extends Model
{

    protected $table = 'matriculacion';






    static function generarNroMatricula()
    {
        $ultimoRegistro = self::latest('id')->first();
        $nroMatricula = '';

        if (!$ultimoRegistro) {
            $nroMatricula = '1000001';
            return $nroMatricula;
        }

        $nroMatricula = intval($ultimoRegistro->nro_matricula) + 1;

        return $nroMatricula;

    }

    public function estudiante()
    {
        return $this->hasOne(
            Estudiante::class,
            'id',
            'id_estudiante'
        );
    }
    public function curso()
    {
        return $this->hasOne(
            Curso::class,
            'id',
            'id_curso'
        );
    }

}
