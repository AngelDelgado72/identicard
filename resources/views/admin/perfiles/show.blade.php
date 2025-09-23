<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Perfil: {{ $perfil->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Información básica -->
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Información General</h3>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $perfil->nombre }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado:</dt>
                                        <dd class="text-sm">
                                            @if($perfil->activo)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Activo
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Inactivo
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Creado:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $perfil->created_at->format('d/m/Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Estadísticas</h3>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de permisos:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $perfil->permisos->count() }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuarios asignados:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $perfil->usuarios->count() }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Descripción</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $perfil->descripcion ?? 'Sin descripción' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Permisos asignados -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Permisos Asignados</h3>
                        
                        @if($perfil->permisos->count() > 0)
                            @foreach($perfil->permisos->groupBy('modulo') as $modulo => $permisos)
                                <div class="mb-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                                    <h4 class="text-md font-medium mb-3 text-gray-900 dark:text-gray-100 capitalize">
                                        {{ $modulo }}
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($permisos as $permiso)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                                {{ $permiso->accion }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 dark:text-gray-400 italic">No hay permisos asignados a este perfil.</p>
                        @endif
                    </div>

                    <!-- Usuarios asignados -->
                    @if($perfil->usuarios->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Usuarios con este Perfil</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($perfil->usuarios as $usuario)
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-700">
                                                    {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $usuario->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $usuario->email }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.perfiles.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Volver al Listado
                        </a>
                        <a href="{{ route('admin.perfiles.edit', $perfil->idPerfil) }}" 
                           class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>