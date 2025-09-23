<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Nuevo Perfil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('admin.perfiles.store') }}">
                        @csrf

                        <!-- Información básica del perfil -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Información del Perfil</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nombre del Perfil
                                    </label>
                                    <input type="text" 
                                           name="nombre" 
                                           id="nombre" 
                                           value="{{ old('nombre') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('nombre')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="activo" 
                                               value="1"
                                               {{ old('activo', true) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Perfil activo</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Descripción
                                </label>
                                <textarea name="descripcion" 
                                          id="descripcion" 
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Permisos -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Permisos del Perfil</h3>
                            
                            @foreach($permisos as $modulo => $permisosModulo)
                                <div class="mb-6 p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                                    <h4 class="text-md font-medium mb-3 text-gray-900 dark:text-gray-100 capitalize">
                                        {{ $modulo }}
                                    </h4>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        @foreach($permisosModulo as $permiso)
                                            <label class="flex items-center">
                                                <input type="checkbox" 
                                                       name="permisos[]" 
                                                       value="{{ $permiso->idPermiso }}"
                                                       {{ in_array($permiso->idPermiso, old('permisos', [])) ? 'checked' : '' }}
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 capitalize">
                                                    {{ $permiso->accion }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            
                            @error('permisos')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.perfiles.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear Perfil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>