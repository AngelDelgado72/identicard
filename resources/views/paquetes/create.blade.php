<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Paquete') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-white">Crear Nuevo Paquete</h1>
                <p class="text-gray-300 mt-2">Selecciona los empleados para incluir en el paquete de impresión de credenciales.</p>
            </div>

            <form method="POST" action="{{ route('paquetes.store') }}" class="bg-gray-800 shadow-md rounded-lg p-6 border border-gray-600">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Nombre del paquete -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-white mb-2">
                    Nombre del Paquete *
                </label>
                <input type="text" 
                       name="nombre" 
                       id="nombre"
                       value="{{ old('nombre') }}"
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
                       value="{{ old('fecha_creacion', date('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white @error('fecha_creacion') border-red-500 @enderror"
                       required>
                @error('fecha_creacion')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Descripción -->
        <div class="mb-6">
            <label for="descripcion" class="block text-sm font-medium text-white mb-2">
                Descripción
            </label>
            <textarea name="descripcion" 
                      id="descripcion"
                      rows="3"
                      class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white @error('descripcion') border-red-500 @enderror"
                      placeholder="Descripción opcional del paquete">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Selección de empleados -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-white mb-3">
                Seleccionar Empleados *
            </label>
            @error('empleados')
                <p class="mb-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
            
            <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-400 mb-1">Buscar por nombre o sucursal</label>
                    <input type="text" 
                           id="buscar-empleado" 
                           placeholder="Buscar empleado por nombre o sucursal..."
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
                        Limpiar Filtros
                    </button>
                </div>
            </div>

            <div class="max-h-96 overflow-y-auto border border-gray-600 rounded-md p-4 bg-gray-700">
                @foreach($empleados as $empleado)
                    <div class="empleado-item flex items-center p-2 hover:bg-gray-600 rounded" 
                         data-nombre="{{ strtolower($empleado->Nombre . ' ' . $empleado->Apellido) }}"
                         data-sucursal="{{ $empleado->sucursales_para_busqueda }}"
                         data-puesto="{{ strtolower($empleado->Puesto ?? '') }}">
                        <input type="checkbox" 
                               name="empleados[]" 
                               value="{{ $empleado->idEmpleado }}"
                               id="empleado_{{ $empleado->idEmpleado }}"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-500 rounded"
                               {{ in_array($empleado->idEmpleado, old('empleados', [])) ? 'checked' : '' }}>
                        <label for="empleado_{{ $empleado->idEmpleado }}" class="ml-3 flex-1 cursor-pointer">
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium text-white">
                                    {{ $empleado->Nombre }} {{ $empleado->Apellido }}
                                </span>
                                <div class="text-right">
                                    @if($empleado->sucursales->count() > 1 || ($empleado->sucursal && $empleado->sucursales->count() > 0))
                                        <div class="text-xs text-blue-400 font-medium">
                                            {{ $empleado->sucursales->count() + ($empleado->sucursal ? 1 : 0) }} sucursales
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-300 text-right max-w-48">
                                        {{ $empleado->nombres_sucursales }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-400 mt-1">
                                {{ $empleado->Puesto ?? 'Sin puesto' }}
                                @if($empleado->Correo)
                                    • {{ $empleado->Correo }}
                                @endif
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="mt-2 flex justify-between text-sm text-gray-300">
                <span id="info-filtro">{{ $empleados->count() }} empleados encontrados</span>
                <span><span id="empleados-seleccionados">0</span> empleados seleccionados</span>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('paquetes.index') }}" 
               class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-700">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Crear Paquete
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
    const empleadoItems = document.querySelectorAll('.empleado-item');
    const contadorSeleccionados = document.getElementById('empleados-seleccionados');
    const checkboxes = document.querySelectorAll('input[name="empleados[]"]');

    // Función para actualizar contador
    function actualizarContador() {
        const seleccionados = document.querySelectorAll('input[name="empleados[]"]:checked').length;
        contadorSeleccionados.textContent = seleccionados;
    }

    // Función de filtrado combinado
    function filtrarEmpleados() {
        const termino = buscarInput.value.toLowerCase();
        const puestoSeleccionado = filtroPuesto.value.toLowerCase();
        
        empleadoItems.forEach(item => {
            const nombre = item.dataset.nombre;
            const sucursal = item.dataset.sucursal;
            const puesto = item.dataset.puesto;
            
            const coincideTexto = termino === '' || nombre.includes(termino) || sucursal.includes(termino);
            const coincidePuesto = puestoSeleccionado === '' || puesto === puestoSeleccionado;
            
            if (coincideTexto && coincidePuesto) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });

        // Actualizar contador de empleados visibles
        const empleadosVisibles = document.querySelectorAll('.empleado-item:not([style*="display: none"])').length;
        
        // Mostrar estadísticas de filtrado
        const infoFiltro = document.getElementById('info-filtro');
        if (infoFiltro) {
            if (termino === '' && puestoSeleccionado === '') {
                infoFiltro.textContent = `{{ $empleados->count() }} empleados encontrados`;
            } else {
                infoFiltro.textContent = `${empleadosVisibles} empleados encontrados`;
            }
        }
    }

    // Función para limpiar todos los filtros
    function limpiarTodosFiltros() {
        buscarInput.value = '';
        filtroPuesto.value = '';
        filtrarEmpleados();
    }

    // Event listeners
    buscarInput.addEventListener('input', filtrarEmpleados);
    filtroPuesto.addEventListener('change', filtrarEmpleados);
    limpiarFiltros.addEventListener('click', limpiarTodosFiltros);

    // Actualizar contador cuando cambie selección
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', actualizarContador);
    });

    // Inicializar contador
    actualizarContador();
});
</script>
</x-app-layout>