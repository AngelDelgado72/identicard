<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Paquete') }}
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $paquete->nombre }}</h1>
            <p class="text-gray-600 mt-1">Detalles del paquete de impresión</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('paquetes.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Volver al Listado
            </a>
            @if($paquete->estatus === 'en_creacion')
                <a href="{{ route('paquetes.edit', $paquete->idPaquete) }}" 
                   class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                    Editar Paquete
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información del paquete -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Paquete</h2>
                
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd class="text-sm text-gray-900">{{ $paquete->nombre }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                        <dd class="text-sm text-gray-900">
                            {{ $paquete->descripcion ?: 'Sin descripción' }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de Creación</dt>
                        <dd class="text-sm text-gray-900">
                            {{ $paquete->fecha_creacion->format('d/m/Y') }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estatus</dt>
                        <dd class="text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $paquete->estatus === 'confirmado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $paquete->estatus === 'confirmado' ? 'Confirmado' : 'En Creación' }}
                            </span>
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Creado Por</dt>
                        <dd class="text-sm text-gray-900">{{ $paquete->creador->name }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total de Empleados</dt>
                        <dd class="text-sm text-gray-900">{{ $paquete->empleados->count() }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Creado el</dt>
                        <dd class="text-sm text-gray-900">
                            {{ $paquete->created_at->format('d/m/Y H:i') }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                        <dd class="text-sm text-gray-900">
                            {{ $paquete->updated_at->format('d/m/Y H:i') }}
                        </dd>
                    </div>
                </dl>

                @if($paquete->estatus === 'en_creacion')
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('paquetes.confirmar', $paquete->idPaquete) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    onclick="return confirm('¿Confirmar este paquete? No podrá ser modificado después.')"
                                    class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Confirmar Paquete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Lista de empleados -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-md rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Empleados en el Paquete ({{ $paquete->empleados->count() }})
                    </h2>
                </div>
                
                @if($paquete->empleados->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($paquete->empleados as $empleado)
                            <div class="px-6 py-4 flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            {{ $empleado->Nombre }} {{ $empleado->Apellido }}
                                        </h3>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $empleado->Validado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $empleado->Validado ? 'Validado' : 'Pendiente' }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm text-gray-500 mb-1">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <span class="font-medium">Sucursales:</span>
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm text-gray-600 mb-2 ml-5">
                                        @if($empleado->sucursales->count() > 0 || $empleado->sucursal)
                                            @php
                                                $todasSucursales = collect();
                                                if($empleado->sucursal) {
                                                    $todasSucursales->push($empleado->sucursal);
                                                }
                                                $todasSucursales = $todasSucursales->merge($empleado->sucursales)->unique('idSucursal');
                                            @endphp
                                            
                                            @foreach($todasSucursales as $index => $sucursal)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1">
                                                    {{ $sucursal->Nombre }}
                                                </span>
                                            @endforeach
                                            
                                            @if($todasSucursales->count() > 1)
                                                <span class="text-xs text-blue-600 font-medium">
                                                    ({{ $todasSucursales->count() }} sucursales)
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400 italic">Sin sucursales asignadas</span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-sm text-gray-500">
                                        <span>{{ $empleado->Puesto ?? 'Sin puesto' }}</span>
                                        @if($empleado->Correo)
                                            • <span>{{ $empleado->Correo }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2 ml-4">
                                    <!-- Botón Ver Detalles -->
                                    <a href="{{ route('empleados.show', $empleado->idEmpleado) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-2 py-1 border border-blue-300 rounded text-xs text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Ver Detalles
                                    </a>
                                    
                                    @if($paquete->estatus === 'en_creacion')
                                        <button onclick="removerEmpleado({{ $paquete->idPaquete }}, {{ $empleado->idEmpleado }})"
                                                class="inline-flex items-center px-2 py-1 border border-red-300 rounded text-xs text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Remover
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-8 text-center text-gray-500">
                        No hay empleados en este paquete.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($paquete->estatus === 'en_creacion')
<script>
function removerEmpleado(idPaquete, idEmpleado) {
    if (!confirm('¿Está seguro de que desea remover este empleado del paquete?')) {
        return;
    }

    fetch(`/paquetes/${idPaquete}/empleados/${idEmpleado}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'Error al remover el empleado');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    });
}
</script>
@endif
</x-app-layout>