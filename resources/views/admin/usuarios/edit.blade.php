<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Usuario: {{ $usuario->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('admin.usuarios.update', $usuario->id) }}">
                        @csrf
                        @method('PUT')

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
                                           value="{{ old('name', $usuario->name) }}"
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
                                           value="{{ old('email', $usuario->email) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nueva Contraseña (opcional)
                                    </label>
                                    <input type="password" 
                                           name="password" 
                                           id="password"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Dejar en blanco para mantener la contraseña actual.
                                    </p>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Confirmar Nueva Contraseña
                                    </label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>

                                <div>
                                    <label for="idPerfil" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Perfil/Rol
                                    </label>
                                    <select name="idPerfil" 
                                            id="idPerfil"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Sin perfil asignado</option>
                                        @foreach($perfiles as $perfil)
                                            <option value="{{ $perfil->idPerfil }}" 
                                                {{ old('idPerfil', $usuario->idPerfil) == $perfil->idPerfil ? 'selected' : '' }}>
                                                {{ $perfil->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idPerfil')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información actual del perfil -->
                        @if($usuario->perfil)
                            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                                <h4 class="text-md font-medium mb-2 text-green-800 dark:text-green-200">
                                    Perfil Actual: {{ $usuario->perfil->nombre }}
                                </h4>
                                <p class="text-sm text-green-700 dark:text-green-300 mb-2">
                                    {{ $usuario->perfil->descripcion ?? 'Sin descripción' }}
                                </p>
                                <p class="text-xs text-green-600 dark:text-green-400">
                                    Permisos activos: {{ $usuario->perfil->permisos->count() }}
                                </p>
                            </div>
                        @else
                            <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                                <h4 class="text-md font-medium mb-2 text-yellow-800 dark:text-yellow-200">
                                    ⚠️ Usuario sin perfil asignado
                                </h4>
                                <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                    Este usuario no tiene permisos específicos asignados.
                                </p>
                            </div>
                        @endif

                        <!-- Información importante -->
                        @if($usuario->id === auth()->id())
                            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                                <h4 class="text-md font-medium mb-2 text-blue-800 dark:text-blue-200">
                                    ℹ️ Editando tu propia cuenta
                                </h4>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    Ten cuidado al cambiar tu perfil, ya que podría afectar tus permisos actuales.
                                </p>
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
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>