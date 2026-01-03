<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoController;

Route::get('/', function () {
    return view('welcome');



});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('estudiantes', EstudianteController::class);
Route::resource('cursos', CursoController::class);
