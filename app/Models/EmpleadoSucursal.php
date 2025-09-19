<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoSucursal extends Model
{
    use HasFactory;

    protected $table = 'empleado_sucursal';
    protected $primaryKey = 'idEmpleadoSucursal';

    protected $fillable = [
        'idEmpleado',
        'idSucursal',
    ];
}
