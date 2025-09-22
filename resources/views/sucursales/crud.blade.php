<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sucursales') }}
        </h2>
    </x-slot>
    
    <div class="mt-8 flex gap-4 justify-center">
        <a href="{{ route('sucursales.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
            Registrar nueva sucursal
        </a>
    </div>

    <div class="mt-12 max-w-4xl mx-auto">
        <h3 class="text-lg font-semibold mb-4 text-white">Sucursales registradas</h3>
        <form method="GET" action="{{ route('sucursales.crud', ['empresa' => $empresaSeleccionada]) }}" class="mb-6 flex gap-4">
            <select name="empresa_sucursal" class="px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-500 focus:outline-none focus:ring focus:border-blue-300">
                <option value="">Filtrar por empresa</option>
                @foreach($todasEmpresas as $empresa)
                    <option value="{{ $empresa->idEmpresas }}" {{ (isset($empresaSeleccionada) && $empresaSeleccionada == $empresa->idEmpresas) ? 'selected' : '' }}>
                        {{ $empresa->Nombre }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="nombre_sucursal" placeholder="Filtrar por sucursal" value="{{ request('nombre_sucursal') }}"
                class="px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-500 focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Filtrar</button>
        </form>
        <table class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="px-4 py-2">Empresa</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Empleados</th>
                    <th class="px-4 py-2">Dirección</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sucursales as $sucursal)
                    <tr class="border-b border-gray-700">
                        <td class="px-4 py-2">{{ $sucursal->empresa->Nombre ?? 'Sin empresa' }}</td>
                        <td class="px-4 py-2">{{ $sucursal->Nombre }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('sucursales.empleados', $sucursal->idSucursal) }}" class="text-blue-400 hover:underline">
                                Ver empleados
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ $sucursal->Direccion }}</td>
                        <td class="px-4 py-2 flex gap-2 justify-center items-center">
                            <a href="{{ route('sucursales.edit', $sucursal->idSucursal) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">Editar</a>
                            <form method="POST" action="{{ route('sucursales.destroy', $sucursal->idSucursal) }}" onsubmit="return confirm('¿Seguro que deseas eliminar esta sucursal?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-400">No hay sucursales registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $sucursales->appends([
            'empresas_page' => request('empresas_page'),
            'empresa_sucursal' => request('empresa_sucursal'),
            'nombre_sucursal' => request('nombre_sucursal')
        ])->links() }}
    </div>
</x-app-layout>