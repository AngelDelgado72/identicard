<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🏢 {{ $empresa->Nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información de la empresa -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ $empresa->Nombre }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                RFC: {{ $empresa->RFC ?? 'No especificado' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $empresa->sucursales->count() }} Sucursales
                            </span>
                        </div>
                    </div>

                    @if(auth()->user()->hasPermission('empresas', 'editar'))
                        <div class="flex space-x-2 mb-4">
                            <a href="{{ route('empresas.edit', $empresa->idEmpresas) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Editar Empresa
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sucursales de la empresa -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            🏪 Sucursales
                        </h4>
                        @if(auth()->user()->hasPermission('sucursales', 'crear'))
                            <a href="{{ route('sucursales.create') }}?empresa={{ $empresa->idEmpresas }}" 
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                + Nueva Sucursal
                            </a>
                        @endif
                    </div>

                    @if($empresa->sucursales->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($empresa->sucursales as $sucursal)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h5 class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $sucursal->Nombre }}
                                        </h5>
                                        <span class="text-xs text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                            {{ $sucursal->empleados->count() }} empleados
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        📍 {{ $sucursal->Direccion ?? 'Dirección no especificada' }}
                                    </p>

                                    <div class="flex space-x-2">
                                        @if(auth()->user()->hasPermission('sucursales', 'ver'))
                                            <a href="{{ route('dashboard.sucursal', $sucursal->idSucursal) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm">
                                                Ver detalle
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('sucursales', 'editar'))
                                            <a href="{{ route('sucursales.edit', $sucursal->idSucursal) }}" 
                                               class="text-green-600 hover:text-green-800 text-sm">
                                                Editar
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p>Esta empresa no tiene sucursales registradas.</p>
                            @if(auth()->user()->hasPermission('sucursales', 'crear'))
                                <a href="{{ route('sucursales.create') }}?empresa={{ $empresa->idEmpresas }}" 
                                   class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                                    Crear la primera sucursal
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navegación -->
            <div class="mt-6 text-center">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded">
                    ← Volver al Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>