<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Sucursal;
use App\Models\Empleado;
use Illuminate\Http\Request;

class OrganizationalController extends Controller
{
    /**
     * Obtener información de una empresa con sus sucursales
     */
    public function getEmpresa($id)
    {
        try {
            $empresa = Empresa::with(['sucursales.empleados'])->findOrFail($id);
            
            // Filtrar sucursales si el usuario tiene restricciones
            $user = auth()->user();
            if ($user->sucursales->count() > 0) {
                $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
                $empresa->sucursales = $empresa->sucursales->whereIn('idSucursal', $sucursalesUsuario);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $empresa->idEmpresas,
                    'nombre' => $empresa->Nombre,
                    'rfc' => $empresa->RFC,
                    'direccion' => $empresa->Direccion ?? 'No definida',
                    'created_at' => $empresa->created_at ? $empresa->created_at->format('d/m/Y') : 'No disponible',
                    'sucursales' => $empresa->sucursales->map(function($sucursal) {
                        return [
                            'id' => $sucursal->idSucursal,
                            'nombre' => $sucursal->Nombre,
                            'direccion' => $sucursal->Direccion ?? 'No definida',
                            'empleados_count' => $sucursal->empleados->count()
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener información de la empresa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener información de una sucursal con sus empleados
     */
    public function getSucursal($id)
    {
        try {
            $sucursal = Sucursal::with(['empresa', 'empleados'])->findOrFail($id);
            
            // Verificar si el usuario tiene acceso a esta sucursal
            $user = auth()->user();
            if ($user->sucursales->count() > 0) {
                $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
                if (!in_array($sucursal->idSucursal, $sucursalesUsuario)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No tienes acceso a esta sucursal'
                    ], 403);
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $sucursal->idSucursal,
                    'nombre' => $sucursal->Nombre,
                    'direccion' => $sucursal->Direccion ?? 'No definida',
                    'created_at' => $sucursal->created_at ? $sucursal->created_at->format('d/m/Y') : 'No disponible',
                    'empresa' => [
                        'id' => $sucursal->empresa->idEmpresas,
                        'nombre' => $sucursal->empresa->Nombre
                    ],
                    'empleados' => $sucursal->empleados->map(function($empleado) {
                        return [
                            'id' => $empleado->idEmpleado,
                            'nombre' => trim($empleado->Nombre . ' ' . ($empleado->Apellido ?? '')),
                            'correo' => $empleado->Correo ?? 'No definido',
                            'puesto' => $empleado->Puesto ?? 'No definido',
                            'departamento' => $empleado->Departamento ?? 'No definido',
                            'rfc' => $empleado->RFC ?? 'No definido',
                            'tipo_sangre' => $empleado->TipoSangre ?? 'No definido',
                            'numero_seguro_social' => $empleado->NumeroSeguroSocial ?? 'No definido',
                            'codigo_rh' => $empleado->CodigoRH ?? 'No definido',
                            'validado' => $empleado->Validado ? 'Sí' : 'No'
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener información de la sucursal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener información de un empleado
     */
    public function getEmpleado($id)
    {
        try {
            $empleado = Empleado::with(['sucursales.empresa'])->findOrFail($id);
            
            // Verificar si el empleado tiene sucursales asignadas
            if ($empleado->sucursales->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este empleado no tiene sucursales asignadas'
                ], 404);
            }
            
            // Tomar la primera sucursal como principal
            $sucursalPrincipal = $empleado->sucursales->first();
            
            // Verificar si el usuario tiene acceso a alguna sucursal de este empleado
            $user = auth()->user();
            if ($user->sucursales->count() > 0) {
                $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
                $sucursalesEmpleado = $empleado->sucursales->pluck('idSucursal')->toArray();
                
                if (empty(array_intersect($sucursalesUsuario, $sucursalesEmpleado))) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No tienes acceso a este empleado'
                    ], 403);
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $empleado->idEmpleado,
                    'nombre' => trim($empleado->Nombre . ' ' . ($empleado->Apellido ?? '')),
                    'email' => $empleado->Correo ?? 'No definido',
                    'telefono' => 'No disponible', // Campo no existe en BD
                    'direccion' => 'No disponible', // Campo no existe en BD
                    'fecha_nacimiento' => 'No disponible', // Campo no existe en BD
                    'puesto' => $empleado->Puesto ?? 'No definido',
                    'salario' => 'No disponible', // Campo no existe en BD
                    'fecha_ingreso' => 'No disponible', // Campo no existe en BD
                    'created_at' => $empleado->created_at ? $empleado->created_at->format('d/m/Y') : 'No disponible',
                    
                    // Campos adicionales de la BD
                    'tipo_sangre' => $empleado->TipoSangre ?? 'No definido',
                    'numero_seguro_social' => $empleado->NumeroSeguroSocial ?? 'No definido',
                    'codigo_rh' => $empleado->CodigoRH ?? 'No definido',
                    'departamento' => $empleado->Departamento ?? 'No definido',
                    'rfc' => $empleado->RFC ?? 'No definido',
                    'validado' => $empleado->Validado ? 'Sí' : 'No',
                    
                    'sucursal' => [
                        'id' => $sucursalPrincipal->idSucursal,
                        'nombre' => $sucursalPrincipal->Nombre
                    ],
                    'empresa' => [
                        'id' => $sucursalPrincipal->empresa->idEmpresas,
                        'nombre' => $sucursalPrincipal->empresa->Nombre
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener información del empleado: ' . $e->getMessage()
            ], 500);
        }
    }
}