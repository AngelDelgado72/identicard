<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
            public function store(Request $request)
        {
            $request->validate([
                'Nombre' => 'required|string|max:255',
                'RFC' => 'required|string|max:20|unique:empresas,RFC',
                'Direccion' => 'nullable|string|max:255',
            ]);
            \App\Models\Empresa::create($request->all());

            return redirect()->route('dashboard')->with('success', 'Empresa registrada correctamente.');
        }

        public function edit($id)
        {
            $empresa = \App\Models\Empresa::findOrFail($id);
            return view('empresas.edit', compact('empresa'));
        }


        public function update(Request $request, $id)
        {
            $empresa = \App\Models\Empresa::findOrFail($id);

            $request->validate([
                'Nombre' => 'required|string|max:255',
                'RFC' => 'required|string|max:20|unique:empresas,RFC,' . $id . ',idEmpresas',
                'Direccion' => 'nullable|string|max:255',
            ]);

            $empresa->update($request->all());

            return redirect()->route('dashboard')->with('success', 'Empresa actualizada correctamente.');
        }

        public function destroy($id)
        {
            $empresa = \App\Models\Empresa::findOrFail($id);
            $empresa->delete();

            return redirect()->route('dashboard')->with('success', 'Empresa eliminada correctamente.');
        }
}
