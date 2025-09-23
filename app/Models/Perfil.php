<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';
    protected $primaryKey = 'idPerfil';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación many-to-many con permisos
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'perfil_permiso', 'idPerfil', 'idPermiso');
    }

    // Relación one-to-many con usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'idPerfil', 'idPerfil');
    }
}
