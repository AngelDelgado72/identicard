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
               class="px-4 py-2 text-white rounded-md hover:opacity-80 transition" style="background-color: #919090;">
                Registrar nueva empresa
            </a>
        </div>

        <!-- Filtros 
        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <form method="GET" action="{{ route('empresas.crud') }}" class="flex flex-wrap gap-4">
                <input type="text" name="nombre" placeholder="Filtrar por nombre" value="{{ request('nombre') }}"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="rfc" placeholder="Filtrar por RFC" value="{{ request('rfc') }}"
                    class="px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 text-white rounded-md hover:opacity-80 transition" style="background-color: #919090;">
                    Filtrar
                </button>
            </form>
        </div>
        -->

        <!-- Tabla responsiva -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">RFC</th>
                            <th class="px-6 py-3">Dirección</th>
                            <th class="px-6 py-3">Sucursales</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($empresas as $empresa)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                    {{ $empresa->Nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $empresa->RFC }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                    {{ $empresa->Direccion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('sucursales.crud', ['empresa' => $empresa->idEmpresas]) }}" 
                                       class="hover:underline font-medium"
                                       style="color: #919090;">
                                        Ver sucursales
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <!-- Editar -->
                                        <a href="{{ route('empresas.edit', $empresa->idEmpresas) }}" 
                                           class="px-3 py-1.5 text-white rounded hover:opacity-80 transition inline-flex items-center justify-center" 
                                           style="background-color: #919090;"
                                           title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>
                                        
                                        <!-- Eliminar -->
                                        <form method="POST" action="{{ route('empresas.destroy', $empresa->idEmpresas) }}" 
                                              onsubmit="return confirm('¿Seguro que deseas eliminar esta empresa?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1.5 text-white rounded hover:opacity-80 transition inline-flex items-center justify-center" 
                                                    style="background-color: #919090;"
                                                    title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
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