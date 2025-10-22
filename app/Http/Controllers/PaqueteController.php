<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paquete;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaqueteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Paquete::with(['creador', 'empleados']);
        
        // Filtro por nombre
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }
        
        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_creacion', $request->fecha);
        }
        
        // Filtro por estatus
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }
        
        $paquetes = $query->latest()->get();
        
        return view('paquetes.index', compact('paquetes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleados = Empleado::with('sucursales')->get();
        
        // Obtener puestos únicos para el filtro
        $puestos = Empleado::whereNotNull('Puesto')
                          ->where('Puesto', '!=', '')
                          ->distinct()
                          ->pluck('Puesto')
                          ->sort()
                          ->values();
        
        return view('paquetes.create', compact('empleados', 'puestos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_creacion' => 'required|date',
            'empleados' => 'required|array|min:1',
            'empleados.*' => 'exists:empleados,idEmpleado'
        ]);

        $paquete = Paquete::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_creacion' => $request->fecha_creacion,
            'estatus' => 'en_creacion',
            'creado_por' => Auth::id()
        ]);

        // Asociar empleados al paquete
        $paquete->empleados()->attach($request->empleados);

        return redirect()->route('paquetes.index')
            ->with('success', 'Paquete creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paquete = Paquete::with(['creador', 'empleados.sucursales'])->findOrFail($id);
        return view('paquetes.show', compact('paquete'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paquete = Paquete::findOrFail($id);
        
        if (!$paquete->puedeSerEditado()) {
            return redirect()->route('paquetes.index')
                ->with('error', 'No se puede editar un paquete confirmado o autorizado.');
        }

        $empleados = Empleado::with('sucursales')->get();
        
        // Obtener puestos únicos para el filtro
        $puestos = Empleado::whereNotNull('Puesto')
                          ->where('Puesto', '!=', '')
                          ->distinct()
                          ->pluck('Puesto')
                          ->sort()
                          ->values();
        
        $paquete->load('empleados');
        return view('paquetes.edit', compact('paquete', 'empleados', 'puestos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $paquete = Paquete::findOrFail($id);
        
        if (!$paquete->puedeSerEditado()) {
            return redirect()->route('paquetes.index')
                ->with('error', 'No se puede editar un paquete confirmado o autorizado.');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_creacion' => 'required|date',
            'empleados' => 'required|array|min:1',
            'empleados.*' => 'exists:empleados,idEmpleado'
        ]);

        $paquete->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_creacion' => $request->fecha_creacion,
        ]);

        // Sincronizar empleados
        $paquete->empleados()->sync($request->empleados);

        return redirect()->route('paquetes.index')
            ->with('success', 'Paquete actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paquete = Paquete::findOrFail($id);
        
        if (!$paquete->puedeSerEditado()) {
            return redirect()->route('paquetes.index')
                ->with('error', 'No se puede eliminar un paquete confirmado o autorizado.');
        }

        $paquete->empleados()->detach();
        $paquete->delete();

        return redirect()->route('paquetes.index')
            ->with('success', 'Paquete eliminado exitosamente.');
    }

    /**
     * Confirmar un paquete
     */
    public function confirmar($id)
    {
        $paquete = Paquete::findOrFail($id);
        
        if ($paquete->estatus === 'confirmado') {
            return redirect()->route('paquetes.index')
                ->with('error', 'El paquete ya está confirmado.');
        }

        if ($paquete->estatus === 'autorizado') {
            return redirect()->route('paquetes.index')
                ->with('error', 'El paquete ya está autorizado.');
        }

        $paquete->update(['estatus' => 'confirmado']);

        return redirect()->route('paquetes.index')
            ->with('success', 'Paquete confirmado exitosamente.');
    }

    /**
     * Autorizar un paquete
     */
    public function autorizar($id)
    {
        $paquete = Paquete::with('empleados')->findOrFail($id);
        
        if ($paquete->estatus === 'autorizado') {
            return redirect()->route('paquetes.index')
                ->with('error', 'El paquete ya está autorizado.');
        }

        if ($paquete->estatus !== 'confirmado') {
            return redirect()->route('paquetes.index')
                ->with('error', 'Solo se pueden autorizar paquetes confirmados.');
        }

        if (!$paquete->todosEmpleadosValidados()) {
            return redirect()->route('paquetes.index')
                ->with('error', 'No se puede autorizar el paquete. Todos los empleados deben estar validados.');
        }

        $paquete->update(['estatus' => 'autorizado']);

        return redirect()->route('paquetes.index')
            ->with('success', 'Paquete autorizado exitosamente.');
    }

    /**
     * Agregar empleado a paquete
     */
    public function agregarEmpleado(Request $request, $id)
    {
        $paquete = Paquete::findOrFail($id);
        
        if (!$paquete->puedeSerEditado()) {
            return response()->json(['error' => 'No se puede modificar un paquete confirmado o autorizado.'], 400);
        }

        $request->validate([
            'idEmpleado' => 'required|exists:empleados,idEmpleado'
        ]);

        if (!$paquete->empleados->contains($request->idEmpleado)) {
            $paquete->empleados()->attach($request->idEmpleado);
            return response()->json(['success' => 'Empleado agregado al paquete.']);
        }

        return response()->json(['error' => 'El empleado ya está en el paquete.'], 400);
    }

    /**
     * Remover empleado del paquete
     */
    public function removerEmpleado($id, $idEmpleado)
    {
        $paquete = Paquete::findOrFail($id);
        
        if (!$paquete->puedeSerEditado()) {
            return response()->json(['error' => 'No se puede modificar un paquete confirmado o autorizado.'], 400);
        }

        $paquete->empleados()->detach($idEmpleado);
        return response()->json(['success' => 'Empleado removido del paquete.']);
    }
}
