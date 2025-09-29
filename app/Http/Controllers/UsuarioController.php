<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('perfil')->paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $perfiles = Perfil::where('activo', true)->get();
        $sucursales = Sucursal::with('empresa')->get();
        return view('admin.usuarios.create', compact('perfiles', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'idPerfil' => 'nullable|exists:perfiles,idPerfil',
            'sucursales' => 'nullable|array',
            'sucursales.*' => 'exists:sucursal,idSucursal',
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'idPerfil' => $request->idPerfil,
        ]);

        // Asignar sucursales al usuario
        if ($request->has('sucursales')) {
            $usuario->sucursales()->sync($request->sucursales);
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show($id)
    {
        $usuario = User::with(['perfil', 'sucursales.empresa'])->findOrFail($id);
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = User::with(['perfil', 'sucursales'])->findOrFail($id);
        $perfiles = Perfil::where('activo', true)->get();
        $sucursales = Sucursal::with('empresa')->get();
        return view('admin.usuarios.edit', compact('usuario', 'perfiles', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'idPerfil' => 'nullable|exists:perfiles,idPerfil',
            'sucursales' => 'nullable|array',
            'sucursales.*' => 'exists:sucursal,idSucursal',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'idPerfil' => $request->idPerfil,
        ];

        // Solo actualizar la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        // Actualizar sucursales asignadas
        if ($request->has('sucursales')) {
            $usuario->sucursales()->sync($request->sucursales);
        } else {
            $usuario->sucursales()->detach();
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        // Evitar que el usuario se elimine a sí mismo
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
