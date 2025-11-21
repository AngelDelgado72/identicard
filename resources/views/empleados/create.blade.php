<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar nuevo empleado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 bg-red-900/50 border border-red-600 text-red-400 p-4 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('empleados.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Grid de 2 columnas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Columna 1 -->
                            <div class="space-y-4">
                                <div>
                                    <label for="Nombre" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Nombre <span class="text-red-500">*</span></label>
                                    <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre') }}" required 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="Apellido" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Apellido <span class="text-red-500">*</span></label>
                                    <input type="text" name="Apellido" id="Apellido" value="{{ old('Apellido') }}" required 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="Correo" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Correo</label>
                                    <input type="email" name="Correo" id="Correo" value="{{ old('Correo') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="Telefono" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Teléfono</label>
                                    <input type="text" name="Telefono" id="Telefono" value="{{ old('Telefono') }}" maxlength="20" 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="TipoSangre" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Tipo de Sangre</label>
                                    <input type="text" name="TipoSangre" id="TipoSangre" value="{{ old('TipoSangre') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="NumeroSeguroSocial" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Número de Seguro Social</label>
                                    <input type="text" name="NumeroSeguroSocial" id="NumeroSeguroSocial" value="{{ old('NumeroSeguroSocial') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            
                            <!-- Columna 2 -->
                            <div class="space-y-4">
                                <div>
                                    <label for="CodigoRH" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Código RH</label>
                                    <input type="text" name="CodigoRH" id="CodigoRH" value="{{ old('CodigoRH') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="Puesto" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Puesto</label>
                                    <input type="text" name="Puesto" id="Puesto" value="{{ old('Puesto') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="Departamento" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Departamento</label>
                                    <input type="text" name="Departamento" id="Departamento" value="{{ old('Departamento') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="RFC" class="block text-sm font-medium text-gray-200 dark:text-gray-200">RFC</label>
                                    <input type="text" name="RFC" id="RFC" value="{{ old('RFC') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="Firma" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Firma</label>
                                    <input type="file" name="Firma" id="Firma" accept="image/*" 
                                           class="mt-1 block w-full text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                </div>
                                
                                <div>
                                    <label for="Foto" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Foto</label>
                                    <input type="file" name="Foto" id="Foto" accept="image/*" 
                                           class="mt-1 block w-full text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sucursales - Ancho completo -->
                        <div class="mt-6 p-4 bg-gray-700 rounded-lg">
                            <label class="block text-sm font-medium text-gray-200 mb-3">Sucursales <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                @foreach($sucursales as $sucursal)
                                    <div class="flex items-center p-2 hover:bg-gray-600 rounded">
                                        <input type="checkbox" 
                                               name="sucursales[]" 
                                               id="sucursal_{{ $sucursal->idSucursal }}" 
                                               value="{{ $sucursal->idSucursal }}"
                                               {{ (in_array($sucursal->idSucursal, old('sucursales', $sucursalesSeleccionadas ?? []))) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="sucursal_{{ $sucursal->idSucursal }}" class="ml-2 block text-sm text-gray-200 cursor-pointer">
                                            {{ $sucursal->Nombre }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-gray-400 mt-2 block">Selecciona una o más sucursales para este empleado.</small>
                        </div>
                        
                        <!-- Botones -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('empleados.crud') }}" 
                               class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 text-white rounded-md hover:opacity-80 transition"
                                    style="background-color: #919090;">
                                Registrar empleado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>