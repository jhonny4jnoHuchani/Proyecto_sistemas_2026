<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'ci',
        'cargo',
        'estado'
    ];

    // Relación: Un administrativo pertenece a una cuenta de usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}