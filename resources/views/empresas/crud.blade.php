<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Empresas') }}
        </h2>
    </x-slot>
    
    <div class="mt-8 flex gap-4 justify-center">
        <a href="{{ route('empresas.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Registrar nueva empresa
        </a>
    </div>

    <div class="mt-12 max-w-4xl mx-auto">
        <h3 class="text-lg font-semibold mb-4 text-white">Empresas registradas</h3>
        <form method="GET" action="{{ route('empresas.crud') }}" class="mb-6 flex gap-4">
            <input type="text" name="nombre" placeholder="Filtrar por nombre" value="{{ request('nombre') }}"
                class="px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-500 focus:outline-none focus:ring focus:border-blue-300">
            <input type="text" name="rfc" placeholder="Filtrar por RFC" value="{{ request('rfc') }}"
                class="px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-500 focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Filtrar</button>
        </form>
        <table class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">RFC</th>
                    <th class="px-4 py-2">Dirección</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empresas as $empresa)
                    <tr class="border-b border-gray-700">
                        <td class="px-4 py-2">
                            <a href="{{ route('sucursales.crud', ['empresa' => $empresa->idEmpresas]) }}" class="text-blue-400 hover:underline">
                                {{ $empresa->Nombre }}
                            </a>
                        </td>    
                        <td class="px-4 py-2">{{ $empresa->RFC }}</td>
                        <td class="px-4 py-2">{{ $empresa->Direccion }}</td>
                        <td class="px-4 py-2 flex gap-2 justify-center items-center">
                            <a href="{{ route('empresas.edit', $empresa->idEmpresas) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">Editar</a>
                            <form method="POST" action="{{ route('empresas.destroy', $empresa->idEmpresas) }}" onsubmit="return confirm('¿Seguro que deseas eliminar esta empresa?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-400">No hay empresas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $empresas->appends(['sucursales_page' => request('sucursales_page')])->links() }}
    </div>
</x-app-layout>