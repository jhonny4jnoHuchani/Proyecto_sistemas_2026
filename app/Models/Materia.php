<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table='materias';

    protected $primaryKey = 'id_materia';

    protected $fillable = [
        'nombre',
        'area',
        'carga_horaria',
        'estado',
    ];
}
