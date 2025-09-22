<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar empleado
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg">
        <form method="POST" action="{{ route('empleados.update', $empleado->idEmpleado) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-white">Nombre</label>
                <input type="text" name="Nombre" value="{{ old('Nombre', $empleado->Nombre) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" required maxlength="100">
            </div>
            <div class="mb-4">
                <label class="block text-white">Apellido</label>
                <input type="text" name="Apellido" value="{{ old('Apellido', $empleado->Apellido) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" required maxlength="100">
            </div>
            <div class="mb-4">
                <label class="block text-white">Correo</label>
                <input type="email" name="Correo" value="{{ old('Correo', $empleado->Correo) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" maxlength="120">
            </div>
            <div class="mb-4">
                <label class="block text-white">Tipo de Sangre</label>
                <input type="text" name="TipoSangre" value="{{ old('TipoSangre', $empleado->TipoSangre) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" maxlength="5">
            </div>
            <div class="mb-4">
                <label class="block text-white">Número Seguro Social</label>
                <input type="text" name="NumeroSeguroSocial" value="{{ old('NumeroSeguroSocial', $empleado->NumeroSeguroSocial) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" maxlength="20">
            </div>
            <div class="mb-4">
                <label class="block text-white">Código RH</label>
                <input type="text" name="CodigoRH" value="{{ old('CodigoRH', $empleado->CodigoRH) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" maxlength="10">
            </div>
            <div class="mb-4">
                <label class="block text-white">Departamento</label>
                <input type="text" name="Departamento" value="{{ old('Departamento', $empleado->Departamento) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" maxlength="100">
            </div>
            <div class="mb-4">
                <label class="block text-white">RFC</label>
                <input type="text" name="RFC" value="{{ old('RFC', $empleado->RFC) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" maxlength="20">
            </div>
            <div class="mb-4">
                <label class="block text-white">Puesto</label>
                <input type="text" name="Puesto" value="{{ old('Puesto', $empleado->Puesto) }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white" maxlength="100">
            </div>
            <div class="mb-4">
                <label class="block text-white">Firma actual</label>
                @if($empleado->Firma)
                    <img src="{{ asset($empleado->Firma) }}" alt="Firma" class="h-12 w-12 object-contain rounded border border-gray-600 bg-white mb-2">
                @else
                    <span class="text-gray-400 block mb-2">Sin firma</span>
                @endif
                <input type="file" name="Firma" accept="image/*" class="w-full px-3 py-2 rounded bg-gray-700 text-white">
                <small class="text-gray-400">Si seleccionas una nueva imagen, se reemplazará la actual.</small>
            </div>
            <div class="mb-4">
                <label class="block text-white">Foto actual</label>
                @if($empleado->Foto)
                    <img src="{{ asset($empleado->Foto) }}" alt="Foto" class="h-12 w-12 object-cover rounded border border-gray-600 mb-2">
                @else
                    <span class="text-gray-400 block mb-2">Sin foto</span>
                @endif
                <input type="file" name="Foto" accept="image/*" class="w-full px-3 py-2 rounded bg-gray-700 text-white">
                <small class="text-gray-400">Si seleccionas una nueva imagen, se reemplazará la actual.</small>
            </div>
            <div class="mb-4">
                <label class="block text-white">Sucursales</label>
                <select name="sucursales[]" multiple class="w-full px-3 py-2 rounded bg-gray-700 text-white">
                    @foreach($todasSucursales as $sucursal)
                        <option value="{{ $sucursal->idSucursal }}"
                            {{ $empleado->sucursales->contains($sucursal->idSucursal) ? 'selected' : '' }}>
                            {{ $sucursal->Nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
            <a href="{{ route('empleados.crud') }}" class="ml-2 text-gray-400">Cancelar</a>
        </form>
    </div>
</x-app-layout>