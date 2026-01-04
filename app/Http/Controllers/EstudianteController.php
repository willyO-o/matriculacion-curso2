<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;

use DataTables;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->ajax()) {

            $query = Estudiante::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('foto', function ($estudiante){

                    $nombreCompleto = "{$estudiante->nombre} {$estudiante->paterno} {$estudiante->materno}";


                    $rutaImagen = asset('storage/' . $estudiante->foto);
                    $edad= $estudiante->fecha_nacimiento->age;

                    return ' <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="'.$rutaImagen.'"
                                                    class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">'.$nombreCompleto.'</h6>
                                                <p class="text-xs text-secondary mb-0">'.$edad.' años</p>
                                            </div>
                                        </div>';
                })
                ->rawColumns(['foto'])
                ->make(true);
        }

        return view('estudiante.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(('estudiante.formulario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $foto = $request->file('foto');

        $nombreArchivo = time() . '_' . uniqid() . '_' . date('YmdHis') . '.' . $foto->getClientOriginalExtension();

        if (!is_dir(storage_path('app/public/fotos'))) {
            // si no existe la carpeta, la creamos
            mkdir(storage_path('app/public/fotos'), 0755, true);
        }

        $foto->move(storage_path('app/public/fotos/'), $nombreArchivo);

        $datos = $request->all();
        $datos['foto'] = 'fotos/' . $nombreArchivo;

        $estudiante = Estudiante::create($datos);

        if (!$estudiante) {
            return response()->json([
                'mensaje' => 'Error al registrar el estudiante'
            ], 500);
        }


        return response()->json([
            'mensaje' => 'Estudiante registrado correctamente',
            'datos' => $estudiante,
        ], 201);
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
}
