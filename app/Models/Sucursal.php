<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursal';
    protected $primaryKey = 'idSucursal';

    protected $fillable = [
        'idEmpresas',
        'Nombre',
        'Direccion',
    ];

    // Relación: Una sucursal pertenece a una empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idEmpresas', 'idEmpresas');
    }

    // Relación: Muchos a muchos con empleados
    public function empleados()
    {
        return $this->belongsToMany(\App\Models\Empleado::class, 'empleado_sucursal', 'idSucursal', 'idEmpleado');
    }
}
