<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sucursales') }}
        </h2>
    </x-slot>
    
    <div class="w-full">
        <div class="mb-6 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Sucursales registradas
            </h3>
            <a href="{{ route('sucursales.create') }}" 
               class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">
                Registrar nueva sucursal
            </a>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <form method="GET" action="{{ route('sucursales.crud', ['empresa' => $empresaSeleccionada]) }}" class="flex flex-wrap gap-4">
                <select name="empresa_sucursal" 
                        class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Filtrar por empresa</option>
                    @foreach($todasEmpresas as $empresa)
                        <option value="{{ $empresa->idEmpresas }}" {{ (isset($empresaSeleccionada) && $empresaSeleccionada == $empresa->idEmpresas) ? 'selected' : '' }}>
                            {{ $empresa->Nombre }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="nombre_sucursal" placeholder="Filtrar por sucursal" value="{{ request('nombre_sucursal') }}"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    Filtrar
                </button>
            </form>
        </div>

        <!-- Tabla responsiva -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Empresa</th>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Empleados</th>
                            <th class="px-6 py-3">Dirección</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($sucursales as $sucursal)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $sucursal->empresa->Nombre ?? 'Sin empresa' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $sucursal->Nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    <a href="{{ route('sucursales.empleados', $sucursal->idSucursal) }}" 
                                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">
                                        Ver empleados
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                    {{ $sucursal->Direccion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('sucursales.edit', $sucursal->idSucursal) }}" 
                                           class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition text-xs">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('sucursales.destroy', $sucursal->idSucursal) }}" 
                                              onsubmit="return confirm('¿Seguro que deseas eliminar esta sucursal?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No hay sucursales registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($sucursales->hasPages())
            <div class="mt-6">
                {{ $sucursales->appends([
                    'empresas_page' => request('empresas_page'),
                    'empresa_sucursal' => request('empresa_sucursal'),
                    'nombre_sucursal' => request('nombre_sucursal')
                ])->links() }}
            </div>
        @endif
    </div>
</x-app-layout>