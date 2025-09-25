<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Empresas') }}
        </h2>
    </x-slot>
    
    <div class="w-full">
        <div class="mb-6 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Empresas registradas
            </h3>
            <a href="{{ route('empresas.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Registrar nueva empresa
            </a>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <form method="GET" action="{{ route('empresas.crud') }}" class="flex flex-wrap gap-4">
                <input type="text" name="nombre" placeholder="Filtrar por nombre" value="{{ request('nombre') }}"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="rfc" placeholder="Filtrar por RFC" value="{{ request('rfc') }}"
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
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">RFC</th>
                            <th class="px-6 py-3">Dirección</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($empresas as $empresa)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('sucursales.crud', ['empresa' => $empresa->idEmpresas]) }}" 
                                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium hover:underline">
                                        {{ $empresa->Nombre }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $empresa->RFC }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                    {{ $empresa->Direccion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('empresas.edit', $empresa->idEmpresas) }}" 
                                           class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition text-xs">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('empresas.destroy', $empresa->idEmpresas) }}" 
                                              onsubmit="return confirm('¿Seguro que deseas eliminar esta empresa?');" class="inline">
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
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No hay empresas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($empresas->hasPages())
            <div class="mt-6">
                {{ $empresas->appends(['sucursales_page' => request('sucursales_page')])->links() }}
            </div>
        @endif
    </div>
</x-app-layout>