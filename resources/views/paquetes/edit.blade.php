<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Paquete') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-white">Editar Paquete: {{ $paquete->nombre }}</h1>
                <p class="text-gray-300 mt-2">Modifica la información y selección de empleados del paquete.</p>
            </div>

            <form method="POST" action="{{ route('paquetes.update', $paquete->idPaquete) }}" class="bg-gray-800 shadow-md rounded-lg p-6 border border-gray-600">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Nombre del paquete -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-white mb-2">
                    Nombre del Paquete *
                </label>
                <input type="text" 
                       name="nombre" 
                       id="nombre"
                       value="{{ old('nombre', $paquete->nombre) }}"
                       class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white @error('nombre') border-red-500 @enderror"
                       required>
                @error('nombre')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha de creación -->
            <div>
                <label for="fecha_creacion" class="block text-sm font-medium text-white mb-2">
                    Fecha de Creación *
                </label>
                <input type="date" 
                       name="fecha_creacion" 
                       id="fecha_creacion"
                       value="{{ old('fecha_creacion', $paquete->fecha_creacion->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white @error('fecha_creacion') border-red-500 @enderror"
                       required>
                @error('fecha_creacion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Descripción -->
        <div class="mb-6">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                Descripción
            </label>
            <textarea name="descripcion" 
                      id="descripcion"
                      rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror"
                      placeholder="Descripción opcional del paquete">{{ old('descripcion', $paquete->descripcion) }}</textarea>
            @error('descripcion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Selección de empleados con doble lista -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-white mb-3">
                Seleccionar Empleados *
            </label>
            @error('empleados')
                <p class="mb-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
            
            <!-- Filtros de búsqueda -->
            <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-400 mb-1">Buscar por nombre o sucursal</label>
                    <input type="text" 
                           id="buscar-empleado" 
                           placeholder="Buscar empleado..."
                           class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Filtrar por puesto</label>
                    <select id="filtro-puesto" 
                            class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                        <option value="">Todos los puestos</option>
                        @foreach($puestos as $puesto)
                            <option value="{{ strtolower($puesto) }}">{{ $puesto }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" 
                            id="limpiar-filtros"
                            class="w-full px-3 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700">
                        Limpiar
                    </button>
                </div>
            </div>

            <!-- Contenedor de las dos listas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Lista de empleados disponibles -->
                <div class="bg-gray-700 border border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-900 px-4 py-3 border-b border-gray-600">
                        <h3 class="text-sm font-semibold text-white">Empleados Disponibles</h3>
                        <p class="text-xs text-gray-400 mt-1">
                            <span id="count-disponibles">0</span> empleados
                        </p>
                    </div>
                    <div id="lista-disponibles" class="p-3 max-h-96 overflow-y-auto space-y-2">
                        @php
                            $empleadosSeleccionados = old('empleados', $paquete->empleados->pluck('idEmpleado')->toArray());
                        @endphp
                        
                        @foreach($empleados as $empleado)
                            @if(!in_array($empleado->idEmpleado, $empleadosSeleccionados))
                            <div class="empleado-disponible empleado-item bg-gray-800 rounded-lg p-3 hover:bg-gray-600 transition-colors border border-gray-600"
                                 data-id="{{ $empleado->idEmpleado }}"
                                 data-nombre="{{ strtolower($empleado->Nombre . ' ' . $empleado->Apellido) }}"
                                 data-sucursal="{{ $empleado->sucursales_para_busqueda }}"
                                 data-puesto="{{ strtolower($empleado->Puesto ?? '') }}"
                                 data-validado="{{ $empleado->Validado ? 'true' : 'false' }}"
                                 data-status="{{ $empleado->status }}">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0" onclick="agregarEmpleado({{ $empleado->idEmpleado }})" style="cursor: pointer;">
                                        <div class="flex items-start justify-between gap-2 mb-2">
                                            <h4 class="text-sm font-medium text-white">
                                                {{ $empleado->Nombre }} {{ $empleado->Apellido }}
                                            </h4>
                                            <!-- Badge de estatus -->
                                            @if($empleado->Validado)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-900 text-green-200 border border-green-700 whitespace-nowrap">
                                                    ✓ Validado
                                                </span>
                                            @elseif($empleado->status === 'Completo')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-900 text-blue-200 border border-blue-700 whitespace-nowrap">
                                                    Completo
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-900 text-yellow-200 border border-yellow-700 whitespace-nowrap">
                                                    ⚠ Incompleto
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $empleado->Puesto ?? 'Sin puesto' }}
                                        </p>
                                        <p class="text-xs text-blue-400 mt-1">
                                            {{ $empleado->nombres_sucursales }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <!-- Botón ver detalles -->
                                        <a href="{{ route('empleados.show', $empleado->idEmpleado) }}" 
                                           class="text-blue-400 hover:text-blue-300"
                                           title="Ver detalles"
                                           onclick="event.stopPropagation()">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <!-- Botón agregar -->
                                        <button type="button" 
                                                class="text-green-400 hover:text-green-300"
                                                title="Agregar al paquete"
                                                onclick="event.stopPropagation(); agregarEmpleado({{ $empleado->idEmpleado }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Lista de empleados seleccionados -->
                <div class="bg-gray-700 border border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-blue-900 px-4 py-3 border-b border-blue-700">
                        <h3 class="text-sm font-semibold text-white">Empleados en el Paquete</h3>
                        <p class="text-xs text-blue-200 mt-1">
                            <span id="count-seleccionados">0</span> empleados seleccionados
                        </p>
                    </div>
                    <div id="lista-seleccionados" class="p-3 max-h-96 overflow-y-auto space-y-2 min-h-[200px]">
                        @foreach($empleados as $empleado)
                            @if(in_array($empleado->idEmpleado, $empleadosSeleccionados))
                            <div class="empleado-seleccionado bg-blue-800 rounded-lg p-3 hover:bg-blue-700 transition-colors border border-blue-600"
                                 data-id="{{ $empleado->idEmpleado }}">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0" onclick="removerEmpleado({{ $empleado->idEmpleado }})" style="cursor: pointer;">
                                        <div class="flex items-start justify-between gap-2 mb-2">
                                            <h4 class="text-sm font-medium text-white">
                                                {{ $empleado->Nombre }} {{ $empleado->Apellido }}
                                            </h4>
                                            <!-- Badge de estatus -->
                                            @if($empleado->Validado)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-900 text-green-200 border border-green-700 whitespace-nowrap">
                                                    ✓ Validado
                                                </span>
                                            @elseif($empleado->status === 'Completo')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-900 text-blue-200 border border-blue-700 whitespace-nowrap">
                                                    Completo
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-900 text-yellow-200 border border-yellow-700 whitespace-nowrap">
                                                    ⚠ Incompleto
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-300 mt-1">
                                            {{ $empleado->Puesto ?? 'Sin puesto' }}
                                        </p>
                                        <p class="text-xs text-blue-200 mt-1">
                                            {{ $empleado->nombres_sucursales }}
                                        </p>
                                        <input type="hidden" name="empleados[]" value="{{ $empleado->idEmpleado }}">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <!-- Botón ver detalles -->
                                        <a href="{{ route('empleados.show', $empleado->idEmpleado) }}" 
                                           class="text-blue-300 hover:text-blue-200"
                                           title="Ver detalles"
                                           onclick="event.stopPropagation()">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <!-- Botón quitar -->
                                        <button type="button" 
                                                class="text-red-400 hover:text-red-300"
                                                title="Quitar del paquete"
                                                onclick="event.stopPropagation(); removerEmpleado({{ $empleado->idEmpleado }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        
                        <div id="mensaje-vacio" class="text-center py-12 text-gray-400" style="display: none;">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-sm">No hay empleados seleccionados</p>
                            <p class="text-xs mt-1">Haz clic en los empleados de la izquierda para agregarlos</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción rápida -->
            <div class="mt-4 flex justify-between items-center">
                <div class="flex gap-2">
                    <button type="button" 
                            id="seleccionar-todos"
                            class="px-3 py-2 text-xs bg-green-700 text-white rounded-md hover:bg-green-600 transition-colors">
                        Seleccionar Todos
                    </button>
                    <button type="button" 
                            id="quitar-todos"
                            class="px-3 py-2 text-xs bg-red-700 text-white rounded-md hover:bg-red-600 transition-colors">
                        Quitar Todos
                    </button>
                </div>
                <div class="text-sm text-gray-400">
                    Haz clic en un empleado para moverlo entre listas
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('paquetes.show', $paquete->idPaquete) }}" 
               class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-700">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Actualizar Paquete
            </button>
        </div>
    </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscar-empleado');
    const filtroPuesto = document.getElementById('filtro-puesto');
    const limpiarFiltros = document.getElementById('limpiar-filtros');
    const listaDisponibles = document.getElementById('lista-disponibles');
    const listaSeleccionados = document.getElementById('lista-seleccionados');
    const mensajeVacio = document.getElementById('mensaje-vacio');
    const countDisponibles = document.getElementById('count-disponibles');
    const countSeleccionados = document.getElementById('count-seleccionados');
    
    // Datos de empleados
    const empleadosData = {
        @foreach($empleados as $empleado)
        {{ $empleado->idEmpleado }}: {
            id: {{ $empleado->idEmpleado }},
            nombre: '{{ $empleado->Nombre }} {{ $empleado->Apellido }}',
            puesto: '{{ $empleado->Puesto ?? 'Sin puesto' }}',
            sucursales: '{{ $empleado->nombres_sucursales }}',
            nombreBusqueda: '{{ strtolower($empleado->Nombre . ' ' . $empleado->Apellido) }}',
            sucursalBusqueda: '{{ $empleado->sucursales_para_busqueda }}',
            puestoBusqueda: '{{ strtolower($empleado->Puesto ?? '') }}',
            validado: {{ $empleado->Validado ? 'true' : 'false' }},
            status: '{{ $empleado->status }}'
        },
        @endforeach
    };

    // Función para agregar empleado
    window.agregarEmpleado = function(idEmpleado) {
        const elementoDisponible = document.querySelector(`.empleado-disponible[data-id="${idEmpleado}"]`);
        if (!elementoDisponible) return;
        
        const empleado = empleadosData[idEmpleado];
        
        // Crear badge de estatus
        let badgeHtml = '';
        if (empleado.validado) {
            badgeHtml = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-900 text-green-200 border border-green-700 whitespace-nowrap">✓ Validado</span>';
        } else if (empleado.status === 'Completo') {
            badgeHtml = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-900 text-blue-200 border border-blue-700 whitespace-nowrap">Completo</span>';
        } else {
            badgeHtml = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-900 text-yellow-200 border border-yellow-700 whitespace-nowrap">⚠ Incompleto</span>';
        }
        
        // Crear elemento en lista de seleccionados
        const div = document.createElement('div');
        div.className = 'empleado-seleccionado bg-blue-800 rounded-lg p-3 hover:bg-blue-700 transition-colors border border-blue-600';
        div.dataset.id = idEmpleado;
        div.innerHTML = `
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0" onclick="removerEmpleado(${idEmpleado})" style="cursor: pointer;">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h4 class="text-sm font-medium text-white">${empleado.nombre}</h4>
                        ${badgeHtml}
                    </div>
                    <p class="text-xs text-gray-300 mt-1">${empleado.puesto}</p>
                    <p class="text-xs text-blue-200 mt-1">${empleado.sucursales}</p>
                    <input type="hidden" name="empleados[]" value="${idEmpleado}">
                </div>
                <div class="flex flex-col gap-1">
                    <a href="/empleados/${idEmpleado}" 
                       class="text-blue-300 hover:text-blue-200"
                       title="Ver detalles"
                       onclick="event.stopPropagation()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                    <button type="button" 
                            class="text-red-400 hover:text-red-300"
                            title="Quitar del paquete"
                            onclick="event.stopPropagation(); removerEmpleado(${idEmpleado})">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        // Agregar a lista de seleccionados
        listaSeleccionados.insertBefore(div, mensajeVacio);
        
        // Remover de lista de disponibles
        elementoDisponible.remove();
        
        actualizarContadores();
    };

    // Función para remover empleado
    window.removerEmpleado = function(idEmpleado) {
        const elementoSeleccionado = document.querySelector(`.empleado-seleccionado[data-id="${idEmpleado}"]`);
        if (!elementoSeleccionado) return;
        
        const empleado = empleadosData[idEmpleado];
        
        // Crear badge de estatus
        let badgeHtml = '';
        if (empleado.validado) {
            badgeHtml = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-900 text-green-200 border border-green-700 whitespace-nowrap">✓ Validado</span>';
        } else if (empleado.status === 'Completo') {
            badgeHtml = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-900 text-blue-200 border border-blue-700 whitespace-nowrap">Completo</span>';
        } else {
            badgeHtml = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-900 text-yellow-200 border border-yellow-700 whitespace-nowrap">⚠ Incompleto</span>';
        }
        
        // Crear elemento en lista de disponibles
        const div = document.createElement('div');
        div.className = 'empleado-disponible empleado-item bg-gray-800 rounded-lg p-3 hover:bg-gray-600 transition-colors border border-gray-600';
        div.dataset.id = idEmpleado;
        div.dataset.nombre = empleado.nombreBusqueda;
        div.dataset.sucursal = empleado.sucursalBusqueda;
        div.dataset.puesto = empleado.puestoBusqueda;
        div.dataset.validado = empleado.validado;
        div.dataset.status = empleado.status;
        div.innerHTML = `
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0" onclick="agregarEmpleado(${idEmpleado})" style="cursor: pointer;">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h4 class="text-sm font-medium text-white">${empleado.nombre}</h4>
                        ${badgeHtml}
                    </div>
                    <p class="text-xs text-gray-400 mt-1">${empleado.puesto}</p>
                    <p class="text-xs text-blue-400 mt-1">${empleado.sucursales}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="/empleados/${idEmpleado}" 
                       class="text-blue-400 hover:text-blue-300"
                       title="Ver detalles"
                       onclick="event.stopPropagation()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                    <button type="button" 
                            class="text-green-400 hover:text-green-300"
                            title="Agregar al paquete"
                            onclick="event.stopPropagation(); agregarEmpleado(${idEmpleado})">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        // Agregar a lista de disponibles
        listaDisponibles.appendChild(div);
        
        // Remover de lista de seleccionados
        elementoSeleccionado.remove();
        
        actualizarContadores();
        aplicarFiltros();
    };

    // Actualizar contadores
    function actualizarContadores() {
        const disponibles = document.querySelectorAll('.empleado-disponible').length;
        const seleccionados = document.querySelectorAll('.empleado-seleccionado').length;
        
        countDisponibles.textContent = disponibles;
        countSeleccionados.textContent = seleccionados;
        
        // Mostrar/ocultar mensaje vacío
        if (seleccionados === 0) {
            mensajeVacio.style.display = 'block';
        } else {
            mensajeVacio.style.display = 'none';
        }
    }

    // Aplicar filtros
    function aplicarFiltros() {
        const termino = buscarInput.value.toLowerCase();
        const puestoSeleccionado = filtroPuesto.value.toLowerCase();
        
        const empleadosDisponibles = document.querySelectorAll('.empleado-disponible');
        
        empleadosDisponibles.forEach(item => {
            const nombre = item.dataset.nombre || '';
            const sucursal = item.dataset.sucursal || '';
            const puesto = item.dataset.puesto || '';
            
            const coincideTexto = termino === '' || nombre.includes(termino) || sucursal.includes(termino);
            const coincidePuesto = puestoSeleccionado === '' || puesto === puestoSeleccionado;
            
            if (coincideTexto && coincidePuesto) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
        
        actualizarContadores();
    }

    // Limpiar filtros
    function limpiarTodosFiltros() {
        buscarInput.value = '';
        filtroPuesto.value = '';
        aplicarFiltros();
    }

    // Seleccionar todos
    document.getElementById('seleccionar-todos').addEventListener('click', function() {
        const disponibles = Array.from(document.querySelectorAll('.empleado-disponible'));
        disponibles.forEach(elem => {
            const id = elem.dataset.id;
            agregarEmpleado(parseInt(id));
        });
    });

    // Quitar todos
    document.getElementById('quitar-todos').addEventListener('click', function() {
        const seleccionados = Array.from(document.querySelectorAll('.empleado-seleccionado'));
        seleccionados.forEach(elem => {
            const id = elem.dataset.id;
            removerEmpleado(parseInt(id));
        });
    });

    // Event listeners
    buscarInput.addEventListener('input', aplicarFiltros);
    filtroPuesto.addEventListener('change', aplicarFiltros);
    limpiarFiltros.addEventListener('click', limpiarTodosFiltros);

    // Inicializar
    actualizarContadores();
});
</script>
</x-app-layout>