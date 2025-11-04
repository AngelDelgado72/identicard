<?php

namespace App\Http\Controllers;

use App\Models\PlantillaCredencial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlantillaCredencialController extends Controller
{
    public function index()
    {
        $plantillas = PlantillaCredencial::latest()->get();
        return view('plantillas.index', compact('plantillas'));
    }

    public function create()
    {
        return view('plantillas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen_frontal' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'imagen_trasera' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'ancho_mm' => 'required|integer|min:50',
            'alto_mm' => 'required|integer|min:50',
        ]);

        $data = $request->only(['nombre', 'ancho_mm', 'alto_mm']);

        if ($request->hasFile('imagen_frontal')) {
            $data['imagen_frontal'] = $request->file('imagen_frontal')->store('plantillas', 'public');
        }

        if ($request->hasFile('imagen_trasera')) {
            $data['imagen_trasera'] = $request->file('imagen_trasera')->store('plantillas', 'public');
        }

        // Si es la primera plantilla, activarla automáticamente
        if (PlantillaCredencial::count() === 0) {
            $data['activa'] = true;
        }

        $plantilla = PlantillaCredencial::create($data);

        return redirect()->route('plantillas.edit', $plantilla)
            ->with('success', 'Plantilla creada. Ahora configura la posición de los campos.');
    }

    public function edit(PlantillaCredencial $plantilla)
    {
        $camposDisponibles = $this->getCamposDisponibles();
        return view('plantillas.edit', compact('plantilla', 'camposDisponibles'));
    }

    public function update(Request $request, PlantillaCredencial $plantilla)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ancho_mm' => 'required|integer|min:50',
            'alto_mm' => 'required|integer|min:50',
            'campos_frontal' => 'nullable',
            'campos_trasera' => 'nullable',
            'activa' => 'nullable|boolean'
        ]);

        $data = $request->only(['nombre', 'ancho_mm', 'alto_mm']);
        $data['activa'] = $request->has('activa');

        if ($request->has('campos_frontal')) {
            $data['campos_frontal'] = json_decode($request->campos_frontal, true);
        }

        if ($request->has('campos_trasera')) {
            $data['campos_trasera'] = json_decode($request->campos_trasera, true);
        }

        if ($request->hasFile('imagen_frontal')) {
            if ($plantilla->imagen_frontal) {
                Storage::disk('public')->delete($plantilla->imagen_frontal);
            }
            $data['imagen_frontal'] = $request->file('imagen_frontal')->store('plantillas', 'public');
        }

        if ($request->hasFile('imagen_trasera')) {
            if ($plantilla->imagen_trasera) {
                Storage::disk('public')->delete($plantilla->imagen_trasera);
            }
            $data['imagen_trasera'] = $request->file('imagen_trasera')->store('plantillas', 'public');
        }

        $plantilla->update($data);

        return redirect()->route('plantillas.index')
            ->with('success', 'Plantilla actualizada exitosamente');
    }

    public function destroy(PlantillaCredencial $plantilla)
    {
        if ($plantilla->imagen_frontal) {
            Storage::disk('public')->delete($plantilla->imagen_frontal);
        }
        if ($plantilla->imagen_trasera) {
            Storage::disk('public')->delete($plantilla->imagen_trasera);
        }

        $plantilla->delete();

        return redirect()->route('plantillas.index')
            ->with('success', 'Plantilla eliminada exitosamente');
    }

    public function activar(PlantillaCredencial $plantilla)
    {
        PlantillaCredencial::where('id', '!=', $plantilla->id)->update(['activa' => false]);
        $plantilla->update(['activa' => true]);

        return redirect()->route('plantillas.index')
            ->with('success', 'Plantilla activada exitosamente');
    }

    private function getCamposDisponibles()
    {
        return [
            ['id' => 'foto', 'nombre' => 'Foto', 'tipo' => 'imagen', 'icono' => '📷'],
            ['id' => 'nombre', 'nombre' => 'Nombre Completo', 'tipo' => 'texto', 'icono' => '👤'],
            ['id' => 'puesto', 'nombre' => 'Puesto', 'tipo' => 'texto', 'icono' => '💼'],
            ['id' => 'departamento', 'nombre' => 'Departamento', 'tipo' => 'texto', 'icono' => '🏢'],
            ['id' => 'rfc', 'nombre' => 'RFC', 'tipo' => 'texto', 'icono' => '🆔'],
            ['id' => 'nss', 'nombre' => 'NSS', 'tipo' => 'texto', 'icono' => '📋'],
            ['id' => 'correo', 'nombre' => 'Correo', 'tipo' => 'texto', 'icono' => '📧'],
            ['id' => 'tipo_sangre', 'nombre' => 'Tipo de Sangre', 'tipo' => 'texto', 'icono' => '🩸'],
            ['id' => 'codigo_rh', 'nombre' => 'Código RH', 'tipo' => 'texto', 'icono' => '🔢'],
            ['id' => 'sucursales', 'nombre' => 'Sucursales', 'tipo' => 'texto', 'icono' => '🏪'],
            ['id' => 'firma', 'nombre' => 'Firma', 'tipo' => 'imagen', 'icono' => '✍️'],
        ];
    }
}
