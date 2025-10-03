<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Sucursal;

class EmpleadoController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user();
        
        // Filtrar sucursales según las asignadas al usuario
        if ($user->sucursales->count() > 0) {
            $sucursales = $user->sucursales;
        } else {
            $sucursales = \App\Models\Sucursal::all();
        }
        
        $sucursalesSeleccionadas = [];
        
        // Si se pasa un parámetro sucursal, pre-seleccionarla
        if ($request->has('sucursal')) {
            $sucursalId = $request->get('sucursal');
            $sucursal = \App\Models\Sucursal::find($sucursalId);
            if ($sucursal) {
                $sucursalesSeleccionadas[] = $sucursalId;
            }
        }
        
        return view('empleados.create', compact('sucursales', 'sucursalesSeleccionadas'));
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
            'Firma' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'Foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sucursales' => 'required|array',
            'sucursales.*' => 'exists:sucursal,idSucursal',
        ]);

        $data = $request->except(['sucursales', 'Firma', 'Foto']);

        // Guardar Firma
        if ($request->hasFile('Firma')) {
            $firmaPath = $request->file('Firma')->store('firmas', 'public');
            $data['Firma'] = 'storage/' . $firmaPath;
        }

        // Guardar Foto
        if ($request->hasFile('Foto')) {
            $fotoPath = $request->file('Foto')->store('fotos', 'public');
            $data['Foto'] = 'storage/' . $fotoPath;
        }

        $empleado = Empleado::create($data);

        $empleado->sucursales()->attach($request->sucursales);

        return redirect()->route('empleados.crud')->with('success', 'Empleado registrado correctamente.');
    }

    public function edit($id)
    {
        $empleado = Empleado::with('sucursales')->findOrFail($id);
        
        // Prevenir edición si el empleado está validado
        if ($empleado->Validado) {
            return redirect()->route('empleados.show', $empleado->idEmpleado)
                ->with('error', 'No se puede editar un empleado validado.');
        }
        
        $todasSucursales = Sucursal::all();
        return view('empleados.edit', compact('empleado', 'todasSucursales'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        // Prevenir actualización si el empleado está validado
        if ($empleado->Validado) {
            return redirect()->route('empleados.show', $empleado->idEmpleado)
                ->with('error', 'No se puede editar un empleado validado.');
        }

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
            'Firma' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'Foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sucursales' => 'array',
            'sucursales.*' => 'exists:sucursal,idSucursal',
        ]);

        $data = $request->except(['sucursales', 'Firma', 'Foto']);

        // Actualizar Firma si se sube una nueva
        if ($request->hasFile('Firma')) {
            $firmaPath = $request->file('Firma')->store('firmas', 'public');
            $data['Firma'] = 'storage/' . $firmaPath;
        }

        // Actualizar Foto si se sube una nueva
        if ($request->hasFile('Foto')) {
            $fotoPath = $request->file('Foto')->store('fotos', 'public');
            $data['Foto'] = 'storage/' . $fotoPath;
        }

        $empleado->update($data);

        // Actualizar sucursales asociadas
        $empleado->sucursales()->sync($request->sucursales ?? []);

        return redirect()->route('empleados.crud')->with('success', 'Empleado actualizado correctamente.');
    }

    public function porSucursal($idSucursal)
    {
        $sucursal = Sucursal::findOrFail($idSucursal);
        $empleados = $sucursal->empleados()->with('sucursales')->paginate(10);

        return view('empleados.crud', compact('empleados', 'sucursal'));
    }

    public function show($id)
    {
        $empleado = Empleado::with('sucursales')->findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }

    public function validar(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        
        // Solo se puede validar si el empleado tiene todos los datos completos
        if ($empleado->status !== 'Completo') {
            return redirect()->route('empleados.show', $empleado->idEmpleado)
                ->with('error', 'No se puede validar un empleado con datos incompletos.');
        }
        
        $empleado->Validado = true;
        $empleado->save();

        return redirect()->route('empleados.show', $empleado->idEmpleado)
            ->with('success', 'Empleado validado correctamente.');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        
        // Eliminar las relaciones con sucursales
        $empleado->sucursales()->detach();
        
        // Eliminar el empleado
        $empleado->delete();

        return redirect()->route('empleados.crud')
            ->with('success', 'Empleado eliminado correctamente.');
    }


}