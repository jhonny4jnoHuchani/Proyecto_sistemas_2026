<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    // indicar la tabla asociada
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
            'estado'=>'boolean'
        ];
    }
}
