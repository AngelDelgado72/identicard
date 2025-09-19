<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Empleados') }}
        </h2>
    </x-slot>

    <div class="mt-8 flex gap-4 justify-center">
        <a href="{{ route('empleados.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            Registrar nuevo empleado
        </a>
    </div>

    <div class="mt-12 max-w-6xl mx-auto">
        <h3 class="text-lg font-semibold mb-4 text-white">Empleados registrados</h3>
        <form method="GET" action="{{ route('empleados.crud') }}" class="mb-6 flex gap-4">
            <input type="text" name="nombre" placeholder="Filtrar por nombre" value="{{ request('nombre') }}"
                class="px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-500 focus:outline-none focus:ring focus:border-blue-300">
            <input type="text" name="departamento" placeholder="Filtrar por departamento" value="{{ request('departamento') }}"
                class="px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-500 focus:outline-none focus:ring focus:border-blue-300">
            <input type="text" name="rfc" placeholder="Filtrar por RFC" value="{{ request('rfc') }}"
                class="px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-500 focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filtrar</button>
        </form>
        <table class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Apellido</th>
                    <th class="px-4 py-2">Correo</th>
                    <th class="px-4 py-2">Departamento</th>
                    <th class="px-4 py-2">RFC</th>
                    <th class="px-4 py-2">Sucursal</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleados as $empleado)
                    <tr class="border-b border-gray-700">
                        <td class="px-4 py-2">{{ $empleado->Nombre }}</td>
                        <td class="px-4 py-2">{{ $empleado->Apellido }}</td>
                        <td class="px-4 py-2">{{ $empleado->Correo }}</td>
                        <td class="px-4 py-2">{{ $empleado->Departamento }}</td>
                        <td class="px-4 py-2">{{ $empleado->RFC }}</td>
                        <td class="px-4 py-2">
                            @forelse($empleado->sucursales as $sucursal)
                                <span class="inline-block bg-gray-700 px-2 py-1 rounded mr-1">{{ $sucursal->Nombre }}</span>
                            @empty
                                <span class="text-gray-400">Sin sucursal</span>
                            @endforelse
                        </td>
                        <td class="px-4 py-2 flex gap-2 justify-center items-center">
                            <a href="{{ route('empleados.edit', $empleado->idEmpleado) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">Editar</a>
                            <form method="POST" action="{{ route('empleados.destroy', $empleado->idEmpleado) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este empleado?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center text-gray-400">No hay empleados registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $empleados->links() }}
    </div>
</x-app-layout>