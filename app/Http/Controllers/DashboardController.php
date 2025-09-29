<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Sucursal;
use App\Models\Empleado;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function empresasCrud(Request $request)
    {
        $empresaQuery = Empresa::query();

        if ($request->filled('nombre')) {
            $empresaQuery->where('Nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('rfc')) {
            $empresaQuery->where('RFC', 'like', '%' . $request->rfc . '%');
        }

        $empresas = $empresaQuery->paginate(5, ['*'], 'empresas_page');

        return view('empresas.crud', compact('empresas'));
    }

    public function sucursalesCrud(Request $request, $empresa = null)
    {
        $user = auth()->user();
        $sucursalQuery = Sucursal::with('empresa');

        // Filtrar por sucursales asignadas al usuario
        if ($user->sucursales->count() > 0) {
            $sucursalesUsuario = $user->sucursales->pluck('idSucursal');
            $sucursalQuery->whereIn('sucursal.idSucursal', $sucursalesUsuario);
        }

        // Prioriza el parámetro de la URL (empresa), luego el filtro del formulario
        $empresaSeleccionada = $empresa ?? $request->empresa_sucursal;

        if ($empresaSeleccionada) {
            $sucursalQuery->where('idEmpresas', $empresaSeleccionada);
        }
        if ($request->filled('nombre_sucursal')) {
            $sucursalQuery->where('Nombre', 'like', '%' . $request->nombre_sucursal . '%');
        }

        $sucursales = $sucursalQuery->paginate(5, ['*'], 'sucursales_page');
        
        // Filtrar empresas disponibles basado en las sucursales del usuario
        if ($user->sucursales->count() > 0) {
            $empresasDisponibles = $user->sucursales->pluck('empresa')->unique('idEmpresas');
            $todasEmpresas = $empresasDisponibles;
        } else {
            $todasEmpresas = Empresa::all();
        }

        return view('sucursales.crud', compact('sucursales', 'todasEmpresas', 'empresaSeleccionada'));
    }

public function empleadosCrud(Request $request)
{
    $user = auth()->user();
    $empleadoQuery = Empleado::with('sucursales');

    // Filtrar empleados por sucursales asignadas al usuario
    if ($user->sucursales->count() > 0) {
        $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
        $empleadoQuery->whereHas('sucursales', function($subQuery) use ($sucursalesUsuario) {
            $subQuery->whereIn('empleado_sucursal.idSucursal', $sucursalesUsuario);
        });
    }

    if ($request->filled('nombre')) {
        $empleadoQuery->where('Nombre', 'like', '%' . $request->nombre . '%');
    }
    if ($request->filled('departamento')) {
        $empleadoQuery->where('Departamento', 'like', '%' . $request->departamento . '%');
    }
    if ($request->filled('rfc')) {
        $empleadoQuery->where('RFC', 'like', '%' . $request->rfc . '%');
    }

    $empleados = $empleadoQuery->paginate(5, ['*'], 'empleados_page');
    
    // Mostrar solo sucursales disponibles para el usuario
    if ($user->sucursales->count() > 0) {
        $todasSucursales = $user->sucursales;
    } else {
        $todasSucursales = Sucursal::all();
    }

    return view('empleados.crud', compact('empleados', 'todasSucursales'));
}

}