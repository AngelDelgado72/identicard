<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Usuario: {{ $usuario->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Información básica del usuario -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                                <span class="text-lg font-medium text-gray-700">
                                    {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $usuario->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ $usuario->email }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Información General</h4>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email verificado:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">
                                            @if($usuario->email_verified_at)
                                                <span class="text-green-600">✓ Verificado el {{ $usuario->email_verified_at->format('d/m/Y') }}</span>
                                            @else
                                                <span class="text-red-600">✗ No verificado</span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registrado:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $usuario->created_at->format('d/m/Y H:i') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última actualización:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $usuario->updated_at->format('d/m/Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Perfil Asignado</h4>
                                @if($usuario->perfil)
                                    <div class="p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                                        <h5 class="font-medium text-blue-800 dark:text-blue-200">{{ $usuario->perfil->nombre }}</h5>
                                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                            {{ $usuario->perfil->descripcion ?? 'Sin descripción' }}
                                        </p>
                                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">
                                            {{ $usuario->perfil->permisos->count() }} permisos activos
                                        </p>
                                        @if($usuario->perfil->activo)
                                            <span class="inline-block mt-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Perfil Activo</span>
                                        @else
                                            <span class="inline-block mt-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Perfil Inactivo</span>
                                        @endif
                                    </div>
                                @else
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                                        <p class="text-gray-600 dark:text-gray-400">Sin perfil asignado</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                            Este usuario no tiene permisos específicos.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Sucursales Asignadas</h4>
                                @if($usuario->sucursales->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($usuario->sucursales as $sucursal)
                                            <div class="p-3 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h5 class="font-medium text-green-800 dark:text-green-200">
                                                            🏢 {{ $sucursal->Nombre }}
                                                        </h5>
                                                        <p class="text-sm text-green-700 dark:text-green-300">
                                                            {{ $sucursal->empresa->Nombre ?? 'Sin empresa asignada' }}
                                                        </p>
                                                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                                                            📍 {{ $sucursal->Direccion ?? 'Sin dirección' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                                        <p class="text-yellow-800 dark:text-yellow-200 font-medium">⚠️ Sin sucursales asignadas</p>
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                            Este usuario tiene acceso a todas las sucursales del sistema.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Estado del Usuario</h4>
                                <div class="space-y-2">
                                    @if($usuario->id === auth()->id())
                                        <span class="inline-block px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                                            👤 Tu cuenta
                                        </span>
                                    @endif
                                    
                                    @if($usuario->perfil && $usuario->perfil->activo)
                                        <span class="inline-block px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full">
                                            ✅ Acceso habilitado
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">
                                            ⚠️ Acceso limitado
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permisos del usuario -->
                    @if($usuario->perfil && $usuario->perfil->permisos->count() > 0)
                        <div class="mb-8">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Permisos Asignados</h4>
                            
                            @foreach($usuario->perfil->permisos->groupBy('modulo') as $modulo => $permisos)
                                <div class="mb-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                                    <h5 class="text-md font-medium mb-3 text-gray-900 dark:text-gray-100 capitalize">
                                        📁 {{ $modulo }}
                                    </h5>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($permisos as $permiso)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                                                {{ $permiso->accion }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mb-8 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                            <h4 class="text-md font-medium mb-2 text-yellow-800 dark:text-yellow-200">
                                ⚠️ Sin permisos asignados
                            </h4>
                            <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                Este usuario no tiene permisos específicos. Asigna un perfil para otorgar acceso a funcionalidades.
                            </p>
                        </div>
                    @endif

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.usuarios.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Volver al Listado
                        </a>
                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" 
                           class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar Usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>