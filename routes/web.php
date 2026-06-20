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
use App\Http\Controllers\EstudiantePanelController;
use App\Http\Controllers\HomeController;

// ==========================================================
// RUTAS PÚBLICAS / AUTENTICACIÓN
// ==========================================================
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


// ==========================================================
// ADMIN + SECRETARIA: gestión académica general
// (todo lo de estudiantes, docentes, cursos, materias,
//  asignaciones, trimestres y gestiones)
// ==========================================================
Route::middleware(['auth', 'role:admin,secretaria'])->group(function () {

    // --- Estudiantes ---
    Route::get('/estudiantes/listar', [EstudianteController::class, 'index'])->name('estudiantes.listar');
    Route::post('/estudiantes/crear', [EstudianteController::class, 'storeAjax'])->name('estudiantes.store');
    Route::put('/estudiantes/actualizar/{id}', [EstudianteController::class, 'update'])->name('estudiantes.actualizar');
    Route::delete('/estudiantes/{id}/eliminar', [EstudianteController::class, 'destroy'])->name('estudiantes.eliminar');
    Route::get('/estudiantes/{id}/pdf', [EstudianteController::class, 'generarPdf'])->name('estudiantes.pdf');

    // --- Cursos ---
    Route::get('papelera/cursos', [CursoController::class, 'inactivos'])->name('cursos.inactivos');
    Route::post('papelera/cursos/{id}/restaurar', [CursoController::class, 'restaurar'])->name('cursos.restaurar');
    Route::delete('papelera/cursos/{id}/forzar-eliminacion', [CursoController::class, 'forceDelete'])->name('cursos.forceDelete');
    Route::resource('cursos', CursoController::class);

    // --- Docentes ---
    Route::get('docentes/inactivos', [DocenteController::class, 'inactivos'])->name('docentes.inactivos');
    Route::put('docentes/restore/{id}', [DocenteController::class, 'restore'])->name('docentes.restore');
    Route::resource('docentes', DocenteController::class)->except(['show']);

    // --- Gestiones ---
    Route::get('gestiones', [GestionController::class, 'index'])->name('gestiones.index');
    Route::post('gestiones/crear', [GestionController::class, 'store'])->name('gestiones.store');
    Route::put('gestiones/{gestion}', [GestionController::class, 'update'])->name('gestiones.update');
    Route::post('gestiones/{id}/activar', [GestionController::class, 'activar'])->name('gestiones.activar');

    // --- Materias ---
    Route::get('papelera/materias', [MateriaController::class, 'inactivos'])->name('materias.inactivos');
    Route::post('papelera/materias/{id}/restaurar', [MateriaController::class, 'restaurar'])->name('materias.restaurar');
    Route::delete('papelera/materias/{id}/forzar-eliminacion', [MateriaController::class, 'forceDelete'])->name('materias.forceDelete');
    Route::resource('materias', MateriaController::class);

    // --- Asignaciones (designaciones de docentes a cursos/materias) ---
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

    // --- Trimestres ---
    Route::post('trimestres/{id}/toggle', [TrimestreController::class, 'toggle'])->name('trimestres.toggle');
    Route::resource('trimestres', TrimestreController::class);
});


// ==========================================================
// SOLO ADMIN: administrativos (la excepción que pediste)
// ==========================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('papelera/administrativos', [AdministrativoController::class, 'inactivos'])->name('administrativos.inactivos');
    Route::post('papelera/administrativos/{id}/restaurar', [AdministrativoController::class, 'restaurar'])->name('administrativos.restaurar');
    Route::delete('papelera/administrativos/{id}/forzar-eliminacion', [AdministrativoController::class, 'forceDelete'])->name('administrativos.forceDelete');
    Route::resource('administrativos', AdministrativoController::class);
});


// ==========================================================
// ADMIN + DOCENTE: carga y gestión de notas
// ==========================================================
Route::middleware(['auth', 'role:admin,docente'])->prefix('notas')->name('notas.')->group(function () {

    // Vista 1 — Lista de cursos
    Route::get('/', [NotaController::class, 'index'])->name('index');

    // Vista 2 — Materias de un curso
    Route::get('/{curso}/materias', [NotaController::class, 'materias'])->name('materias');

    // Vista 3 — Trimestres de una asignación
    Route::get('/{curso}/materias/{asignacion}/trimestres', [NotaController::class, 'trimestres'])->name('trimestres');

    // Vista 4 — Tabla de carga de notas
    Route::get('/{curso}/materias/{asignacion}/trimestres/{trimestre}', [NotaController::class, 'cargar'])->name('cargar');

    // AJAX — Autoguardado de nota individual (sin recarga de página)
    Route::post('/guardar', [NotaController::class, 'guardar'])->name('guardar');

    // PDF del boletín de notas (desde la vista de carga)
    Route::get('/{curso}/{asignacion}/{trimestre}/pdf', [NotaController::class, 'generarPdf'])->name('pdf');
});


// ==========================================================
// ADMIN + ESTUDIANTE: panel del estudiante
// ==========================================================
Route::middleware(['auth', 'role:admin,estudiante'])->group(function () {
    Route::get('/mi-panel', [EstudiantePanelController::class, 'dashboard'])->name('estudiante.dashboard');
    Route::get('/mis-notas', [EstudiantePanelController::class, 'misNotas'])->name('estudiante.notas');
    Route::get('/mis-notas/pdf', [EstudiantePanelController::class, 'generarPDF'])->name('estudiante.notas.pdf');
});