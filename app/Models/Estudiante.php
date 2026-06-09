<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Estudiante extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'rude',
        'user_id',
    ];
//esto esta cargando los datos desde el usuario mediante una funcion de concatenacion
//aqui ya NO se usa join inner join
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
