<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                Plantillas de Credenciales
            </h2>
            <a href="{{ route('plantillas.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Plantilla
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if($plantillas->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($plantillas as $plantilla)
                                <div class="bg-gray-700 rounded-lg p-4 border-2 {{ $plantilla->activa ? 'border-green-500' : 'border-gray-600' }}">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 class="text-lg font-semibold text-white">{{ $plantilla->nombre }}</h3>
                                        @if($plantilla->activa)
                                            <span class="bg-green-600 text-white text-xs px-2 py-1 rounded">✓ Activa</span>
                                        @endif
                                    </div>

                                    <div class="space-y-3 mb-4">
                                        @if($plantilla->imagen_frontal)
                                            <div>
                                                <p class="text-xs text-gray-400 mb-1">Frontal:</p>
                                                <img src="{{ asset('storage/' . $plantilla->imagen_frontal) }}" 
                                                     alt="Plantilla Frontal" 
                                                     class="w-full h-32 object-contain bg-white rounded">
                                            </div>
                                        @endif
                                        @if($plantilla->imagen_trasera)
                                            <div>
                                                <p class="text-xs text-gray-400 mb-1">Trasera:</p>
                                                <img src="{{ asset('storage/' . $plantilla->imagen_trasera) }}" 
                                                     alt="Plantilla Trasera" 
                                                     class="w-full h-32 object-contain bg-white rounded">
                                            </div>
                                        @endif
                                        <p class="text-sm text-gray-300">
                                            📏 {{ $plantilla->ancho_mm }}mm × {{ $plantilla->alto_mm }}mm
                                        </p>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        @if(!$plantilla->activa)
                                            <form action="{{ route('plantillas.activar', $plantilla) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm">
                                                    Activar Plantilla
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('plantillas.edit', $plantilla) }}" 
                                           class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded text-center text-sm">
                                            Configurar Campos
                                        </a>
                                        <form action="{{ route('plantillas.destroy', $plantilla) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta plantilla?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-white">No hay plantillas creadas</h3>
                            <p class="mt-1 text-sm text-gray-400">Comienza creando tu primera plantilla de credencial</p>
                            <div class="mt-6">
                                <a href="{{ route('plantillas.create') }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Crear Primera Plantilla
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
