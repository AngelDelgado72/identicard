<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Sucursal;

class EmpleadoController extends Controller
{
    public function create()
    {
        $sucursales = Sucursal::all();
        return view('empleados.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
            'Correo' => 'nullable|email|max:120',
            'TipoSangre' => 'nullable|string|max:5',
            'NumeroSeguroSocial' => 'nullable|string|max:20',
            'CodigoRH' => 'nullable|string|max:10',
            'Puesto' => 'nullable|string|max:100',
            'Departamento' => 'nullable|string|max:100',
            'RFC' => 'nullable|string|max:20',
            'Firma' => 'nullable|string|max:255',
            'Foto' => 'nullable|string|max:255',
            'sucursales' => 'required|array',
            'sucursales.*' => 'exists:sucursal,idSucursal',
        ]);

        // Crear el empleado sin idSucursal
        $empleado = Empleado::create($request->except('sucursales'));

        // Relacionar el empleado con las sucursales seleccionadas
        $empleado->sucursales()->attach($request->sucursales);


        return redirect()->route('empleados.crud')->with('success', 'Empleado registrado correctamente.');
    }
}