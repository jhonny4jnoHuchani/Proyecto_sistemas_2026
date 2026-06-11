<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Administrativo extends Model
{
    protected $table = 'administrativos';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'ci',
        'cargo',
        'estado'
    ];
    protected function casts(): array
    {
        return ['estado' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
