<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Estudiante extends Model
{
    protected $table='estudiantes';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'ci',
        'rude', 
        'fecha_nacimiento',
        'telefono',
        'estado'
    ];
    
    public $timestamps = false;
    
    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'fecha_nacimiento' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Última inscripción activa del estudiante (su curso actual)
    public function inscripcionActiva(): HasOne
    {
        return $this->hasOne(Inscripcion::class, 'id_estudiante')
                     ->where('estado', true)
                     ->latest('id_inscripcion');
    }
}