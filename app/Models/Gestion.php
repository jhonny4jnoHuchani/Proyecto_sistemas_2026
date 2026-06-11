<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table = 'gestiones'; 
    protected $fillable = [
        'anio', 
        'estado', 
        'fecha_apertura', 
        'fecha_clausura', 
        'documento'
    ];

    protected function casts(): array
    {
        return [
            'estado'          => 'boolean',
            'fecha_apertura'  => 'date',
            'fecha_clausura'  => 'date',
        ];
    }
}
