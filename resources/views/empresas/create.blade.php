<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar nueva empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 text-green-400">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-red-400">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('empresas.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="Nombre" class="block text-sm font-medium text-white">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="RFC" class="block text-sm font-medium text-white">RFC</label>
                    <input type="text" name="RFC" id="RFC" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Direccion" class="block text-sm font-medium text-white">Dirección</label>
                    <input type="text" name="Direccion" id="Direccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Registrar empresa</button>
            </form>
        </div>
    </div>
</x-app-layout>