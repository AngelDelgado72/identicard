<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle del empleado: {{ $empleado->Nombre }} {{ $empleado->Apellido }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información Personal -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2">Información Personal</h3>
                <div>
                    <strong class="text-white">Nombre:</strong> 
                    <span class="text-gray-300">{{ $empleado->Nombre }}</span>
                </div>
                <div>
                    <strong class="text-white">Apellido:</strong> 
                    <span class="text-gray-300">{{ $empleado->Apellido }}</span>
                </div>
                <div>
                    <strong class="text-white">Correo:</strong> 
                    <span class="text-gray-300">{{ $empleado->Correo ?? 'No registrado' }}</span>
                </div>
                <div>
                    <strong class="text-white">Tipo de Sangre:</strong> 
                    <span class="text-gray-300">{{ $empleado->TipoSangre ?? 'No registrado' }}</span>
                </div>
                <div>
                    <strong class="text-white">Código RH:</strong> 
                    <span class="text-gray-300">{{ $empleado->CodigoRH ?? 'No registrado' }}</span>
                </div>
                <div>
                    <strong class="text-white">Número Seguro Social:</strong> 
                    <span class="text-gray-300">{{ $empleado->NumeroSeguroSocial ?? 'No registrado' }}</span>
                </div>
                <div>
                    <strong class="text-white">RFC:</strong> 
                    <span class="text-gray-300">{{ $empleado->RFC ?? 'No registrado' }}</span>
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2">Información Laboral</h3>
                <div>
                    <strong class="text-white">Puesto:</strong> 
                    <span class="text-gray-300">{{ $empleado->Puesto ?? 'No registrado' }}</span>
                </div>
                <div>
                    <strong class="text-white">Departamento:</strong> 
                    <span class="text-gray-300">{{ $empleado->Departamento ?? 'No registrado' }}</span>
                </div>
                <div>
                    <strong class="text-white">Sucursales:</strong>
                    <div class="mt-2">
                        @forelse($empleado->sucursales as $sucursal)
                            <span class="inline-block bg-gray-700 px-2 py-1 rounded mr-1 mb-1">
                                {{ $sucursal->Nombre }}
                            </span>
                        @empty
                            <span class="text-gray-400">Sin sucursales asignadas</span>
                        @endforelse
                    </div>
                </div>
                <div>
                    <strong class="text-white">Estado de validación:</strong>
                    @if($empleado->Validado)
                        <span class="px-3 py-1 bg-blue-700 text-white rounded ml-2">Validado</span>
                    @else
                        <span class="px-3 py-1 bg-yellow-700 text-white rounded ml-2">Sin validar</span>
                    @endif
                </div>
                <div>
                    <strong class="text-white">Status de completitud:</strong>
                    @if($empleado->status === 'Completo')
                        <span class="px-3 py-1 bg-green-700 text-white rounded ml-2">Completo</span>
                    @else
                        <span class="px-3 py-1 bg-red-700 text-white rounded ml-2">Incompleto</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Imágenes -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Foto</h3>
                @if($empleado->Foto)
                    <img src="{{ asset($empleado->Foto) }}" alt="Foto del empleado" class="w-32 h-32 object-cover rounded border border-gray-600">
                @else
                    <div class="w-32 h-32 bg-gray-700 rounded border border-gray-600 flex items-center justify-center">
                        <span class="text-gray-400">Sin foto</span>
                    </div>
                @endif
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Firma</h3>
                @if($empleado->Firma)
                    <img src="{{ asset($empleado->Firma) }}" alt="Firma del empleado" class="w-32 h-32 object-contain rounded border border-gray-600 bg-white">
                @else
                    <div class="w-32 h-32 bg-gray-700 rounded border border-gray-600 flex items-center justify-center">
                        <span class="text-gray-400">Sin firma</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="mt-8 flex gap-3 justify-center">
            @if(!$empleado->Validado && $empleado->status === 'Completo')
                <form method="POST" action="{{ route('empleados.validar', $empleado->idEmpleado) }}">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="return confirm('¿Está seguro de validar este empleado? Una vez validado no podrá ser editado.')">
                        Validar Empleado
                    </button>
                </form>
            @endif
            
            @if(!$empleado->Validado)
                <a href="{{ route('empleados.edit', $empleado->idEmpleado) }}" class="px-6 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Editar
                </a>
            @endif
            
            <form method="POST" action="{{ route('empleados.destroy', $empleado->idEmpleado) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este empleado?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Eliminar
                </button>
            </form>
            
            <a href="{{ route('empleados.crud') }}" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                Volver al listado
            </a>
        </div>
    </div>
</x-app-layout>