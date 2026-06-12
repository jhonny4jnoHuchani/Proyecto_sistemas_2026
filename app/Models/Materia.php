<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    // Aquí le decimos a Laravel: "Está bien, confía en estos campos cuando lleguen del formulario"
    protected $fillable = [
        'nombre',
        'area',
        'carga_horaria',
        'estado'
    ];
}