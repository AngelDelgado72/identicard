<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function create()
    {
        $empresas = \App\Models\Empresa::all();
        return view('sucursales.create', compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idEmpresas' => 'required|exists:empresas,idEmpresas',
            'Nombre' => 'required|string|max:255',
            'Direccion' => 'nullable|string|max:255',
        ]);

        \App\Models\Sucursal::create([
            'idEmpresas' => $request->idEmpresas,
            'Nombre' => $request->Nombre,
            'Direccion' => $request->Direccion,
        ]);

        return redirect()->route('dashboard')->with('success', 'Sucursal registrada correctamente.');
    }

        public function edit($id)
    {
        $sucursal = \App\Models\Sucursal::findOrFail($id);
        $empresas = \App\Models\Empresa::all();
        return view('sucursales.edit', compact('sucursal', 'empresas'));
    }

        public function update(Request $request, $id)
    {
        $sucursal = \App\Models\Sucursal::findOrFail($id);

        $request->validate([
            'idEmpresas' => 'required|exists:empresas,idEmpresas',
            'Nombre' => 'required|string|max:255',
            'Direccion' => 'nullable|string|max:255',
        ]);

        $sucursal->update([
            'idEmpresas' => $request->idEmpresas,
            'Nombre' => $request->Nombre,
            'Direccion' => $request->Direccion,
        ]);

        return redirect()->route('dashboard')->with('success', 'Sucursal actualizada correctamente.');
    }
}
