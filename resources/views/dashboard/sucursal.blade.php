<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🏪 {{ $sucursal->Nombre }} - {{ $sucursal->empresa->Nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información de la sucursal -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ $sucursal->Nombre }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                📍 {{ $sucursal->Direccion ?? 'Dirección no especificada' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Empresa: {{ $sucursal->empresa->Nombre }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                {{ $sucursal->empleados->count() }} Empleados
                            </span>
                        </div>
                    </div>

                    @if(auth()->user()->hasPermission('sucursales', 'editar'))
                        <div class="flex space-x-2 mb-4">
                            <a href="{{ route('sucursales.edit', $sucursal->idSucursal) }}" 
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Editar Sucursal
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Empleados de la sucursal -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            👥 Empleados
                        </h4>
                        @if(auth()->user()->hasPermission('empleados', 'crear'))
                            <a href="{{ route('empleados.create') }}?sucursal={{ $sucursal->idSucursal }}" 
                               class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-sm">
                                + Nuevo Empleado
                            </a>
                        @endif
                    </div>

                    @if($sucursal->empleados->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Empleado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Puesto
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Departamento
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Correo
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($sucursal->empleados as $empleado)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8">
                                                        <div class="h-8 w-8 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                                            <span class="text-purple-600 dark:text-purple-400 text-sm font-medium">
                                                                {{ substr($empleado->Nombre, 0, 1) }}{{ substr($empleado->Apellido ?? '', 0, 1) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ $empleado->Nombre }} {{ $empleado->Apellido }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            RFC: {{ $empleado->RFC ?? 'No especificado' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $empleado->Puesto ?? 'No especificado' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $empleado->Departamento ?? 'No especificado' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $empleado->Correo ?? 'No especificado' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                @if(auth()->user()->hasPermission('empleados', 'ver'))
                                                    <a href="{{ route('empleados.show', $empleado->idEmpleado) }}" 
                                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        Ver
                                                    </a>
                                                @endif
                                                @if(auth()->user()->hasPermission('empleados', 'editar'))
                                                    <a href="{{ route('empleados.edit', $empleado->idEmpleado) }}" 
                                                       class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                        Editar
                                                    </a>
                                                @endif
                                                @if(auth()->user()->hasPermission('empleados', 'eliminar'))
                                                    <form method="POST" action="{{ route('empleados.destroy', $empleado->idEmpleado) }}" 
                                                          class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este empleado?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p>Esta sucursal no tiene empleados registrados.</p>
                            @if(auth()->user()->hasPermission('empleados', 'crear'))
                                <a href="{{ route('empleados.create') }}?sucursal={{ $sucursal->idSucursal }}" 
                                   class="inline-block mt-2 text-purple-600 hover:text-purple-800">
                                    Registrar el primer empleado
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navegación -->
            <div class="mt-6 text-center space-x-4">
                <a href="{{ route('dashboard.empresa', $sucursal->empresa->idEmpresas) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                    ← Ver Empresa
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded">
                    🏠 Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>