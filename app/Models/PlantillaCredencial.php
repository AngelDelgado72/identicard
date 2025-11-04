<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaCredencial extends Model
{
    protected $table = 'plantillas_credenciales';

    protected $fillable = [
        'nombre',
        'imagen_frontal',
        'imagen_trasera',
        'ancho_mm',
        'alto_mm',
        'campos_frontal',
        'campos_trasera',
        'activa'
    ];

    protected $casts = [
        'campos_frontal' => 'array',
        'campos_trasera' => 'array',
        'activa' => 'boolean'
    ];

    public function scopeActiva($query)
    {
        return $query->where('activa', true);
    }

    /**
     * Al activar esta plantilla, desactivar todas las demás
     */
    protected static function booted()
    {
        static::saving(function ($plantilla) {
            if ($plantilla->activa) {
                static::where('id', '!=', $plantilla->id)->update(['activa' => false]);
            }
        });
    }
}
