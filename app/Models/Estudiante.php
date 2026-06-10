<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Estudiante extends Model
{
    protected $table='estudiantes';
    protected $primaryKey = 'id_estudiante';

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
    
//esto esta cargando los datos desde el usuario mediante una funcion de concatenacion
//aqui ya NO se usa join inner join
    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'fecha_nacimiento' => 'date', // Laravel convertirá esto en un objeto Carbon para manipular fechas fácilmente
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
