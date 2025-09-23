<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perfil;
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
        return view('admin.usuarios.create', compact('perfiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'idPerfil' => 'nullable|exists:perfiles,idPerfil',
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'idPerfil' => $request->idPerfil,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show($id)
    {
        $usuario = User::with('perfil')->findOrFail($id);
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = User::with('perfil')->findOrFail($id);
        $perfiles = Perfil::where('activo', true)->get();
        return view('admin.usuarios.edit', compact('usuario', 'perfiles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'idPerfil' => 'nullable|exists:perfiles,idPerfil',
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
