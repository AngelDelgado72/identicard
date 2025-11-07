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
        <form method="GET" action="{{ route('paquetes.index') }}">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 items-end">
                <div class="lg:col-span-3">
                    <label for="buscar" class="block text-sm font-medium text-gray-300 mb-1">Buscar por nombre</label>
                    <input type="text" 
                           name="buscar" 
                           id="buscar" 
                           value="{{ request('buscar') }}"
                           placeholder="Buscar paquete..."
                           class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                </div>
                
                <div class="lg:col-span-2">
                    <label for="fecha" class="block text-sm font-medium text-gray-300 mb-1">Filtrar por fecha</label>
                    <input type="date" 
                           name="fecha" 
                           id="fecha" 
                           value="{{ request('fecha') }}"
                           class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                </div>
                
                <div class="lg:col-span-2">
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
                
                <div class="lg:col-span-2 flex gap-2">
                    <button type="submit" 
                            class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm whitespace-nowrap">
                        Buscar
                    </button>
                    <a href="{{ route('paquetes.index') }}" 
                       class="flex-1 px-3 py-2 border border-gray-600 text-gray-300 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 text-sm text-center whitespace-nowrap">
                        Limpiar
                    </a>
                </div>

                <div class="lg:col-span-3 flex gap-2">
                    <button type="button"
                            onclick="toggleOrdenEstatus()" 
                            id="btn-ordenar-estatus"
                            class="flex-1 px-2 py-2 text-xs bg-blue-700 text-white rounded-md hover:bg-blue-600 transition-colors border border-blue-500 whitespace-nowrap">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                        <span id="texto-orden-estatus">Por Estatus</span>
                    </button>
                    <button type="button"
                            onclick="toggleOrdenFecha()" 
                            id="btn-ordenar-fecha"
                            class="flex-1 px-2 py-2 text-xs bg-gray-700 text-white rounded-md hover:bg-gray-600 transition-colors border border-gray-500 whitespace-nowrap">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                        </svg>
                        <span id="texto-orden-fecha">Más Antiguo</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Contador de resultados -->
        <div class="mt-3 pt-3 border-t border-gray-600">
            <div class="text-sm text-gray-300">
                <span class="font-semibold">{{ $paquetes->count() }}</span> paquete(s) encontrado(s)
            </div>
        </div>
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

    <!-- Tabla de Paquetes -->
    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-600">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600" id="tabla-paquetes">
                <thead class="bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Paquete
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Fecha Creación
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Empleados
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Estatus
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Creado Por
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-600" id="tbody-paquetes">
                    @forelse($paquetes as $paquete)
                        <tr class="hover:bg-gray-700 transition-colors paquete-row" 
                            data-estatus="{{ $paquete->estatus }}"
                            data-fecha="{{ $paquete->fecha_creacion->format('Y-m-d') }}"
                            data-orden-estatus="{{ $paquete->estatus === 'en_creacion' ? 1 : ($paquete->estatus === 'confirmado' ? 2 : 3) }}">
                            <!-- Columna Paquete -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-semibold text-white">
                                        {{ $paquete->nombre }}
                                    </div>
                                    @if($paquete->descripcion)
                                        <div class="text-xs text-gray-400 mt-1 line-clamp-2">
                                            {{ $paquete->descripcion }}
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-500 mt-1 italic">
                                            Sin descripción
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Columna Fecha -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300">
                                    {{ $paquete->fecha_creacion->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $paquete->created_at->diffForHumans() }}
                                </div>
                            </td>

                            <!-- Columna Empleados -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="text-lg font-bold text-white">{{ $paquete->empleados->count() }}</span>
                                </div>
                            </td>

                            <!-- Columna Estatus -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $paquete->color_estatus }}">
                                    {{ $paquete->texto_estatus }}
                                </span>
                            </td>

                            <!-- Columna Creado Por -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300">
                                    {{ $paquete->creador->name }}
                                </div>
                            </td>

                            <!-- Columna Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2 flex-wrap">
                                    <!-- Botón Ver -->
                                    @if(auth()->user()->hasPermission('paquetes', 'ver'))
                                        <a href="{{ route('paquetes.show', $paquete->idPaquete) }}" 
                                           class="inline-flex items-center px-2 py-1 border border-blue-400 text-xs font-medium rounded text-blue-300 bg-blue-900 hover:bg-blue-800 transition-colors"
                                           title="Ver detalles">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    @endif
                                    
                                    @if($paquete->puedeSerEditado() && auth()->user()->hasPermission('paquetes', 'editar'))
                                        <!-- Botón Editar -->
                                        <a href="{{ route('paquetes.edit', $paquete->idPaquete) }}" 
                                           class="inline-flex items-center px-2 py-1 border border-yellow-400 text-xs font-medium rounded text-yellow-300 bg-yellow-900 hover:bg-yellow-800 transition-colors"
                                           title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    @endif
                                    
                                    @if($paquete->puedeSerEditado() && auth()->user()->hasPermission('paquetes', 'confirmar'))
                                        <!-- Botón Confirmar -->
                                        <form method="POST" action="{{ route('paquetes.confirmar', $paquete->idPaquete) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    onclick="return confirm('¿Confirmar este paquete? No podrá ser modificado después.')"
                                                    class="inline-flex items-center px-2 py-1 border border-green-400 text-xs font-medium rounded text-green-300 bg-green-900 hover:bg-green-800 transition-colors"
                                                    title="Confirmar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($paquete->estatus === 'confirmado')
                                        @if($paquete->puedeSerAutorizado() && auth()->user()->hasPermission('paquetes', 'autorizar'))
                                            <!-- Botón Autorizar -->
                                            <form method="POST" action="{{ route('paquetes.autorizar', $paquete->idPaquete) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        onclick="return confirm('¿Autorizar este paquete? Todos los empleados están validados.')"
                                                        class="inline-flex items-center px-2 py-1 border border-purple-400 text-xs font-medium rounded text-purple-300 bg-purple-900 hover:bg-purple-800 transition-colors"
                                                        title="Autorizar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @elseif(!$paquete->todosEmpleadosValidados())
                                            <!-- Indicador de empleados pendientes de validación -->
                                            <span class="inline-flex items-center px-2 py-1 border border-yellow-400 text-xs font-medium rounded text-yellow-300 bg-yellow-900"
                                                  title="Hay empleados pendientes de validación">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    @endif
                                    
                                    @if($paquete->estatus === 'autorizado' && auth()->user()->hasPermission('credenciales', 'imprimir'))
                                        <!-- Botón Imprimir Credenciales -->
                                        <a href="{{ route('paquetes.credenciales', $paquete->idPaquete) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-2 py-1 border border-indigo-400 text-xs font-medium rounded text-indigo-300 bg-indigo-900 hover:bg-indigo-800 transition-colors"
                                           title="Imprimir Credenciales">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                    @endif
                                    
                                    @if($paquete->puedeSerEditado() && auth()->user()->hasPermission('paquetes', 'eliminar'))
                                        <!-- Botón Eliminar -->
                                        <form method="POST" action="{{ route('paquetes.destroy', $paquete->idPaquete) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('¿Eliminar este paquete?')"
                                                    class="inline-flex items-center px-2 py-1 border border-red-400 text-xs font-medium rounded text-red-300 bg-red-900 hover:bg-red-800 transition-colors"
                                                    title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
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
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let ordenActual = 'estatus'; // 'estatus' o 'fecha'
    let ordenEstatusAscendente = false; // Iniciamos en false para que el primer toggle lo ponga en true
    let ordenFechaAscendente = true; // true = más antiguo primero, false = más reciente primero
    
    const tbody = document.getElementById('tbody-paquetes');
    const btnOrdenarEstatus = document.getElementById('btn-ordenar-estatus');
    const btnOrdenarFecha = document.getElementById('btn-ordenar-fecha');
    const textoOrdenEstatus = document.getElementById('texto-orden-estatus');
    const textoOrdenFecha = document.getElementById('texto-orden-fecha');

    // Verificar que los elementos existan
    if (!tbody || !btnOrdenarEstatus || !btnOrdenarFecha || !textoOrdenEstatus || !textoOrdenFecha) {
        console.error('Elementos de ordenamiento no encontrados');
        return;
    }

    // Función para alternar orden por estatus
    window.toggleOrdenEstatus = function() {
        console.log('Alternando orden por estatus...');
        ordenActual = 'estatus';
        ordenEstatusAscendente = !ordenEstatusAscendente;
        actualizarEstilosBotones();
        
        const rows = Array.from(tbody.querySelectorAll('.paquete-row'));
        console.log('Filas encontradas:', rows.length);
        
        if (rows.length === 0) return;
        
        rows.sort((a, b) => {
            const ordenA = parseInt(a.dataset.ordenEstatus);
            const ordenB = parseInt(b.dataset.ordenEstatus);
            
            if (ordenA !== ordenB) {
                // Ascendente: 1,2,3 (En Creación, Confirmado, Autorizado)
                // Descendente: 3,2,1 (Autorizado, Confirmado, En Creación)
                if (ordenEstatusAscendente) {
                    return ordenA - ordenB;
                } else {
                    return ordenB - ordenA;
                }
            }
            
            // Si tienen el mismo estatus, ordenar por fecha (más antiguo primero)
            const fechaA = new Date(a.dataset.fecha);
            const fechaB = new Date(b.dataset.fecha);
            return fechaA - fechaB;
        });
        
        // Actualizar texto del botón
        if (ordenEstatusAscendente) {
            textoOrdenEstatus.innerHTML = 'Por Estatus <small>(↑)</small>';
        } else {
            textoOrdenEstatus.innerHTML = 'Por Estatus <small>(↓)</small>';
        }
        
        // Re-insertar las filas ordenadas
        rows.forEach(row => tbody.appendChild(row));
        console.log('Ordenamiento por estatus completado');
    };

    // Función para alternar orden por fecha
    window.toggleOrdenFecha = function() {
        console.log('Alternando orden por fecha...');
        ordenActual = 'fecha';
        ordenFechaAscendente = !ordenFechaAscendente;
        actualizarEstilosBotones();
        
        const rows = Array.from(tbody.querySelectorAll('.paquete-row'));
        
        if (rows.length === 0) return;
        
        rows.sort((a, b) => {
            const fechaA = new Date(a.dataset.fecha);
            const fechaB = new Date(b.dataset.fecha);
            
            if (ordenFechaAscendente) {
                return fechaA - fechaB; // Más antiguo primero
            } else {
                return fechaB - fechaA; // Más reciente primero
            }
        });
        
        // Actualizar texto del botón
        if (ordenFechaAscendente) {
            textoOrdenFecha.innerHTML = 'Más Antiguo <small>(↑)</small>';
        } else {
            textoOrdenFecha.innerHTML = 'Más Reciente <small>(↓)</small>';
        }
        
        // Re-insertar las filas ordenadas
        rows.forEach(row => tbody.appendChild(row));
        console.log('Ordenamiento por fecha completado');
    };

    // Actualizar estilos de botones según orden activo
    function actualizarEstilosBotones() {
        if (ordenActual === 'estatus') {
            btnOrdenarEstatus.classList.remove('bg-gray-700', 'border-gray-500');
            btnOrdenarEstatus.classList.add('bg-blue-700', 'border-blue-500');
            btnOrdenarFecha.classList.remove('bg-blue-700', 'border-blue-500');
            btnOrdenarFecha.classList.add('bg-gray-700', 'border-gray-500');
        } else {
            btnOrdenarFecha.classList.remove('bg-gray-700', 'border-gray-500');
            btnOrdenarFecha.classList.add('bg-blue-700', 'border-blue-500');
            btnOrdenarEstatus.classList.remove('bg-blue-700', 'border-blue-500');
            btnOrdenarEstatus.classList.add('bg-gray-700', 'border-gray-500');
        }
    }

    // Ordenar por estatus al cargar (orden por defecto: En Creación, Confirmado, Autorizado)
    console.log('Iniciando ordenamiento por defecto...');
    window.toggleOrdenEstatus(); // Esto pondrá ordenEstatusAscendente en true
});
</script>
</x-app-layout>