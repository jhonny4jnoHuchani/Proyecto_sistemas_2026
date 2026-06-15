<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Asignacion;

class Nota extends Model
{
    protected $table = 'notas';
    protected $primaryKey = 'id_nota';
    
    protected $fillable = [
        'id_inscripcion',
        'id_asignacion',
        'id_trimestre',
        'nota_final'
    ];
    
    protected $casts = [
        'nota_final' => 'float',
    ];
    
    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class, 'id_inscripcion');
    }
    
    public function asignacion(): BelongsTo
    {
        return $this->belongsTo(Asignacion::class, 'id_asignacion');
    }
    
    public function trimestre(): BelongsTo
    {
        return $this->belongsTo(Trimestre::class, 'id_trimestre');
    }
}