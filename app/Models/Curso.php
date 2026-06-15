<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'grado',
        'paralelo',
        'turno',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean'
        ];
    }

    // Relación: un curso tiene muchas asignaciones
    public function asignaciones(): HasMany
    {
        return $this->hasMany(Asignacion::class, 'curso_id');
    }

    // Relación: un curso tiene muchas inscripciones
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'id_curso');
    }
}