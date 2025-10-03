<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar nuevo empleado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 text-red-400">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('empleados.store') }}" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="Nombre" class="block text-sm font-medium text-white">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Apellido" class="block text-sm font-medium text-white">Apellido</label>
                    <input type="text" name="Apellido" id="Apellido" value="{{ old('Apellido') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Correo" class="block text-sm font-medium text-white">Correo</label>
                    <input type="email" name="Correo" id="Correo" value="{{ old('Correo') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="TipoSangre" class="block text-sm font-medium text-white">Tipo de Sangre</label>
                    <input type="text" name="TipoSangre" id="TipoSangre" value="{{ old('TipoSangre') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="NumeroSeguroSocial" class="block text-sm font-medium text-white">Número de Seguro Social</label>
                    <input type="text" name="NumeroSeguroSocial" id="NumeroSeguroSocial" value="{{ old('NumeroSeguroSocial') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="CodigoRH" class="block text-sm font-medium text-white">Código RH</label>
                    <input type="text" name="CodigoRH" id="CodigoRH" value="{{ old('CodigoRH') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Puesto" class="block text-sm font-medium text-white">Puesto</label>
                    <input type="text" name="Puesto" id="Puesto" value="{{ old('Puesto') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Departamento" class="block text-sm font-medium text-white">Departamento</label>
                    <input type="text" name="Departamento" id="Departamento" value="{{ old('Departamento') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="RFC" class="block text-sm font-medium text-white">RFC</label>
                    <input type="text" name="RFC" id="RFC" value="{{ old('RFC') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Firma" class="block text-sm font-medium text-white">Firma</label>
                    <input type="file" name="Firma" id="Firma" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Foto" class="block text-sm font-medium text-white">Foto</label>
                    <input type="file" name="Foto" id="Foto" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">Sucursales</label>
                    <div class="space-y-2">
                        @foreach($sucursales as $sucursal)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="sucursales[]" 
                                       id="sucursal_{{ $sucursal->idSucursal }}" 
                                       value="{{ $sucursal->idSucursal }}"
                                       {{ (in_array($sucursal->idSucursal, old('sucursales', $sucursalesSeleccionadas ?? []))) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="sucursal_{{ $sucursal->idSucursal }}" class="ml-2 block text-sm text-white">
                                    {{ $sucursal->Nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-gray-400 mt-1 block">Selecciona una o más sucursales para este empleado.</small>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Registrar empleado</button>
            </form>
        </div>
    </div>
</x-app-layout>