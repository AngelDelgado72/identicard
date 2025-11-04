<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Crear Nueva Plantilla de Credencial
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('plantillas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Nombre de la Plantilla *
                                </label>
                                <input type="text" 
                                       name="nombre" 
                                       value="{{ old('nombre') }}"
                                       required
                                       placeholder="Ej: Credencial Gas Jebla 2025"
                                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                @error('nombre')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dimensiones -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">
                                        Ancho (mm) *
                                    </label>
                                    <input type="number" 
                                           name="ancho_mm" 
                                           value="{{ old('ancho_mm', 86) }}"
                                           required
                                           min="50"
                                           step="1"
                                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2">
                                    <p class="text-xs text-gray-400 mt-1">Estándar: 86mm</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">
                                        Alto (mm) *
                                    </label>
                                    <input type="number" 
                                           name="alto_mm" 
                                           value="{{ old('alto_mm', 54) }}"
                                           required
                                           min="50"
                                           step="1"
                                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2">
                                    <p class="text-xs text-gray-400 mt-1">Estándar: 54mm</p>
                                </div>
                            </div>

                            <!-- Imagen Frontal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Imagen Frontal *
                                </label>
                                <input type="file" 
                                       name="imagen_frontal" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       required
                                       onchange="previewImage(this, 'preview-frontal')"
                                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                <p class="text-sm text-gray-400 mt-1">Formatos: JPG, PNG. Máximo 5MB</p>
                                <div id="preview-frontal" class="mt-3 hidden">
                                    <img src="" alt="Preview" class="max-w-md h-48 object-contain bg-white rounded">
                                </div>
                                @error('imagen_frontal')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imagen Trasera -->
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Imagen Trasera (Opcional)
                                </label>
                                <input type="file" 
                                       name="imagen_trasera" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       onchange="previewImage(this, 'preview-trasera')"
                                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                <p class="text-sm text-gray-400 mt-1">Formatos: JPG, PNG. Máximo 5MB</p>
                                <div id="preview-trasera" class="mt-3 hidden">
                                    <img src="" alt="Preview" class="max-w-md h-48 object-contain bg-white rounded">
                                </div>
                                @error('imagen_trasera')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-blue-900 border border-blue-600 rounded-lg p-4">
                                <p class="text-blue-200 text-sm">
                                    💡 <strong>Consejo:</strong> Después de crear la plantilla, podrás configurar la posición exacta 
                                    de cada campo (nombre, foto, puesto, etc.) arrastrándolos sobre la imagen.
                                </p>
                            </div>

                            <!-- Botones -->
                            <div class="flex gap-3">
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                    Crear Plantilla
                                </button>
                                <a href="{{ route('plantillas.index') }}" 
                                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const img = preview.querySelector('img');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
