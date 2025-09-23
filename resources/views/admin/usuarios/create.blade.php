<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Nuevo Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('admin.usuarios.store') }}">
                        @csrf

                        <!-- Información del usuario -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Información del Usuario</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nombre Completo
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Correo Electrónico
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Contraseña
                                    </label>
                                    <input type="password" 
                                           name="password" 
                                           id="password"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Confirmar Contraseña
                                    </label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                </div>

                                <div>
                                    <label for="idPerfil" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Perfil/Rol
                                    </label>
                                    <select name="idPerfil" 
                                            id="idPerfil"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Seleccionar perfil (opcional)</option>
                                        @foreach($perfiles as $perfil)
                                            <option value="{{ $perfil->idPerfil }}" {{ old('idPerfil') == $perfil->idPerfil ? 'selected' : '' }}>
                                                {{ $perfil->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idPerfil')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        El perfil determina qué permisos tendrá el usuario en el sistema.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Información sobre perfiles disponibles -->
                        @if($perfiles->count() > 0)
                            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                                <h4 class="text-md font-medium mb-2 text-blue-800 dark:text-blue-200">
                                    Perfiles Disponibles
                                </h4>
                                <div class="space-y-2">
                                    @foreach($perfiles as $perfil)
                                        <div class="text-sm text-blue-700 dark:text-blue-300">
                                            <strong>{{ $perfil->nombre }}</strong>: {{ $perfil->descripcion ?? 'Sin descripción' }}
                                            <span class="text-xs">({{ $perfil->permisos->count() }} permisos)</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Botones -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.usuarios.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>