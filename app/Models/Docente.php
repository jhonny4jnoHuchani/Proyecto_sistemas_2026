<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Docente extends Model
{
    //
    protected $table = 'docentes';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'ci',
        'especialidad',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'estado'=>'boolean'
        ];
    }

    //Relacion eloquent: Un docente pertenece a un usuario
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
