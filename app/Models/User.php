<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    //modificado para agregar los campos adicionales del proyecto
    protected $fillable = [
        'username',      // ← Agrega esto (es lo que usa tu tabla)
        'email',
        'password',
        'rol',           // Si lo necesitas en registro
        'estado',        // Si lo quieres manejar
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }
// AdminLTE: Avatar (usamos gravatar o icono por defecto)
    public function adminlte_image()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->username) . '&background=003399&color=ffd700&size=128';
    }

    // AdminLTE: Descripción (rol)
    public function adminlte_desc()
    {
        $roles = [
            'admin' => 'Administrador',
            'secretaria' => 'Secretaria',
            'docente' => 'Docente',
            'estudiante' => 'Estudiante',
        ];
        return $roles[$this->rol] ?? $this->rol;
    }

    // AdminLTE: URL del perfil
    public function adminlte_profile_url()
    {
        return '#'; // Cambiar cuando tengas ruta de perfil
    }
    
}
