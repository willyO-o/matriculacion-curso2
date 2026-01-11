<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;

use DataTables;
use PhpParser\Node\Expr\FuncCall;

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
                ->addColumn('nombre_completo', function ($estudiante) {

                    $nombreCompleto = "{$estudiante->nombre} {$estudiante->paterno} {$estudiante->materno}";


                    $rutaImagen = asset('storage/' . $estudiante->foto);
                    $edad = $estudiante->fecha_nacimiento->age;

                    return ' <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="' . $rutaImagen . '"
                                                    class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">' . $nombreCompleto . '</h6>
                                                <p class="text-xs text-secondary mb-0">' . $edad . ' años</p>
                                            </div>
                                        </div>';
                })
                ->editColumn('estado', function ($estudiante) {
                    $clase = $estudiante->estado == "ACTIVO" ? 'badge bg-gradient-success' : 'badge bg-gradient-danger';

                    return '<span class="' . $clase . '">' . $estudiante->estado . '</span>';
                })
                ->addColumn('id', function ($estudiante) {
                    return '<button value="' . route('estudiantes.edit', $estudiante->id) . '" class="btn  btn-warning btn-editar">
                        <i class="fa fa-edit"></i>
                        </button>
                        <button value="' . route('estudiantes.destroy', $estudiante->id) . '" class="btn  btn-danger btn-eliminar">
                        <i class="fa fa-trash"></i>
                        </button>';
                })
                ->rawColumns(['nombre_completo', 'estado', 'id'])
                ->make(true);
        }

        return view('estudiante.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estudiante = new Estudiante();
        return view('estudiante.formulario', compact('estudiante'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(Estudiante::$rules);

        $foto = $request->file('foto');

        $nombreArchivo = $this->subirFoto($foto);

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

        $estudiante = Estudiante::findOrFail($id);

        return view('estudiante.formulario', compact('estudiante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $foto = $request->file('foto');

        $rules = Estudiante::$rules;
        $rules['ci'] = 'required|regex:/^\d{6,15}(-[A-Za-z0-9]*)?$/|unique:estudiante,ci,' . $id;

        if (!$foto){
            unset($rules['foto']);
        }


        $request->validate($rules);

        $estudiante = Estudiante::findOrFail($id);


        $datos = $request->all();

        if ($foto) {

            $nombreArchivo = $this->subirFoto($foto);
            $datos['foto'] = 'fotos/' . $nombreArchivo;

            $fotoAnterior = $estudiante->foto;
        }



        $estudiante->fill($datos);

        $estudiante->save();

        if ($foto) {

            if (file_exists(storage_path('app/public/' . $fotoAnterior))) {
                unlink(storage_path('app/public/' . $fotoAnterior));
            }
        }


        return response()->json([
            'mensaje' => 'Estudiante actualizado correctamente',
            'datos' => $estudiante,
        ]);

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $fotoAnterior = $estudiante->foto;

        $estudiante->delete();

        if (file_exists(storage_path('app/public/' . $fotoAnterior))) {
            unlink(storage_path('app/public/' . $fotoAnterior));
        }


        return response()->json([
            'mensaje' => 'Estudiante eliminado!',
        ]);
    }


    private function subirFoto($foto)
    {

        $nombreArchivo = time() . '_' . uniqid() . '_' . date('YmdHis') . '.' . $foto->getClientOriginalExtension();

        if (!is_dir(storage_path('app/public/fotos'))) {
            // si no existe la carpeta, la creamos
            mkdir(storage_path('app/public/fotos'), 0755, true);
        }

        $foto->move(storage_path('app/public/fotos/'), $nombreArchivo);

        return $nombreArchivo;
    }




    public function buscarEstudiantes(Request $request)
    {

        $busqueda = $request->input('term');
        $busqueda = '%'.str_ireplace(' ', '%', $busqueda).'%';

        $resultado = Estudiante::selectRaw("id, CONCAT(nombre,' ',paterno,' ',materno, ' - ', ci) AS text")
                                    ->where('nombre', 'like', $busqueda)
                                    ->orWhere('paterno', 'like', $busqueda)
                                    ->orWhere('materno', 'like', $busqueda)
                                    ->orWhere('ci', 'like', $busqueda)
                                    ->orWhereRaw("CONCAT(nombre,' ',paterno,' ',materno) LIKE ?", [$busqueda])
                                    ->orWhereRaw("CONCAT(paterno,' ',nombre,' ',materno) LIKE ?", [$busqueda])
                                    ->orWhereRaw("CONCAT(paterno,' ',paterno,' ',nombre) LIKE ?", [$busqueda])
                                    ->limit(10)
                                    ->get();

        return response()->json(['results' => $resultado]);


    }


}
