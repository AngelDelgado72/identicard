<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $primaryKey = 'idPermiso';

    protected $fillable = [
        'nombre',
        'descripcion',
        'modulo',
        'accion',
    ];

    // Relación many-to-many con perfiles
    public function perfiles()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_permiso', 'idPermiso', 'idPerfil');
    }
}
