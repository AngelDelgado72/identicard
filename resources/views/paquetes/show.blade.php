<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Paquete') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $paquete->nombre }}</h1>
                    <p class="text-gray-300 mt-1">Detalles del paquete de impresión</p>
                </div>
                <div class="flex space-x-2">
                    @if(auth()->user()->hasPermission('paquetes', 'ver'))
                        <a href="{{ route('paquetes.index') }}" 
                           class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-700">
                            Volver al Listado
                        </a>
                    @endif
                    @if($paquete->puedeSerEditado() && auth()->user()->hasPermission('paquetes', 'editar'))
                        <a href="{{ route('paquetes.edit', $paquete->idPaquete) }}" 
                           class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                            Editar Paquete
                        </a>
                    @endif
                </div>
            </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información del paquete -->
        <div class="lg:col-span-1">
            <div class="bg-gray-800 shadow-md rounded-lg p-6 border border-gray-600">
                <h2 class="text-lg font-semibold text-white mb-4">Información del Paquete</h2>
                
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-400">Nombre</dt>
                        <dd class="text-sm text-white">{{ $paquete->nombre }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-400">Descripción</dt>
                        <dd class="text-sm text-white">
                            {{ $paquete->descripcion ?: 'Sin descripción' }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-400">Fecha de Creación</dt>
                        <dd class="text-sm text-white">
                            {{ $paquete->fecha_creacion->format('d/m/Y') }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-400">Estatus</dt>
                        <dd class="text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $paquete->color_estatus }}">
                                {{ $paquete->texto_estatus }}
                            </span>
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-400">Creado Por</dt>
                        <dd class="text-sm text-white">{{ $paquete->creador->name }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-400">Total de Empleados</dt>
                        <dd class="text-sm text-white">{{ $paquete->empleados->count() }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-400">Creado el</dt>
                        <dd class="text-sm text-white">
                            {{ $paquete->created_at->format('d/m/Y H:i') }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-400">Última actualización</dt>
                        <dd class="text-sm text-white">
                            {{ $paquete->updated_at->format('d/m/Y H:i') }}
                        </dd>
                    </div>
                </dl>

                @if($paquete->puedeSerEditado() && auth()->user()->hasPermission('paquetes', 'confirmar'))
                    <div class="mt-6 pt-4 border-t border-gray-600">
                        <form method="POST" action="{{ route('paquetes.confirmar', $paquete->idPaquete) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    onclick="return confirm('¿Confirmar este paquete? No podrá ser modificado después.')"
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Confirmar Paquete
                            </button>
                        </form>
                    </div>
                @elseif($paquete->estatus === 'confirmado')
                    <div class="mt-6 pt-4 border-t border-gray-600">
                        @if($paquete->puedeSerAutorizado() && auth()->user()->hasPermission('paquetes', 'autorizar'))
                            <form method="POST" action="{{ route('paquetes.autorizar', $paquete->idPaquete) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        onclick="return confirm('¿Autorizar este paquete? Todos los empleados están validados.')"
                                        class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Autorizar Paquete
                                </button>
                            </form>
                        @else
                            <div class="bg-yellow-900 border border-yellow-600 rounded-md p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-200">
                                            Empleados pendientes de validación
                                        </h3>
                                        <p class="mt-1 text-sm text-yellow-300">
                                            Todos los empleados deben estar validados antes de poder autorizar el paquete.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Lista de empleados -->
        <div class="lg:col-span-2">
            <div class="bg-gray-800 shadow-md rounded-lg border border-gray-600">
                <div class="px-6 py-4 border-b border-gray-600">
                    <h2 class="text-lg font-semibold text-white">
                        Empleados en el Paquete ({{ $paquete->empleados->count() }})
                    </h2>
                </div>
                
                @if($paquete->empleados->count() > 0)
                    <div class="divide-y divide-gray-600">
                        @foreach($paquete->empleados as $empleado)
                            <div class="px-6 py-4 flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-sm font-medium text-white">
                                            {{ $empleado->Nombre }} {{ $empleado->Apellido }}
                                        </h3>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $empleado->Validado ? 'bg-green-900 text-green-200 border border-green-600' : 'bg-red-900 text-red-200 border border-red-600' }}">
                                            {{ $empleado->Validado ? 'Validado' : 'Pendiente' }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm text-gray-400 mb-1">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <span class="font-medium">Sucursales:</span>
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm text-gray-300 mb-2 ml-5">
                                        @if($empleado->sucursales->count() > 0 || $empleado->sucursal)
                                            @php
                                                $todasSucursales = collect();
                                                if($empleado->sucursal) {
                                                    $todasSucursales->push($empleado->sucursal);
                                                }
                                                $todasSucursales = $todasSucursales->merge($empleado->sucursales)->unique('idSucursal');
                                            @endphp
                                            
                                            @foreach($todasSucursales as $index => $sucursal)
                                                <span class="inline-block bg-blue-900 text-blue-200 text-xs px-2 py-1 rounded-full mr-1 mb-1 border border-blue-600">
                                                    {{ $sucursal->Nombre }}
                                                </span>
                                            @endforeach
                                            
                                            @if($todasSucursales->count() > 1)
                                                <span class="text-xs text-blue-400 font-medium">
                                                    ({{ $todasSucursales->count() }} sucursales)
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-500 italic">Sin sucursales asignadas</span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-sm text-gray-400">
                                        <span>{{ $empleado->Puesto ?? 'Sin puesto' }}</span>
                                        @if($empleado->Correo)
                                            • <span>{{ $empleado->Correo }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2 ml-4">
                                    <!-- Botón Ver Detalles -->
                                    <a href="{{ route('empleados.show', $empleado->idEmpleado) }}" 
                                       class="inline-flex items-center px-2 py-1 border border-blue-400 rounded text-xs text-blue-300 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Ver Detalles
                                    </a>
                                    
                                    @if($paquete->puedeSerEditado())
                                        <button onclick="removerEmpleado({{ $paquete->idPaquete }}, {{ $empleado->idEmpleado }})"
                                                class="inline-flex items-center px-2 py-1 border border-red-400 rounded text-xs text-red-300 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500">
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
                    <div class="px-6 py-8 text-center text-gray-400">
                        No hay empleados en este paquete.
                    </div>
                @endif
            </div>
        </div>
    </div>
        </div>
    </div>

@if($paquete->puedeSerEditado())
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