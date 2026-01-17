<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Matriculacion;
use App\Models\Curso;

// importar la clase para transacciones
use Illuminate\Support\Facades\DB;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

require_once base_path('vendor/setasign/fpdf/fpdf.php');

use FPDF;


class MatriculacionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

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
        $matriculacion = Matriculacion::findOrFail($id);

        return $matriculacion;
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
        $matriculacion = Matriculacion::findOrFail($id);
        $matriculacion->delete();
        return response()->json([
            'mensaje' => 'Estudiante desmatriculado correctamente',
        ]);
    }


    public function formAgregarEstudiante(string $idCurso)
    {

        $curso = Curso::findOrFail($idCurso);

        return view('matriculacion.formulario', compact('curso'));
    }


    public function indexEstudiantesMatriculados(string $idCurso)
    {

        $curso = Curso::findOrFail($idCurso);

        $estudiantes =  $curso->estudiantes;

        // return $estudiantes;

        return view('matriculacion.listar-matriculados', compact('curso', 'estudiantes'));
    }


    public function matriculaPdf(string $idMatricuacion)
    {



        $matriculacion = Matriculacion::findOrFail($idMatricuacion);

        $estudiante = $matriculacion->estudiante;

        $curso = $matriculacion->curso;


        $pdf = new FPDF('P', 'mm', [100, 140]);
        $pdf->AddPage();


        $pdf->image(public_path('assets/img/plantillas/plantilla-matricula.png'), 0, 0, 100, 140);

        $pdf->image(storage_path('app/public/' . $estudiante->foto), 75, 30, 20, 28);


        $datosRecurso = " { $estudiante->nombre} {$estudiante->paterno} {$estudiante->materno} | CI: {$estudiante->ci} | Curso: {$matriculacion->curso->nombre} | Nro Matricula: {$matriculacion->nro_matricula} ";

        $ulrRecurso = url('matriculaciones/' . $matriculacion->id);

        $imagenQr = 'data:image/png;base64,' . base64_encode(QrCode::encoding('UTF-8')->size(500)->format('png')->generate($ulrRecurso));

        $pdf->image($imagenQr, 10, 100, 25, 25, 'PNG');


        // titulo
        $pdf->SetXY(0, 10);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(32, 59, 199);
        $pdf->Cell(100, 12, mb_convert_encoding("{$curso->titulo} ", 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');


        //datos
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(30, 33);
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(40, 10, mb_convert_encoding("{$estudiante->nombre} ", 'ISO-8859-1', 'UTF-8'));


        $pdf->SetXY(30, 40);
        $pdf->Cell(40, 10, mb_convert_encoding("{$estudiante->paterno} {$estudiante->materno}", 'ISO-8859-1', 'UTF-8'));

        $pdf->SetXY(30, 47);

        $pdf->Cell(40, 10, mb_convert_encoding("{$matriculacion->nro_matricula}", 'ISO-8859-1', 'UTF-8'));

        $pdf->Output();

        return exit;
    }
}
