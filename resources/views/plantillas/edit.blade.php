<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Configurar Plantilla: {{ $plantilla->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('plantillas.update', $plantilla) }}" method="POST" id="form-plantilla" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Panel izquierdo - Campos disponibles -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-800 rounded-lg p-4 sticky top-4">
                            <h3 class="text-white font-semibold mb-4">📦 Campos Disponibles</h3>
                            <p class="text-xs text-gray-400 mb-4">Arrastra los campos a la plantilla</p>

                            <div class="space-y-2" id="campos-disponibles">
                                @foreach($camposDisponibles as $campo)
                                    <div class="campo-disponible bg-gray-700 hover:bg-gray-600 p-3 rounded cursor-move border border-gray-600"
                                         draggable="true"
                                         data-campo-id="{{ $campo['id'] }}"
                                         data-campo-nombre="{{ $campo['nombre'] }}"
                                         data-campo-tipo="{{ $campo['tipo'] }}">
                                        <span class="text-lg">{{ $campo['icono'] }}</span>
                                        <span class="text-sm text-white ml-2">{{ $campo['nombre'] }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-600">
                                <h4 class="text-white font-semibold mb-2">⚙️ Configuración</h4>
                                
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">Nombre</label>
                                        <input type="text" name="nombre" value="{{ $plantilla->nombre }}" 
                                               class="w-full bg-gray-700 text-white text-sm rounded px-2 py-1 border border-gray-600">
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-xs text-gray-400 mb-1">Ancho mm</label>
                                            <input type="number" name="ancho_mm" value="{{ $plantilla->ancho_mm }}" 
                                                   class="w-full bg-gray-700 text-white text-sm rounded px-2 py-1 border border-gray-600">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-400 mb-1">Alto mm</label>
                                            <input type="number" name="alto_mm" value="{{ $plantilla->alto_mm }}" 
                                                   class="w-full bg-gray-700 text-white text-sm rounded px-2 py-1 border border-gray-600">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="activa" value="1" {{ $plantilla->activa ? 'checked' : '' }}
                                                   class="rounded bg-gray-700 border-gray-600">
                                            <span class="ml-2 text-sm text-white">Plantilla activa</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                                    💾 Guardar Configuración
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Panel central - Editor de plantillas -->
                    <div class="lg:col-span-3">
                        <!-- Tabs -->
                        <div class="bg-gray-800 rounded-t-lg">
                            <div class="flex border-b border-gray-700">
                                <button type="button" onclick="switchTab('frontal')" id="tab-frontal"
                                        class="px-6 py-3 text-white font-semibold border-b-2 border-blue-500">
                                    🎴 Frontal
                                </button>
                                @if($plantilla->imagen_trasera)
                                <button type="button" onclick="switchTab('trasera')" id="tab-trasera"
                                        class="px-6 py-3 text-gray-400 font-semibold border-b-2 border-transparent hover:text-white">
                                    🎴 Trasera
                                </button>
                                @endif
                            </div>
                        </div>

                        <!-- Área de trabajo Frontal -->
                        <div id="area-frontal" class="bg-gray-700 rounded-b-lg p-8">
                            <div class="bg-white rounded-lg p-4 inline-block relative">
                                <div id="canvas-frontal" class="relative border-2 border-gray-300 bg-white" 
                                     style="width: {{ $plantilla->ancho_mm }}mm; height: {{ $plantilla->alto_mm }}mm; background-size: 100% 100%; background-repeat: no-repeat; background-position: top left; {{ $plantilla->imagen_frontal ? 'background-image: url(' . asset('storage/' . $plantilla->imagen_frontal) . ');' : '' }}">
                                    <!-- Los campos se insertarán aquí dinámicamente -->
                                </div>
                            </div>

                            <div class="mt-4 bg-gray-800 rounded p-3">
                                <p class="text-xs text-gray-300">
                                    💡 <strong>Cómo usar:</strong> Arrastra campos desde el panel izquierdo. Haz clic en un campo para ajustar tamaño y estilo.
                                    Haz clic derecho para eliminar. El canvas tiene el tamaño real de la credencial ({{ $plantilla->ancho_mm }}mm x {{ $plantilla->alto_mm }}mm).
                                </p>
                            </div>
                        </div>

                        <!-- Área de trabajo Trasera -->
                        @if($plantilla->imagen_trasera)
                        <div id="area-trasera" class="bg-gray-700 rounded-b-lg p-8 hidden">
                            <div class="bg-white rounded-lg p-4 inline-block relative">
                                <div id="canvas-trasera" class="relative border-2 border-gray-300 bg-white" 
                                     style="width: {{ $plantilla->ancho_mm }}mm; height: {{ $plantilla->alto_mm }}mm; background-size: 100% 100%; background-repeat: no-repeat; background-position: top left; background-image: url('{{ asset('storage/' . $plantilla->imagen_trasera) }}');">
                                    <!-- Los campos se insertarán aquí dinámicamente -->
                                </div>
                            </div>

                            <div class="mt-4 bg-gray-800 rounded p-3">
                                <p class="text-xs text-gray-300">
                                    💡 Configura la parte trasera de la credencial ({{ $plantilla->ancho_mm }}mm x {{ $plantilla->alto_mm }}mm)
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Panel de propiedades del campo seleccionado -->
                        <div id="panel-propiedades" class="mt-4 bg-gray-800 rounded-lg p-4 hidden">
                            <h4 class="text-white font-semibold mb-3">⚙️ Propiedades del Campo</h4>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Tamaño Fuente (px)</label>
                                    <input type="number" id="prop-fontsize" class="w-full bg-gray-700 text-white text-sm rounded px-2 py-1" value="14" min="8" max="72">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Ancho (px)</label>
                                    <input type="number" id="prop-width" class="w-full bg-gray-700 text-white text-sm rounded px-2 py-1" value="150" min="50" max="500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Alto (px)</label>
                                    <input type="number" id="prop-height" class="w-full bg-gray-700 text-white text-sm rounded px-2 py-1" value="100" min="20" max="400">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Color</label>
                                    <input type="color" id="prop-color" class="w-full bg-gray-700 text-white rounded px-2 py-1" value="#000000">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Negrita</label>
                                    <input type="checkbox" id="prop-bold" class="mt-2">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Alineación</label>
                                    <select id="prop-align" class="w-full bg-gray-700 text-white text-sm rounded px-2 py-1">
                                        <option value="left">Izquierda</option>
                                        <option value="center">Centro</option>
                                        <option value="right">Derecha</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs para guardar la configuración -->
                <input type="hidden" name="campos_frontal" id="input-campos-frontal">
                <input type="hidden" name="campos_trasera" id="input-campos-trasera">
            </form>
        </div>
    </div>

    <style>
        .campo-colocado {
            position: absolute;
            cursor: move;
            border: 2px dashed #3B82F6;
            background: rgba(59, 130, 246, 0.1);
            padding: 4px 8px;
            min-width: 100px;
            user-select: none;
        }
        
        .campo-colocado.selected {
            border-color: #10B981;
            background: rgba(16, 185, 129, 0.2);
        }
        
        .campo-colocado .campo-label {
            font-size: 12px;
            color: #1F2937;
            font-weight: 600;
            pointer-events: none;
        }
        
        .campo-disponible:active {
            opacity: 0.5;
        }
    </style>

    <script>
        let currentTab = 'frontal';
        let selectedElement = null;
        let isDragging = false;
        let offsetX = 0;
        let offsetY = 0;
        let camposColocados = {
            frontal: @json($plantilla->campos_frontal ?? []),
            trasera: @json($plantilla->campos_trasera ?? [])
        };

        // Inicializar campos existentes
        document.addEventListener('DOMContentLoaded', function() {
            cargarCamposExistentes();
        });

        function switchTab(tab) {
            currentTab = tab;
            
            // Actualizar tabs
            document.getElementById('tab-frontal').classList.remove('border-blue-500', 'text-white');
            document.getElementById('tab-frontal').classList.add('border-transparent', 'text-gray-400');
            
            if (document.getElementById('tab-trasera')) {
                document.getElementById('tab-trasera').classList.remove('border-blue-500', 'text-white');
                document.getElementById('tab-trasera').classList.add('border-transparent', 'text-gray-400');
            }
            
            document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-400');
            document.getElementById('tab-' + tab).classList.add('border-blue-500', 'text-white');
            
            // Mostrar/ocultar áreas
            document.getElementById('area-frontal').classList.toggle('hidden', tab !== 'frontal');
            if (document.getElementById('area-trasera')) {
                document.getElementById('area-trasera').classList.toggle('hidden', tab !== 'trasera');
            }
        }

        // Drag de campos disponibles
        document.querySelectorAll('.campo-disponible').forEach(campo => {
            campo.addEventListener('dragstart', function(e) {
                e.dataTransfer.setData('campo-id', this.dataset.campoId);
                e.dataTransfer.setData('campo-nombre', this.dataset.campoNombre);
                e.dataTransfer.setData('campo-tipo', this.dataset.campoTipo);
            });
        });

        // Drop en canvas
        ['frontal', 'trasera'].forEach(lado => {
            const canvas = document.getElementById('canvas-' + lado);
            if (!canvas) return;

            canvas.addEventListener('dragover', function(e) {
                e.preventDefault();
            });

            canvas.addEventListener('drop', function(e) {
                e.preventDefault();
                
                const campoId = e.dataTransfer.getData('campo-id');
                const campoNombre = e.dataTransfer.getData('campo-nombre');
                const campoTipo = e.dataTransfer.getData('campo-tipo');
                
                if (!campoId) return;

                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                agregarCampo(lado, campoId, campoNombre, campoTipo, x, y);
            });
        });

        function agregarCampo(lado, id, nombre, tipo, x, y, config = {}) {
            const canvas = document.getElementById('canvas-' + lado);
            const elemento = document.createElement('div');
            elemento.className = 'campo-colocado';
            elemento.dataset.campoId = id;
            elemento.dataset.tipo = tipo;
            
            const defaultConfig = {
                fontSize: config.fontSize || 14,
                width: tipo === 'imagen' ? (config.width || 100) : (config.width || 150),
                height: tipo === 'imagen' ? (config.height || 100) : (config.height || 20),
                color: config.color || '#000000',
                bold: config.bold || false,
                align: config.align || 'left'
            };

            elemento.style.left = x + 'px';
            elemento.style.top = y + 'px';
            elemento.style.width = defaultConfig.width + 'px';
            elemento.style.height = defaultConfig.height + 'px';
            
            if (tipo === 'texto') {
                elemento.style.fontSize = defaultConfig.fontSize + 'px';
                elemento.style.color = defaultConfig.color;
                elemento.style.fontWeight = defaultConfig.bold ? 'bold' : 'normal';
                elemento.style.textAlign = defaultConfig.align;
            }

            elemento.innerHTML = `<div class="campo-label">${nombre}</div>`;

            // Guardar configuración en el elemento
            elemento.dataset.config = JSON.stringify(defaultConfig);

            // Click para seleccionar
            elemento.addEventListener('click', function(e) {
                e.stopPropagation();
                seleccionarCampo(this);
            });

            // Click derecho para eliminar
            elemento.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                if (confirm('¿Eliminar este campo?')) {
                    this.remove();
                    actualizarConfiguracion();
                }
            });

            // Drag para mover
            elemento.addEventListener('mousedown', iniciarArrastre);

            canvas.appendChild(elemento);
            actualizarConfiguracion();
        }

        function seleccionarCampo(elemento) {
            if (selectedElement) {
                selectedElement.classList.remove('selected');
            }
            
            selectedElement = elemento;
            elemento.classList.add('selected');

            // Cargar propiedades
            const config = JSON.parse(elemento.dataset.config || '{}');
            document.getElementById('prop-fontsize').value = config.fontSize || 14;
            document.getElementById('prop-width').value = parseInt(elemento.style.width) || 150;
            document.getElementById('prop-height').value = parseInt(elemento.style.height) || 20;
            document.getElementById('prop-color').value = config.color || '#000000';
            document.getElementById('prop-bold').checked = config.bold || false;
            document.getElementById('prop-align').value = config.align || 'left';

            document.getElementById('panel-propiedades').classList.remove('hidden');

            // Actualizar al cambiar propiedades
            ['prop-fontsize', 'prop-width', 'prop-height', 'prop-color', 'prop-bold', 'prop-align'].forEach(id => {
                document.getElementById(id).addEventListener('input', actualizarPropiedades);
            });
        }

        function actualizarPropiedades() {
            if (!selectedElement) return;

            const config = {
                fontSize: parseInt(document.getElementById('prop-fontsize').value),
                width: parseInt(document.getElementById('prop-width').value),
                height: parseInt(document.getElementById('prop-height').value),
                color: document.getElementById('prop-color').value,
                bold: document.getElementById('prop-bold').checked,
                align: document.getElementById('prop-align').value
            };

            selectedElement.style.width = config.width + 'px';
            selectedElement.style.height = config.height + 'px';
            
            if (selectedElement.dataset.tipo === 'texto') {
                selectedElement.style.fontSize = config.fontSize + 'px';
                selectedElement.style.color = config.color;
                selectedElement.style.fontWeight = config.bold ? 'bold' : 'normal';
                selectedElement.style.textAlign = config.align;
            }

            selectedElement.dataset.config = JSON.stringify(config);
            actualizarConfiguracion();
        }

        function iniciarArrastre(e) {
            if (e.button !== 0) return; // Solo botón izquierdo

            isDragging = true;
            selectedElement = this;
            
            const rect = this.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;

            document.addEventListener('mousemove', moverElemento);
            document.addEventListener('mouseup', detenerArrastre);

            e.preventDefault();
        }

        function moverElemento(e) {
            if (!isDragging || !selectedElement) return;

            const canvas = selectedElement.parentElement;
            const rect = canvas.getBoundingClientRect();
            
            let newX = e.clientX - rect.left - offsetX;
            let newY = e.clientY - rect.top - offsetY;

            // Limitar al canvas
            newX = Math.max(0, Math.min(newX, rect.width - selectedElement.offsetWidth));
            newY = Math.max(0, Math.min(newY, rect.height - selectedElement.offsetHeight));

            selectedElement.style.left = newX + 'px';
            selectedElement.style.top = newY + 'px';
        }

        function detenerArrastre() {
            if (isDragging) {
                isDragging = false;
                actualizarConfiguracion();
                document.removeEventListener('mousemove', moverElemento);
                document.removeEventListener('mouseup', detenerArrastre);
            }
        }

        function cargarCamposExistentes() {
            ['frontal', 'trasera'].forEach(lado => {
                const campos = camposColocados[lado];
                if (!campos || !Array.isArray(campos)) return;

                campos.forEach(campo => {
                    agregarCampo(lado, campo.id, campo.nombre, campo.tipo, campo.x, campo.y, campo.config);
                });
            });
        }

        function actualizarConfiguracion() {
            ['frontal', 'trasera'].forEach(lado => {
                const canvas = document.getElementById('canvas-' + lado);
                if (!canvas) return;

                const campos = [];
                canvas.querySelectorAll('.campo-colocado').forEach(elemento => {
                    campos.push({
                        id: elemento.dataset.campoId,
                        nombre: elemento.querySelector('.campo-label').textContent,
                        tipo: elemento.dataset.tipo,
                        x: parseInt(elemento.style.left),
                        y: parseInt(elemento.style.top),
                        config: JSON.parse(elemento.dataset.config || '{}')
                    });
                });

                document.getElementById('input-campos-' + lado).value = JSON.stringify(campos);
            });
        }

        // Deseleccionar al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.campo-colocado') && selectedElement) {
                selectedElement.classList.remove('selected');
                selectedElement = null;
                document.getElementById('panel-propiedades').classList.add('hidden');
            }
        });

        // Guardar antes de enviar
        document.getElementById('form-plantilla').addEventListener('submit', function() {
            actualizarConfiguracion();
        });
    </script>
</x-app-layout>
