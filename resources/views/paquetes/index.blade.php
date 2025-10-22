<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Paquetes de Impresión') }}
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Paquetes de Impresión</h1>
        @if(auth()->user()->hasPermission('paquetes', 'crear'))
            <a href="{{ route('paquetes.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Nuevo Paquete
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtros de búsqueda -->
    <div class="mb-6 bg-gray-800 shadow-md rounded-lg p-4 border border-gray-600">
        <form method="GET" action="{{ route('paquetes.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <label for="buscar" class="block text-sm font-medium text-gray-300 mb-1">Buscar por nombre</label>
                <input type="text" 
                       name="buscar" 
                       id="buscar" 
                       value="{{ request('buscar') }}"
                       placeholder="Buscar paquete por nombre..."
                       class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            </div>
            
            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-300 mb-1">Filtrar por fecha</label>
                <input type="date" 
                       name="fecha" 
                       id="fecha" 
                       value="{{ request('fecha') }}"
                       class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            </div>
            
            <div>
                <label for="estatus" class="block text-sm font-medium text-gray-300 mb-1">Filtrar por estatus</label>
                <select name="estatus" 
                        id="estatus" 
                        class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                    <option value="">Todos los estatus</option>
                    <option value="en_creacion" {{ request('estatus') == 'en_creacion' ? 'selected' : '' }}>En Creación</option>
                    <option value="confirmado" {{ request('estatus') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="autorizado" {{ request('estatus') == 'autorizado' ? 'selected' : '' }}>Autorizado</option>
                </select>
            </div>
            
            <div class="flex items-end space-x-2">
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Buscar
                </button>
                <a href="{{ route('paquetes.index') }}" 
                   class="px-4 py-2 border border-gray-600 text-gray-300 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Mensaje de resultados -->
    @if(request()->hasAny(['buscar', 'fecha', 'estatus']))
        <div class="mb-4 bg-blue-900 border border-blue-600 text-blue-200 px-4 py-3 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>
                    Se {{ $paquetes->count() === 1 ? 'encontró' : 'encontraron' }} <strong>{{ $paquetes->count() }}</strong> {{ $paquetes->count() === 1 ? 'paquete' : 'paquetes' }}
                    @if(request('buscar'))
                        con el nombre "<strong>{{ request('buscar') }}</strong>"
                    @endif
                    @if(request('fecha'))
                        {{ request('buscar') ? 'y' : '' }} con fecha "<strong>{{ \Carbon\Carbon::parse(request('fecha'))->format('d/m/Y') }}</strong>"
                    @endif
                    @if(request('estatus'))
                        {{ request('buscar') || request('fecha') ? 'y' : '' }} con estatus "<strong>{{ ucfirst(str_replace('_', ' ', request('estatus'))) }}</strong>"
                    @endif
                </span>
            </div>
        </div>
    @endif

    <!-- Grid de Tarjetas de Paquetes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($paquetes as $paquete)
            <div class="bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 border border-gray-600">
                <!-- Header de la tarjeta con nombre y estatus -->
                <div class="p-6 border-b border-gray-600">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-white truncate pr-2">
                            {{ $paquete->nombre }}
                        </h3>
                        <span class="px-2 py-1 text-xs leading-4 font-semibold rounded-full {{ $paquete->color_estatus }} whitespace-nowrap">
                            {{ $paquete->texto_estatus }}
                        </span>
                    </div>
                    
                    @if($paquete->descripcion)
                        <p class="text-sm text-gray-300 line-clamp-2">
                            {{ $paquete->descripcion }}
                        </p>
                    @endif
                </div>

                <!-- Contenido principal de la tarjeta -->
                <div class="p-6 space-y-4">
                    <!-- Información de fecha y creador -->
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex items-center text-sm text-gray-300">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Creado: {{ $paquete->fecha_creacion->format('d/m/Y') }}
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-300">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Por: {{ $paquete->creador->name }}
                        </div>
                    </div>

                    <!-- Información de empleados -->
                    <div class="bg-gray-700 rounded-lg p-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-200">Empleados</span>
                            <span class="text-lg font-bold text-blue-400">{{ $paquete->empleados->count() }}</span>
                        </div>
                        
                        @if($paquete->empleados->count() > 0)
                            <div class="text-xs text-gray-400">
                                @php
                                    $sucursalesCount = $paquete->empleados->flatMap(function($empleado) {
                                        $sucursales = collect();
                                        if($empleado->sucursal) $sucursales->push($empleado->sucursal->Nombre);
                                        $empleado->sucursales->each(function($s) use ($sucursales) {
                                            if(!$sucursales->contains($s->Nombre)) $sucursales->push($s->Nombre);
                                        });
                                        return $sucursales;
                                    })->unique()->count();
                                @endphp
                                En {{ $sucursalesCount }} sucursal{{ $sucursalesCount != 1 ? 'es' : '' }}
                            </div>
                        @else
                            <div class="text-xs text-gray-400">Sin empleados asignados</div>
                        @endif
                    </div>
                </div>

                <!-- Footer con acciones -->
                <div class="px-6 py-4 bg-gray-700 border-t border-gray-600 rounded-b-lg">
                    <div class="flex flex-wrap gap-2">
                        <!-- Botón Ver -->
                        @if(auth()->user()->hasPermission('paquetes', 'ver'))
                            <a href="{{ route('paquetes.show', $paquete->idPaquete) }}" 
                               class="inline-flex items-center px-3 py-1 border border-blue-400 text-xs font-medium rounded-md text-blue-300 bg-blue-900 hover:bg-blue-800 transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver
                            </a>
                        @endif
                        
                        @if($paquete->puedeSerEditado() && auth()->user()->hasPermission('paquetes', 'editar'))
                            <!-- Botón Editar -->
                            <a href="{{ route('paquetes.edit', $paquete->idPaquete) }}" 
                               class="inline-flex items-center px-3 py-1 border border-yellow-400 text-xs font-medium rounded-md text-yellow-300 bg-yellow-900 hover:bg-yellow-800 transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>
                        @endif
                        
                        @if($paquete->puedeSerEditado() && auth()->user()->hasPermission('paquetes', 'confirmar'))
                            <!-- Botón Confirmar -->
                            <form method="POST" action="{{ route('paquetes.confirmar', $paquete->idPaquete) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        onclick="return confirm('¿Confirmar este paquete? No podrá ser modificado después.')"
                                        class="inline-flex items-center px-3 py-1 border border-green-400 text-xs font-medium rounded-md text-green-300 bg-green-900 hover:bg-green-800 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Confirmar
                                </button>
                            </form>
                        @endif
                        
                        @if($paquete->puedeSerEditado() && auth()->user()->hasPermission('paquetes', 'eliminar'))
                            <!-- Botón Eliminar -->
                            <form method="POST" action="{{ route('paquetes.destroy', $paquete->idPaquete) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Eliminar este paquete?')"
                                        class="inline-flex items-center px-3 py-1 border border-red-400 text-xs font-medium rounded-md text-red-300 bg-red-900 hover:bg-red-800 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        @endif
                            
                        @if($paquete->estatus === 'confirmado' && $paquete->puedeSerAutorizado() && auth()->user()->hasPermission('paquetes', 'autorizar'))
                            <!-- Botón Autorizar -->
                            <form method="POST" action="{{ route('paquetes.autorizar', $paquete->idPaquete) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        onclick="return confirm('¿Autorizar este paquete? Todos los empleados están validados.')"
                                        class="inline-flex items-center px-3 py-1 border border-purple-400 text-xs font-medium rounded-md text-purple-300 bg-purple-900 hover:bg-purple-800 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Autorizar
                                </button>
                            </form>
                        @elseif($paquete->estatus === 'confirmado' && !$paquete->puedeSerAutorizado())
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-400 bg-gray-600 rounded-md">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                Empleados pendientes
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <!-- Estado vacío -->
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-white">No hay paquetes</h3>
                    <p class="mt-1 text-sm text-gray-300">Comienza creando tu primer paquete de impresión.</p>
                    @if(auth()->user()->hasPermission('paquetes', 'crear'))
                        <div class="mt-6">
                            <a href="{{ route('paquetes.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Crear Paquete
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforelse
    </div>
</div>
</x-app-layout>