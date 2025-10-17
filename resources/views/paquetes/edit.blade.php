<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Paquete') }}
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Editar Paquete: {{ $paquete->nombre }}</h1>
        <p class="text-gray-600 mt-2">Modifica la información y selección de empleados del paquete.</p>
    </div>

    <form method="POST" action="{{ route('paquetes.update', $paquete->idPaquete) }}" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Nombre del paquete -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre del Paquete *
                </label>
                <input type="text" 
                       name="nombre" 
                       id="nombre"
                       value="{{ old('nombre', $paquete->nombre) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nombre') border-red-500 @enderror"
                       required>
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha de creación -->
            <div>
                <label for="fecha_creacion" class="block text-sm font-medium text-gray-700 mb-2">
                    Fecha de Creación *
                </label>
                <input type="date" 
                       name="fecha_creacion" 
                       id="fecha_creacion"
                       value="{{ old('fecha_creacion', $paquete->fecha_creacion->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_creacion') border-red-500 @enderror"
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

        <!-- Selección de empleados -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Seleccionar Empleados *
            </label>
            @error('empleados')
                <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            
            <div class="mb-4">
                <input type="text" 
                       id="buscar-empleado" 
                       placeholder="Buscar empleado por nombre o sucursal..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="max-h-96 overflow-y-auto border border-gray-300 rounded-md p-4">
                @php
                    $empleadosSeleccionados = old('empleados', $paquete->empleados->pluck('idEmpleado')->toArray());
                @endphp
                
                @foreach($empleados as $empleado)
                    <div class="empleado-item flex items-center p-2 hover:bg-gray-50 rounded" 
                         data-nombre="{{ strtolower($empleado->Nombre . ' ' . $empleado->Apellido) }}"
                         data-sucursal="{{ $empleado->sucursales_para_busqueda }}">
                        <input type="checkbox" 
                               name="empleados[]" 
                               value="{{ $empleado->idEmpleado }}"
                               id="empleado_{{ $empleado->idEmpleado }}"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               {{ in_array($empleado->idEmpleado, $empleadosSeleccionados) ? 'checked' : '' }}>
                        <label for="empleado_{{ $empleado->idEmpleado }}" class="ml-3 flex-1 cursor-pointer">
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $empleado->Nombre }} {{ $empleado->Apellido }}
                                </span>
                                <div class="text-right">
                                    @if($empleado->sucursales->count() > 1 || ($empleado->sucursal && $empleado->sucursales->count() > 0))
                                        <div class="text-xs text-blue-600 font-medium">
                                            {{ $empleado->sucursales->count() + ($empleado->sucursal ? 1 : 0) }} sucursales
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-500 text-right max-w-48">
                                        {{ $empleado->nombres_sucursales }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $empleado->Puesto ?? 'Sin puesto' }}
                                @if($empleado->Correo)
                                    • {{ $empleado->Correo }}
                                @endif
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="mt-2 text-sm text-gray-600">
                <span id="empleados-seleccionados">0</span> empleados seleccionados
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('paquetes.show', $paquete->idPaquete) }}" 
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Actualizar Paquete
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscar-empleado');
    const empleadoItems = document.querySelectorAll('.empleado-item');
    const contadorSeleccionados = document.getElementById('empleados-seleccionados');
    const checkboxes = document.querySelectorAll('input[name="empleados[]"]');

    // Función para actualizar contador
    function actualizarContador() {
        const seleccionados = document.querySelectorAll('input[name="empleados[]"]:checked').length;
        contadorSeleccionados.textContent = seleccionados;
    }

    // Función de búsqueda
    buscarInput.addEventListener('input', function() {
        const termino = this.value.toLowerCase();
        
        empleadoItems.forEach(item => {
            const nombre = item.dataset.nombre;
            const sucursal = item.dataset.sucursal;
            
            if (nombre.includes(termino) || sucursal.includes(termino)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Actualizar contador cuando cambie selección
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', actualizarContador);
    });

    // Inicializar contador
    actualizarContador();
});
</script>
</x-app-layout>