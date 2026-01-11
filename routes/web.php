<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculacionController;

Route::get('/', function () {
    return view('welcome');



});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('estudiantes', EstudianteController::class);
Route::get('/buscar-estudiantes', [EstudianteController::class, 'buscarEstudiantes'])
        ->name('estudiantes.buscar-estudiantes');


Route::resource('cursos', CursoController::class);
Route::resource('matriculaciones', MatriculacionController::class);

Route::get('/form-agregar-estudiante/{idCurso}', [MatriculacionController::class, 'formAgregarEstudiante'])
        ->name('matriculaciones.form-agregar-estudiante');
