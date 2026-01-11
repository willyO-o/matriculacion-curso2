<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use DataTables;


class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        if (request()->ajax()) {

            $clasesEstado = [
                'PENDIENTE' => 'badge bg-gradient-warning',
                'EN CURSO' => 'badge bg-gradient-info',
                'FINALIZADO' => 'badge bg-gradient-success',
            ];

            $query = Curso::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('costo', function ($curso) {
                    return $curso->costo . ' Bs.';
                })
                ->editColumn('fecha_inicio', function ($curso) {
                    return $curso->fecha_inicio->format('d/m/Y');
                })
                ->editColumn('fecha_fin', function ($curso) {
                    return $curso->fecha_fin->format('d/m/Y');
                })
                ->editColumn('estado_curso', function ($curso) use ($clasesEstado) {

                    $clase = $clasesEstado[$curso->estado_curso] ?? 'badge bg-gradient-secondary';

                    return '<span class="' . $clase . '">' . $curso->estado_curso . '</span>';
                })
                ->editColumn('id', function ($curso) {

                    return '<button value="' . route('cursos.show', $curso->id) . '" class="btn btn-info btn-sm btn-accion">
                        <i class="fas fa-eye"></i>
                        </button>

                        <button value="' . route('cursos.edit', $curso->id) . '" class="btn btn-warning btn-sm btn-accion">
                        <i class="fas fa-pencil-alt"></i>
                        </button>

                        <button value="' . route('cursos.destroy', $curso->id) . '" class="btn btn-danger btn-sm btn-eliminar">
                        <i class="fas fa-trash"></i>
                        </button>

                        <button value="' . route('matriculaciones.form-agregar-estudiante', $curso->id) . '" class="btn btn-dark btn-sm btn-matricular">
                        <i class="fas fa-user-plus"></i>
                        matricular
                        </button>
                        ';
                })
                ->rawColumns(['estado_curso', 'id'])

                ->make(true);
        }

        return view('curso.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $curso = new Curso();
        return view('curso.formulario', compact('curso'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $curso = Curso::create($request->all());

        if (!$curso) {
            return response()->json([
                'mensaje' => 'Error al registrar el estudiante'
            ], 500);
        }

        return response()->json([
            'mensaje' => 'Curso registrado correctamente',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $curso = Curso::findOrFail($id);


        return view('curso.show', compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $curso = Curso::findOrFail($id);
        return view('curso.formulario', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->fill($request->all());
        $curso->save();

        if (!$curso) {
            return response()->json([
                'mensaje' => 'Error al actualizar el curso'
            ], 500);
        }

        return response()->json([
            'mensaje' => 'Curso actualizado correctamente',
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $curso = Curso::findOrFail($id);

        $curso->delete();

        return response()->json([
            'mensaje' => 'Curso eliminado correctamente',
        ], 200);


    }
}
