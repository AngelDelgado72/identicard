<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-lg font-semibold mb-4">¡Bienvenido al sistema!</h3>
            
            @auth
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @if(auth()->user()->hasPermission('empresas', 'ver'))
                        <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">Empresas</h4>
                            <p class="text-blue-600 dark:text-blue-300">Gestiona las empresas del sistema</p>
                            <a href="{{ route('empresas.crud') }}" class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Ver empresas
                            </a>
                        </div>
                    @endif

                    @if(auth()->user()->hasPermission('sucursales', 'ver'))
                        <div class="bg-green-100 dark:bg-green-900 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">Sucursales</h4>
                            <p class="text-green-600 dark:text-green-300">Administra las sucursales</p>
                            <a href="{{ route('sucursales.crud') }}" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Ver sucursales
                            </a>
                        </div>
                    @endif

                    @if(auth()->user()->hasPermission('empleados', 'ver'))
                        <div class="bg-purple-100 dark:bg-purple-900 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-2">Empleados</h4>
                            <p class="text-purple-600 dark:text-purple-300">Gestiona los empleados</p>
                            <a href="{{ route('empleados.crud') }}" class="inline-block mt-3 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                                Ver empleados
                            </a>
                        </div>
                    @endif
                </div>

                @if(auth()->user()->hasPermission('usuarios', 'ver') || auth()->user()->hasPermission('perfiles', 'ver'))
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-lg font-semibold mb-4">Administración del Sistema</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if(auth()->user()->hasPermission('perfiles', 'ver'))
                                <div class="bg-yellow-100 dark:bg-yellow-900 p-6 rounded-lg">
                                    <h5 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">Perfiles</h5>
                                    <p class="text-yellow-600 dark:text-yellow-300">Administra perfiles y permisos</p>
                                    <a href="{{ route('admin.perfiles.index') }}" class="inline-block mt-3 px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                        Gestionar perfiles
                                    </a>
                                </div>
                            @endif

                            @if(auth()->user()->hasPermission('usuarios', 'ver'))
                                <div class="bg-red-100 dark:bg-red-900 p-6 rounded-lg">
                                    <h5 class="font-semibold text-red-800 dark:text-red-200 mb-2">Usuarios</h5>
                                    <p class="text-red-600 dark:text-red-300">Administra usuarios del sistema</p>
                                    <a href="{{ route('admin.usuarios.index') }}" class="inline-block mt-3 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                        Gestionar usuarios
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mt-8 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <strong>Perfil:</strong> {{ auth()->user()->perfil->nombre ?? 'Sin perfil asignado' }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                        <strong>Permisos:</strong> 
                        {{ auth()->user()->perfil ? auth()->user()->perfil->permisos->count() : 0 }} permisos asignados
                    </p>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>