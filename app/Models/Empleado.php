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
        'Validado',
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

    /**
     * Relación muchos a muchos con paquetes
     */
    public function paquetes()
    {
        return $this->belongsToMany(
            Paquete::class,
            'paquete_empleado',
            'idEmpleado',
            'idPaquete'
        )->withTimestamps();
    }

    /**
     * Obtener la sucursal principal del empleado
     * Si tiene sucursal directa, la usa. Si no, toma la primera de las sucursales asociadas
     */
    public function getSucursalPrincipalAttribute()
    {
        // Si tiene sucursal directa asignada
        if ($this->sucursal) {
            return $this->sucursal;
        }

        // Si no, tomar la primera sucursal de la relación muchos a muchos
        return $this->sucursales->first();
    }

    /**
     * Obtener el nombre de la sucursal principal
     */
    public function getNombreSucursalAttribute()
    {
        $sucursal = $this->getSucursalPrincipalAttribute();
        return $sucursal ? $sucursal->Nombre : 'Sin sucursal';
    }

    /**
     * Obtener todas las sucursales del empleado como string
     */
    public function getNombresSucursalesAttribute()
    {
        $sucursales = collect();
        
        // Agregar sucursal directa si existe
        if ($this->sucursal) {
            $sucursales->push($this->sucursal->Nombre);
        }
        
        // Agregar sucursales de la tabla pivote
        foreach ($this->sucursales as $sucursal) {
            if (!$sucursales->contains($sucursal->Nombre)) {
                $sucursales->push($sucursal->Nombre);
            }
        }
        
        return $sucursales->count() > 0 ? $sucursales->implode(', ') : 'Sin sucursal';
    }

    /**
     * Obtener todas las sucursales para búsqueda (en minúsculas)
     */
    public function getSucursalesParaBusquedaAttribute()
    {
        $sucursales = collect();
        
        // Agregar sucursal directa si existe
        if ($this->sucursal) {
            $sucursales->push(strtolower($this->sucursal->Nombre));
        }
        
        // Agregar sucursales de la tabla pivote
        foreach ($this->sucursales as $sucursal) {
            $nombre = strtolower($sucursal->Nombre);
            if (!$sucursales->contains($nombre)) {
                $sucursales->push($nombre);
            }
        }
        
        return $sucursales->implode(' ');
    }

    public function getStatusAttribute()
    {
        $camposObligatorios = [
            'Nombre',
            'Apellido',
            'Correo',
            'TipoSangre',
            'NumeroSeguroSocial',
            'CodigoRH',
            'Puesto',
            'Departamento',
            'RFC',
            'Firma',
            'Foto'
        ];

        foreach ($camposObligatorios as $campo) {
            if (empty($this->$campo)) {
                return 'Incompleto';
            }
        }
        return 'Completo';
    }
}
