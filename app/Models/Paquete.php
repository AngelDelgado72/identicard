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
}
