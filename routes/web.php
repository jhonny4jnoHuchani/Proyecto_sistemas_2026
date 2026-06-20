<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\TrimestreController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\AdministrativoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/estudiantes/listar', [App\Http\Controllers\EstudianteController::class, 'index'])->name('estudiantes.listar');
Route::post('/estudiantes/crear', [EstudianteController::class, 'storeAjax'])->name('estudiantes.store');
Route::put('/estudiantes/actualizar/{id}', [EstudianteController::class, 'update'])->name('estudiantes.actualizar');
Route::delete('/estudiantes/{id}/eliminar', [EstudianteController::class, 'destroy'])->name('estudiantes.eliminar');
Route::get('/estudiantes/{id}/pdf', [EstudianteController::class, 'generarPdf'])->name('estudiantes.pdf');


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
    
    //rutas para docentes---- JAH

    Route::get('docentes/inactivos', [DocenteController::class, 'inactivos'])->name('docentes.inactivos');
    Route::put('docentes/restore/{id}', [DocenteController::class, 'restore'])->name('docentes.restore');
    Route::resource('docentes', DocenteController::class)->except(['show']);

    Route::get('gestiones', [GestionController::class, 'index'])->name('gestiones.index');
    Route::post('gestiones/crear', [GestionController::class, 'store'])->name('gestiones.store');
    Route::put('gestiones/{gestion}', [GestionController::class, 'update'])->name('gestiones.update');

    // ==========================================
    // RUTAS PARA MATERIAS
    // ==========================================
    Route::get('papelera/materias', [MateriaController::class, 'inactivos'])->name('materias.inactivos');
    Route::post('papelera/materias/{id}/restaurar', [MateriaController::class, 'restaurar'])->name('materias.restaurar');
    Route::delete('papelera/materias/{id}/forzar-eliminacion', [MateriaController::class, 'forceDelete'])->name('materias.forceDelete');
    
    Route::resource('materias', MateriaController::class);


    // Papelera de Asignaciones
    Route::get('papelera/asignaciones', [AsignacionController::class, 'inactivos'])->name('asignaciones.inactivos');
    Route::post('papelera/asignaciones/{id}/restaurar', [AsignacionController::class, 'restaurar'])->name('asignaciones.restaurar');
    Route::delete('papelera/asignaciones/{id}/forzar-eliminacion', [AsignacionController::class, 'forceDelete'])->name('asignaciones.forceDelete');



    Route::prefix('asignaciones')->name('asignaciones.')->group(function () {

        Route::get('/', [AsignacionController::class, 'index'])->name('index');

        Route::get('/grado/{grado}', [AsignacionController::class, 'paralelos'])->name('paralelos');
        Route::post('/grado/{grado}/asignar', [AsignacionController::class, 'asignarMasivo'])->name('asignarMasivo');

        Route::get('/curso/{curso}', [AsignacionController::class, 'detalle'])->name('detalle');
        Route::post('/curso/{curso}/docentes', [AsignacionController::class, 'guardarDocentes'])->name('guardarDocentes');
        Route::post('/curso/{curso}/agregar-materia', [AsignacionController::class, 'agregarMateria'])->name('agregarMateria');

    });
    
    Route::prefix('notas')->name('notas.')->middleware(['auth'])->group(function () {
    
        // Vista 1 — Lista de cursos
        Route::get('/', [NotaController::class, 'index'])
            ->name('index');
    
        // Vista 2 — Materias de un curso
        Route::get('/{curso}/materias', [NotaController::class, 'materias'])
            ->name('materias');
    
        // Vista 3 — Trimestres de una asignación
        Route::get('/{curso}/materias/{asignacion}/trimestres', [NotaController::class, 'trimestres'])
            ->name('trimestres');
    
        // Vista 4 — Tabla de carga de notas
        Route::get('/{curso}/materias/{asignacion}/trimestres/{trimestre}', [NotaController::class, 'cargar'])
            ->name('cargar');
    
        // AJAX — Autoguardado de nota individual (sin recarga de página)
        Route::post('/guardar', [NotaController::class, 'guardar'])
            ->name('guardar');
    
    });

    // Papelera Administrativos
    Route::get('papelera/administrativos', [AdministrativoController::class, 'inactivos'])->name('administrativos.inactivos');
    Route::post('papelera/administrativos/{id}/restaurar', [AdministrativoController::class, 'restaurar'])->name('administrativos.restaurar');
    Route::delete('papelera/administrativos/{id}/forzar-eliminacion', [AdministrativoController::class, 'forceDelete'])->name('administrativos.forceDelete');

    // CRUD Administrativos
    Route::resource('administrativos', AdministrativoController::class);

    // Ruta para el interruptor AJAX de Trimestres
    Route::post('trimestres/{id}/toggle', [App\Http\Controllers\TrimestreController::class, 'toggle'])->name('trimestres.toggle');
    
    Route::resource('trimestres', App\Http\Controllers\TrimestreController::class);

    // Ruta para activar una gestión académica
    Route::post('gestiones/{id}/activar', [App\Http\Controllers\GestionController::class, 'activar'])->name('gestiones.activar');
    Route::get('notas/{curso}/{asignacion}/{trimestre}/pdf', [App\Http\Controllers\NotaController::class, 'generarPdf'])->name('notas.pdf');
    // Panel del Estudiante
    Route::get('/mi-panel', [App\Http\Controllers\EstudiantePanelController::class, 'dashboard'])->name('estudiante.dashboard');
    Route::get('/mis-notas', [App\Http\Controllers\EstudiantePanelController::class, 'misNotas'])->name('estudiante.notas');
    Route::get('/mis-notas/pdf', [App\Http\Controllers\EstudiantePanelController::class, 'generarPDF'])->name('estudiante.notas.pdf');

});