<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trimestre extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'gestion_id',
        'nombre',
        'estado'
    ];

    // Le decimos a Laravel que un Trimestre pertenece a una Gestión
    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }
}
