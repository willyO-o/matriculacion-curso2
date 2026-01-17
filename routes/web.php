<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculacionController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {


    Route::resource('estudiantes', EstudianteController::class);
    Route::get('/buscar-estudiantes', [EstudianteController::class, 'buscarEstudiantes'])
        ->name('estudiantes.buscar-estudiantes');


    Route::resource('cursos', CursoController::class);


    Route::get('/form-agregar-estudiante/{idCurso}', [MatriculacionController::class, 'formAgregarEstudiante'])
        ->name('matriculaciones.form-agregar-estudiante');
    Route::get('/estudiantes-matriculados/{idCurso}', [MatriculacionController::class, 'indexEstudiantesMatriculados'])
        ->name('matriculaciones.estudiantes-matriculados');

    Route::get('/matricula-pdf/{idMatriculacion}', [MatriculacionController::class, 'matriculaPdf'])
        ->name('matriculaciones.matricula-pdf');
});


Route::resource('matriculaciones', MatriculacionController::class);
