<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Empleados') }}
        </h2>
    </x-slot>

    <div class="w-full">
        <div class="mb-6 flex justify-between items-center">
            <div>
                @if(isset($sucursal))
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Empleados de la sucursal: {{ $sucursal->Nombre }}
                    </h3>
                @else
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Empleados registrados
                    </h3>
                @endif
            </div>
            @if(auth()->user()->hasPermission('empleados', 'crear'))
                <a href="{{ route('empleados.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    Registrar nuevo empleado
                </a>
            @endif
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <form method="GET" action="{{ route('empleados.crud') }}" class="flex flex-wrap gap-4">
                <input type="text" name="nombre" placeholder="Filtrar por nombre" value="{{ request('nombre') }}"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="departamento" placeholder="Filtrar por departamento" value="{{ request('departamento') }}"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="rfc" placeholder="Filtrar por RFC" value="{{ request('rfc') }}"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Filtrar
                </button>
            </form>
        </div>

        <!-- Tabla con scroll horizontal -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Apellido</th>
                            <th class="px-6 py-3">Correo</th>
                            <th class="px-6 py-3">Departamento</th>
                            <th class="px-6 py-3">RFC</th>
                            <th class="px-6 py-3">Sucursal</th>
                            <th class="px-6 py-3">Foto</th>
                            <th class="px-6 py-3">Firma</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($empleados as $empleado)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $empleado->Nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $empleado->Apellido }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $empleado->Correo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $empleado->Departamento }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $empleado->RFC }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    @forelse($empleado->sucursales as $sucursalItem)
                                        <a href="{{ route('sucursales.empleados', $sucursalItem->idSucursal) }}" 
                                           class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded text-xs mr-1 hover:bg-blue-200 dark:hover:bg-blue-800">
                                            {{ $sucursalItem->Nombre }}
                                        </a>
                                    @empty
                                        <span class="text-gray-400">Sin sucursal</span>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    @if($empleado->Foto)
                                        <img src="{{ asset($empleado->Foto) }}" alt="Foto" 
                                             class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                                    @else
                                        <span class="text-gray-400">Sin foto</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    @if($empleado->Firma)
                                        <img src="{{ asset($empleado->Firma) }}" alt="Firma" 
                                             class="h-10 w-20 object-contain rounded border border-gray-200 dark:border-gray-600 bg-white">
                                    @else
                                        <span class="text-gray-400">Sin firma</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($empleado->Validado)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Validado
                                        </span>
                                    @elseif($empleado->status === 'Completo')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Completo
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Incompleto
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('empleados.show', $empleado->idEmpleado) }}" 
                                           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-xs">
                                            Ver
                                        </a>
                                        @if(!$empleado->Validado && auth()->user()->hasPermission('empleados', 'editar'))
                                            <a href="{{ route('empleados.edit', $empleado->idEmpleado) }}" 
                                               class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition text-xs">
                                                Editar
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('empleados', 'eliminar'))
                                            <form method="POST" action="{{ route('empleados.destroy', $empleado->idEmpleado) }}" 
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este empleado?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No hay empleados registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($empleados->hasPages())
            <div class="mt-6">
                {{ $empleados->links() }}
            </div>
        @endif
    </div>
</x-app-layout>