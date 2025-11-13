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
                   class="px-4 py-2 text-white rounded-md hover:opacity-80 transition" style="background-color: #919090;">
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
                <button type="submit" class="px-4 py-2 text-white rounded-md hover:opacity-80 transition" style="background-color: #919090;">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    @if($empleado->Foto)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-green-600 dark:text-green-400 mx-auto">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-red-600 dark:text-red-400 mx-auto">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    @if($empleado->Firma)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-green-600 dark:text-green-400 mx-auto">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-red-600 dark:text-red-400 mx-auto">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
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
                                           class="text-white p-2 rounded transition hover:opacity-80"
                                           style="background-color: #919090;"
                                           title="Ver">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        @if(!$empleado->Validado && auth()->user()->hasPermission('empleados', 'editar'))
                                            <a href="{{ route('empleados.edit', $empleado->idEmpleado) }}" 
                                               class="text-white p-2 rounded transition hover:opacity-80"
                                               style="background-color: #919090;"
                                               title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('empleados', 'eliminar'))
                                            <form method="POST" action="{{ route('empleados.destroy', $empleado->idEmpleado) }}" 
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este empleado?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-white p-2 rounded transition hover:opacity-80"
                                                        style="background-color: #919090;"
                                                        title="Eliminar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
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