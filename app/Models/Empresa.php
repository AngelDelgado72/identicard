<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas'; // Nombre exacto de la tabla
    protected $primaryKey = 'idEmpresas';

    protected $fillable = [
        'Nombre',
        'RFC',
        'Direccion',
    ];

    // Relación: Una empresa tiene muchas sucursales
    public function sucursales()
    {
        return $this->hasMany(Sucursal::class, 'idEmpresas', 'idEmpresas');
    }
}
