<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'idPerfil',
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

    // Relación con perfil
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'idPerfil', 'idPerfil');
    }

    // Método para verificar si el usuario tiene un permiso específico
    public function tienePermiso($modulo, $accion)
    {
        if (!$this->perfil) {
            return false;
        }

        return $this->perfil->permisos()
            ->where('modulo', $modulo)
            ->where('accion', $accion)
            ->exists();
    }

    // Método para obtener todos los permisos del usuario
    public function permisos()
    {
        if (!$this->perfil) {
            return collect();
        }

        return $this->perfil->permisos;
    }
}
