<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar empresa') }}
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

            <form method="POST" action="{{ route('empresas.update', $empresa->idEmpresas) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="Nombre" class="block text-sm font-medium text-white">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre', $empresa->Nombre) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="RFC" class="block text-sm font-medium text-white">RFC</label>
                    <input type="text" name="RFC" id="RFC" value="{{ old('RFC', $empresa->RFC) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Direccion" class="block text-sm font-medium text-white">Dirección</label>
                    <input type="text" name="Direccion" id="Direccion" value="{{ old('Direccion', $empresa->Direccion) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Actualizar empresa</button>
            </form>
        </div>
    </div>
</x-app-layout>