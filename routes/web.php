<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;

use App\Http\Controllers\CursoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(); //Esta linea esconde la orden "Si alguien pide ver /login, envialo a LoginController"
# GET sirven solo para mostrar 
# POST sirven para enviar datos al servidor
# PUT sirven para actualizar datos en el servidor
# DELETE sirven para eliminar datos en el servidor
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
##aqui listamos los estudiantes????
Route::get('/estudiantes/listar', [App\Http\Controllers\EstudianteController::class, 'index'])->name('estudiantes.listar');


Route::post('/estudiantes/crear', [App\Http\Controllers\EstudianteController::class, 'store'])->name('estudiantes.store');
Route::put('/estudiantes/actualizar/{id}', [EstudianteController::class, 'update'])->name('estudiantes.actualizar');
Route::delete('/estudiantes/{id}/eliminar', [EstudianteController::class, 'destroy'])->name('estudiantes.eliminar');

// PROTEGEMOS EL CRUD DE CURSOS
// Usamos el middleware 'auth' para que nadie pueda entrar sin iniciar sesión
Route::middleware(['auth'])->group(function () {
    
    // Esta línea mágica crea las 7 rutas del CRUD (index, create, store, edit, update, destroy, show)
    Route::resource('cursos', CursoController::class);
    
});

Route::middleware(['auth'])->group(function () {
    
    // Cambiamos el diseño de la URL para evitar colisiones con 'cursos/{id}'
    Route::get('papelera/cursos', [CursoController::class, 'inactivos'])->name('cursos.inactivos');
    Route::post('papelera/cursos/{id}/restaurar', [CursoController::class, 'restaurar'])->name('cursos.restaurar');
    Route::delete('papelera/cursos/{id}/forzar-eliminacion', [CursoController::class, 'forceDelete'])->name('cursos.forceDelete');
    
    // El recurso se queda tal cual
    Route::resource('cursos', CursoController::class);
    
});