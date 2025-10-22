<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Paquete extends Model
{
    protected $table = 'paquetes';
    protected $primaryKey = 'idPaquete';
    
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'idPaquete';
    }
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_creacion',
        'estatus',
        'creado_por'
    ];

    protected $casts = [
        'fecha_creacion' => 'date'
    ];

    /**
     * Relación con el usuario que creó el paquete
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    /**
     * Relación muchos a muchos con empleados
     */
    public function empleados(): BelongsToMany
    {
        return $this->belongsToMany(
            Empleado::class,
            'paquete_empleado',
            'idPaquete',
            'idEmpleado'
        )->withTimestamps();
    }

    /**
     * Scope para obtener paquetes en creación
     */
    public function scopeEnCreacion($query)
    {
        return $query->where('estatus', 'en_creacion');
    }

    /**
     * Scope para obtener paquetes confirmados
     */
    public function scopeConfirmado($query)
    {
        return $query->where('estatus', 'confirmado');
    }

    /**
     * Scope para obtener paquetes autorizados
     */
    public function scopeAutorizado($query)
    {
        return $query->where('estatus', 'autorizado');
    }

    /**
     * Verificar si todos los empleados del paquete están validados
     */
    public function todosEmpleadosValidados()
    {
        if ($this->empleados->isEmpty()) {
            return false;
        }

        return $this->empleados->every(function ($empleado) {
            return $empleado->Validado == true;
        });
    }

    /**
     * Verificar si el paquete puede ser autorizado
     */
    public function puedeSerAutorizado()
    {
        return $this->estatus === 'confirmado' && $this->todosEmpleadosValidados();
    }

    /**
     * Verificar si el paquete puede ser editado
     */
    public function puedeSerEditado()
    {
        return $this->estatus === 'en_creacion';
    }

    /**
     * Obtener el color del badge para el estatus
     */
    public function getColorEstatusAttribute()
    {
        return match($this->estatus) {
            'en_creacion' => 'bg-yellow-100 text-yellow-800',
            'confirmado' => 'bg-blue-100 text-blue-800',
            'autorizado' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Obtener el texto del estatus
     */
    public function getTextoEstatusAttribute()
    {
        return match($this->estatus) {
            'en_creacion' => 'En Creación',
            'confirmado' => 'Confirmado',
            'autorizado' => 'Autorizado',
            default => 'Desconocido'
        };
    }
}
