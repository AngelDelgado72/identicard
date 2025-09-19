<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar sucursal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 text-red-400">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('sucursales.update', $sucursal->idSucursal) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="idEmpresas" class="block text-sm font-medium text-white">Empresa</label>
                    <select name="idEmpresas" id="idEmpresas" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                        <option value="">Selecciona una empresa</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->idEmpresas }}" {{ $sucursal->idEmpresas == $empresa->idEmpresas ? 'selected' : '' }}>
                                {{ $empresa->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="Nombre" class="block text-sm font-medium text-white">Nombre de la sucursal</label>
                    <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre', $sucursal->Nombre) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Direccion" class="block text-sm font-medium text-white">Dirección</label>
                    <input type="text" name="Direccion" id="Direccion" value="{{ old('Direccion', $sucursal->Direccion) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Actualizar sucursal</button>
            </form>
        </div>
    </div>
</x-app-layout>