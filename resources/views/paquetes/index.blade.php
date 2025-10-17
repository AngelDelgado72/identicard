<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Paquetes de Impresión') }}
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Paquetes de Impresión</h1>
        <a href="{{ route('paquetes.create') }}" 
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Nuevo Paquete
        </a>
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

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nombre
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Descripción
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Fecha Creación
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estatus
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Creado Por
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Empleados
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($paquetes as $paquete)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $paquete->nombre }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ Str::limit($paquete->descripcion, 50) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $paquete->fecha_creacion->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $paquete->estatus === 'confirmado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $paquete->estatus === 'confirmado' ? 'Confirmado' : 'En Creación' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $paquete->creador->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <span class="font-medium">{{ $paquete->empleados->count() }}</span> empleados
                            </div>
                            @if($paquete->empleados->count() > 0)
                                <div class="text-xs text-gray-500">
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
                                    {{ $sucursalesCount }} sucursal{{ $sucursalesCount != 1 ? 'es' : '' }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('paquetes.show', $paquete->idPaquete) }}" 
                                   class="text-blue-600 hover:text-blue-900">Ver</a>
                                
                                @if($paquete->estatus === 'en_creacion')
                                    <a href="{{ route('paquetes.edit', $paquete->idPaquete) }}" 
                                       class="text-yellow-600 hover:text-yellow-900">Editar</a>
                                    
                                    <form method="POST" action="{{ route('paquetes.confirmar', $paquete->idPaquete) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                onclick="return confirm('¿Confirmar este paquete? No podrá ser modificado después.')"
                                                class="text-green-600 hover:text-green-900">Confirmar</button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('paquetes.destroy', $paquete->idPaquete) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('¿Eliminar este paquete?')"
                                                class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No hay paquetes creados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>