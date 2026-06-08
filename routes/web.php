<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
# GET sirven solo para mostrar 
# POST sirven para enviar datos al servidor
# PUT sirven para actualizar datos en el servidor
# DELETE sirven para eliminar datos en el servidor
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/estudiantes/listar', [App\Http\Controllers\EstudianteController::class, 'index'])->name('estudiantes.listar');
Route::post('/estudiantes/crear', [App\Http\Controllers\EstudianteController::class, 'store'])->name('estudiantes.store');
Route::put('/estudiantes/actualizar/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update');