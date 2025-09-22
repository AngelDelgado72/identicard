<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar nuevo empleado') }}
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

            <form method="POST" action="{{ route('empleados.store') }}" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="Nombre" class="block text-sm font-medium text-white">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Apellido" class="block text-sm font-medium text-white">Apellido</label>
                    <input type="text" name="Apellido" id="Apellido" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Correo" class="block text-sm font-medium text-white">Correo</label>
                    <input type="email" name="Correo" id="Correo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="TipoSangre" class="block text-sm font-medium text-white">Tipo de Sangre</label>
                    <input type="text" name="TipoSangre" id="TipoSangre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="NumeroSeguroSocial" class="block text-sm font-medium text-white">Número de Seguro Social</label>
                    <input type="text" name="NumeroSeguroSocial" id="NumeroSeguroSocial" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="CodigoRH" class="block text-sm font-medium text-white">Código RH</label>
                    <input type="text" name="CodigoRH" id="CodigoRH" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Puesto" class="block text-sm font-medium text-white">Puesto</label>
                    <input type="text" name="Puesto" id="Puesto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Departamento" class="block text-sm font-medium text-white">Departamento</label>
                    <input type="text" name="Departamento" id="Departamento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="RFC" class="block text-sm font-medium text-white">RFC</label>
                    <input type="text" name="RFC" id="RFC" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Firma" class="block text-sm font-medium text-white">Firma</label>
                    <input type="file" name="Firma" id="Firma" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="Foto" class="block text-sm font-medium text-white">Foto</label>
                    <input type="file" name="Foto" id="Foto" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                </div>
                <div>
                    <label for="sucursales" class="block text-sm font-medium text-white">Sucursales</label>
                    <select name="sucursales[]" id="sucursales" multiple required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-800 text-white">
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->idSucursal }}">{{ $sucursal->Nombre }}</option>
                        @endforeach
                    </select>
                    <small class="text-gray-400">Mantén presionada Ctrl (Windows) o Cmd (Mac) para seleccionar varias sucursales.</small>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Registrar empleado</button>
            </form>
        </div>
    </div>
</x-app-layout>