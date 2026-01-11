<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Matriculacion;
use App\Models\Curso;

// importar la clase para transacciones
use Illuminate\Support\Facades\DB;


class MatriculacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $estudiantes  = $request->input('estudiantes');

        $idCurso = $request->input('id_curso');

        $curso = Curso::findOrFail($idCurso);


        try {

            DB::beginTransaction();

            foreach ($estudiantes as $idEstudiante) {

                $nroMatricula =  Matriculacion::generarNroMatricula();

                $curso->estudiantes()->attach(
                    $idEstudiante,
                    [
                        'nro_matricula' => $nroMatricula,
                        'estado_matriculacion' => 'PENDIENTE',
                        'fecha_matriculacion' => now(),

                    ]

                );
            }


            DB::commit();

            return response()->json([
                'mensaje' => 'Estudiantes matriculados correctamente',
            ], 201);
        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'mensaje' => 'Error al matricular los estudiantes',
            ], 500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function formAgregarEstudiante(string $idCurso)
    {

        $curso = Curso::findOrFail($idCurso);

        return view('matriculacion.formulario', compact('curso'));
    }
}
