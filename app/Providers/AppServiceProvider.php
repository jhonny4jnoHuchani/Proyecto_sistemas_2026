<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Admin: acceso total
        Gate::define('es-admin', fn($user) => $user->rol === 'admin');

        // Admin + Secretaria: gestión de estudiantes, docentes, cursos, materias, etc.
        Gate::define('gestion-academica', fn($user) => in_array($user->rol, ['admin', 'secretaria']));

        // SOLO Admin: crear/editar administrativos (la excepción que pediste)
        Gate::define('gestion-administrativos', fn($user) => $user->rol === 'admin');

        // Admin + Docente: panel y notas del docente
        Gate::define('es-docente', fn($user) => in_array($user->rol, ['admin', 'docente']));

        // Admin + Estudiante: panel del estudiante
        Gate::define('es-estudiante', fn($user) => in_array($user->rol, ['admin', 'estudiante']));
    }
}