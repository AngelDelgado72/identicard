<?php

namespace App\Http\Controllers;

use App\Models\PlantillaCredencial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlantillaCredencialController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermission('plantillas', 'ver')) {
            abort(403, 'No tienes permiso para ver plantillas.');
        }

        $plantillas = PlantillaCredencial::latest()->get();
        return view('plantillas.index', compact('plantillas'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('plantillas', 'crear')) {
            abort(403, 'No tienes permiso para crear plantillas.');
        }

        return view('plantillas.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('plantillas', 'crear')) {
            abort(403, 'No tienes permiso para crear plantillas.');
        }

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
        if (!auth()->user()->hasPermission('plantillas', 'editar')) {
            abort(403, 'No tienes permiso para editar plantillas.');
        }

        $camposDisponibles = $this->getCamposDisponibles();
        return view('plantillas.edit', compact('plantilla', 'camposDisponibles'));
    }

    public function update(Request $request, PlantillaCredencial $plantilla)
    {
        if (!auth()->user()->hasPermission('plantillas', 'editar')) {
            abort(403, 'No tienes permiso para editar plantillas.');
        }

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
        if (!auth()->user()->hasPermission('plantillas', 'eliminar')) {
            abort(403, 'No tienes permiso para eliminar plantillas.');
        }

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
        if (!auth()->user()->hasPermission('plantillas', 'activar')) {
            abort(403, 'No tienes permiso para activar plantillas.');
        }

        PlantillaCredencial::where('id', '!=', $plantilla->id)->update(['activa' => false]);
        $plantilla->update(['activa' => true]);

        return redirect()->route('plantillas.index')
            ->with('success', 'Plantilla activada exitosamente');
    }

    private function getCamposDisponibles()
    {
        return [
            [
                'id' => 'foto', 
                'nombre' => 'Foto', 
                'tipo' => 'imagen', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" /></svg>'
            ],
            [
                'id' => 'nombre', 
                'nombre' => 'Nombre Completo', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>'
            ],
            [
                'id' => 'puesto', 
                'nombre' => 'Puesto', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" /></svg>'
            ],
            [
                'id' => 'departamento', 
                'nombre' => 'Departamento', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" /></svg>'
            ],
            [
                'id' => 'rfc', 
                'nombre' => 'RFC', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" /></svg>'
            ],
            [
                'id' => 'nss', 
                'nombre' => 'NSS', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>'
            ],
            [
                'id' => 'correo', 
                'nombre' => 'Correo', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>'
            ],
            [
                'id' => 'telefono', 
                'nombre' => 'Teléfono', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>'
            ],
            [
                'id' => 'tipo_sangre', 
                'nombre' => 'Tipo de Sangre', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" /></svg>'
            ],
            [
                'id' => 'codigo_rh', 
                'nombre' => 'Código RH', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" /></svg>'
            ],
            [
                'id' => 'sucursales', 
                'nombre' => 'Sucursales', 
                'tipo' => 'texto', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>'
            ],
            [
                'id' => 'firma', 
                'nombre' => 'Firma', 
                'tipo' => 'imagen', 
                'icono' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>'
            ],
        ];
    }
}