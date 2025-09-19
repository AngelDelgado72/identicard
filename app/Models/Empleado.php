<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'idEmpleado';

    protected $fillable = [
        'Nombre',
        'Apellido',
        'Correo',
        'TipoSangre',
        'NumeroSeguroSocial',
        'CodigoRH',
        'Puesto',
        'Departamento', // <-- debe estar aquí
        'RFC',          // <-- debe estar aquí
        'Firma',
        'Foto',
        // 'idSucursal', // si lo usas como sucursal principal
    ];

    public function sucursales()
    {
        return $this->belongsToMany(\App\Models\Sucursal::class, 'empleado_sucursal', 'idEmpleado', 'idSucursal');
    }

    public function sucursal()
    {
        return $this->belongsTo(\App\Models\Sucursal::class, 'idSucursal', 'idSucursal');
    }
}
