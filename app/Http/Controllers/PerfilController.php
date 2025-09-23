<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perfil;
use App\Models\Permiso;

class PerfilController extends Controller
{
    public function index()
    {
        $perfiles = Perfil::with('permisos')->paginate(10);
        return view('admin.perfiles.index', compact('perfiles'));
    }

    public function create()
    {
        $permisos = Permiso::all()->groupBy('modulo');
        return view('admin.perfiles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:perfiles,nombre',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
            'permisos' => 'array',
            'permisos.*' => 'exists:permisos,idPermiso',
        ]);

        $perfil = Perfil::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->has('activo'),
        ]);

        if ($request->has('permisos')) {
            $perfil->permisos()->attach($request->permisos);
        }

        return redirect()->route('admin.perfiles.index')
            ->with('success', 'Perfil creado correctamente.');
    }

    public function show($id)
    {
        $perfil = Perfil::with('permisos', 'usuarios')->findOrFail($id);
        return view('admin.perfiles.show', compact('perfil'));
    }

    public function edit($id)
    {
        $perfil = Perfil::with('permisos')->findOrFail($id);
        $permisos = Permiso::all()->groupBy('modulo');
        return view('admin.perfiles.edit', compact('perfil', 'permisos'));
    }

    public function update(Request $request, $id)
    {
        $perfil = Perfil::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100|unique:perfiles,nombre,' . $id . ',idPerfil',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
            'permisos' => 'array',
            'permisos.*' => 'exists:permisos,idPermiso',
        ]);

        $perfil->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->has('activo'),
        ]);

        $perfil->permisos()->sync($request->permisos ?? []);

        return redirect()->route('admin.perfiles.index')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroy($id)
    {
        $perfil = Perfil::findOrFail($id);

        // Verificar si hay usuarios asignados a este perfil
        if ($perfil->usuarios()->count() > 0) {
            return redirect()->route('admin.perfiles.index')
                ->with('error', 'No se puede eliminar el perfil porque tiene usuarios asignados.');
        }

        $perfil->permisos()->detach();
        $perfil->delete();

        return redirect()->route('admin.perfiles.index')
            ->with('success', 'Perfil eliminado correctamente.');
    }
}
