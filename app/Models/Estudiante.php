<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'rude',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
