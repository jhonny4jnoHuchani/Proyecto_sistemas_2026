<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    // indicar la tabla asociada
    protected $table = 'cursos';

    //Definir la llave primaria 
    protected $primaryKey = 'id_curso';

    protected $fulable = [
        'nombre',
        'paralelo',
        'turno',
        'estado',
    ];
}
