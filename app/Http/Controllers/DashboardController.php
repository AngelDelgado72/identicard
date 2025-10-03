<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Sucursal;
use App\Models\Empleado;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        // Construir menús organizacionales dinámicos
        $menus = Menu::buildOrganizationalMenus();
        
        // También obtener empresas para estadísticas
        $user = auth()->user();
        $empresasQuery = Empresa::with(['sucursales.empleados']);
        
        if ($user->sucursales->count() > 0) {
            $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
            $empresasQuery->whereHas('sucursales', function($query) use ($sucursalesUsuario) {
                $query->whereIn('idSucursal', $sucursalesUsuario);
            });
        }
        
        $empresas = $empresasQuery->get();
        
        return view('dashboard', compact('empresas', 'menus'));
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

public function mostrarEmpresa($id)
{
    $user = auth()->user();
    $empresa = Empresa::with(['sucursales.empleados'])->findOrFail($id);
    
    // Verificar permisos - el usuario debe tener acceso a al menos una sucursal de esta empresa
    if ($user->sucursales->count() > 0) {
        $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
        $empresa->sucursales = $empresa->sucursales->whereIn('idSucursal', $sucursalesUsuario);
        
        // Si no tiene sucursales asignadas en esta empresa, denegar acceso
        if ($empresa->sucursales->isEmpty()) {
            abort(403, 'No tienes permisos para acceder a esta empresa.');
        }
    }
    
    return view('dashboard.empresa', compact('empresa'));
}

public function mostrarSucursal($id)
{
    $user = auth()->user();
    $sucursal = Sucursal::with(['empresa', 'empleados'])->findOrFail($id);
    
    // Verificar permisos - el usuario debe tener acceso a esta sucursal
    if ($user->sucursales->count() > 0 && !$user->puedeAccederSucursal($id)) {
        abort(403, 'No tienes permisos para acceder a esta sucursal.');
    }
    
    return view('dashboard.sucursal', compact('sucursal'));
}

public function getTreeData()
{
    $user = auth()->user();
    
    // Obtener empresas con datos estadísticos
    $empresasQuery = Empresa::with(['sucursales.empleados']);
    
    if ($user->sucursales->count() > 0) {
        $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
        $empresasQuery->whereHas('sucursales', function($query) use ($sucursalesUsuario) {
            $query->whereIn('idSucursal', $sucursalesUsuario);
        });
    }
    
    $empresas = $empresasQuery->get()->map(function($empresa) use ($user) {
        // Filtrar sucursales según permisos del usuario
        if ($user->sucursales->count() > 0) {
            $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
            $sucursalesVisibles = $empresa->sucursales->whereIn('idSucursal', $sucursalesUsuario);
        } else {
            $sucursalesVisibles = $empresa->sucursales;
        }
        
        return [
            'id' => $empresa->idEmpresas,
            'nombre' => $empresa->Nombre,
            'tipo' => 'empresa',
            'sucursales_count' => $sucursalesVisibles->count(),
            'empleados_count' => $sucursalesVisibles->sum(function($sucursal) {
                return $sucursal->empleados->count();
            }),
            'sucursales' => $sucursalesVisibles->map(function($sucursal) {
                return [
                    'id' => $sucursal->idSucursal,
                    'nombre' => $sucursal->Nombre,
                    'tipo' => 'sucursal',
                    'empleados_count' => $sucursal->empleados->count(),
                    'empleados' => $sucursal->empleados->map(function($empleado) {
                        return [
                            'id' => $empleado->idEmpleado,
                            'nombre' => $empleado->Nombre,
                            'departamento' => $empleado->Departamento,
                            'tipo' => 'empleado'
                        ];
                    })
                ];
            })
        ];
    });
    
    return response()->json($empresas);
}

public function getEmpresaSucursales($empresaId)
{
    $user = auth()->user();
    $empresa = Empresa::with(['sucursales.empleados'])->findOrFail($empresaId);
    
    // Verificar permisos - el usuario debe tener acceso a al menos una sucursal de esta empresa
    if ($user->sucursales->count() > 0) {
        $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
        $sucursalesVisibles = $empresa->sucursales->whereIn('idSucursal', $sucursalesUsuario);
        
        // Si no tiene sucursales asignadas en esta empresa, denegar acceso
        if ($sucursalesVisibles->isEmpty()) {
            abort(403, 'No tienes permisos para acceder a esta empresa.');
        }
    } else {
        $sucursalesVisibles = $empresa->sucursales;
    }
    
    $data = [
        'empresa' => [
            'id' => $empresa->idEmpresas,
            'nombre' => $empresa->Nombre,
            'rfc' => $empresa->RFC
        ],
        'sucursales' => $sucursalesVisibles->map(function($sucursal) {
            return [
                'id' => $sucursal->idSucursal,
                'nombre' => $sucursal->Nombre,
                'direccion' => $sucursal->Direccion,
                'empleados_count' => $sucursal->empleados->count()
            ];
        })->values()
    ];
    
    return response()->json($data);
}

public function getSucursalEmpleados($sucursalId)
{
    $user = auth()->user();
    $sucursal = Sucursal::with(['empresa', 'empleados'])->findOrFail($sucursalId);
    
    // Verificar permisos - el usuario debe tener acceso a esta sucursal
    if ($user->sucursales->count() > 0 && !$user->puedeAccederSucursal($sucursalId)) {
        abort(403, 'No tienes permisos para acceder a esta sucursal.');
    }
    
    $data = [
        'sucursal' => [
            'id' => $sucursal->idSucursal,
            'nombre' => $sucursal->Nombre,
            'direccion' => $sucursal->Direccion,
            'empresa_id' => $sucursal->idEmpresas
        ],
        'empleados' => $sucursal->empleados->map(function($empleado) {
            return [
                'id' => $empleado->idEmpleado,
                'nombre' => $empleado->Nombre,
                'apellido' => $empleado->Apellido,
                'puesto' => $empleado->Puesto,
                'departamento' => $empleado->Departamento,
                'correo' => $empleado->Correo
            ];
        })
    ];
    
    return response()->json($data);
}

}