<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <!-- Meta tag CSRF para peticiones AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}"

    <!-- Estilos adicionales para el menú lateral -->
    <style>
        .sidebar-menu {
            background: #374151;
            min-height: 400px;
            width: 100%;
            border-radius: 0.5rem;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu > ul > li > div {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            color: #d1d5db;
            border-bottom: 1px solid #4b5563;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-menu > ul > li > div:hover {
            background: #4b5563;
        }

        .sidebar-menu > ul > li > div a {
            color: #d1d5db;
            text-decoration: none;
            flex: 1;
            transition: color 0.3s ease;
        }

        .sidebar-menu > ul > li > div:hover a {
            color: #ffffff;
        }

        .toggle-arrow-btn:hover {
            opacity: 0.8;
        }

        .sidebar-menu .submenu {
            background: #4b5563;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }

        /* Clase activa para menús expandidos */
        .sidebar-menu .submenu.active {
            max-height: 1000px;
        }

        .sidebar-menu .submenu li a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
            color: #9ca3af;
            border-bottom: 1px solid #6b7280;
            font-size: 14px;
            cursor: pointer;
        }

        .sidebar-menu .submenu li a:hover {
            background: #6b7280;
            color: #ffffff;
        }

        .sidebar-menu .submenu .submenu {
            background: #6b7280;
        }

        .sidebar-menu .submenu .submenu li a {
            padding: 8px 60px;
            color: #d1d5db;
            font-size: 13px;
        }

        .sidebar-menu .submenu .submenu li a:hover {
            background: #9ca3af;
            color: #ffffff;
        }

        /* Icono de flecha para indicar si está expandido o colapsado */
        .menu-arrow {
            display: inline-block;
            transition: transform 0.3s ease;
            width: 20px;
            height: 20px;
        }

        .menu-arrow.rotated {
            transform: rotate(180deg);
        }

        .main-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        .menu-icon {
            margin-right: 8px;
        }



        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .sidebar-column {
                order: -1;
            }
            
            .sidebar-menu {
                min-height: 200px;
            }

            .toggle-sidebar {
                display: none;
            }
        }
    </style>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Contenido en dos columnas -->
            <div class="main-content">
                <!-- Columna del menú lateral (izquierda) -->
                <div class="sidebar-column">
                    <div class="sidebar-menu" id="sidebar">
                        <div class="p-4 border-b border-gray-600">
                            <h3 class="text-white font-semibold text-lg flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                                </svg>
                                Navegación
                            </h3>
                        </div>
                        <ul>
                            <li>
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; color: #d1d5db; border-bottom: 1px solid #4b5563;">
                                    <a href="#" onclick="showDashboard()" style="flex: 1; display: flex; align-items: center; text-decoration: none; color: inherit;">
                                        <span class="menu-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                            </svg>
                                        </span>
                                        <span style="margin-left: 8px;">Inicio</span>
                                    </a>
                                </div>
                            </li>


                            
                            @foreach ($menus as $key => $item)
                                @if ($item['parent'] != 0)
                                    @break
                                @endif
                                @include('partials.menu-item-sidebar', ['item' => $item])
                            @endforeach

                            <!-- Menús de administración 
                            @if(auth()->user()->hasPermission('usuarios', 'ver') || auth()->user()->hasPermission('perfiles', 'ver'))
                                <li>
                                    <a href="#">
                                        <span class="menu-icon">⚙️</span>Administración
                                    </a>
                                    <ul class="submenu">
                                        @if(auth()->user()->hasPermission('perfiles', 'ver'))
                                            <li><a href="{{ route('admin.perfiles.index') }}">🛡️ Perfiles</a></li>
                                        @endif
                                        @if(auth()->user()->hasPermission('usuarios', 'ver'))
                                            <li><a href="{{ route('admin.usuarios.index') }}">� Usuarios</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            -->
                        </ul>
                    </div>
                </div>

                <!-- Columna principal (derecha) -->
                <div class="main-column">
                    <div id="content-area">
                        <!-- Mensaje inicial vacío - Se llenará cuando el usuario seleccione una empresa o sucursal -->
                        <div class="flex items-center justify-center h-full min-h-[400px]">
                            <div class="text-center text-gray-400 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 mx-auto mb-4 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                </svg>
                                <p class="text-lg font-medium mb-2">Selecciona una empresa o sucursal</p>
                                <p class="text-sm">Usa el menú lateral para navegar por la estructura organizacional</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript para funcionalidad del menú -->
    <script>
        // Variables con datos del dashboard
        const dashboardStats = {
            empresas: {{ $empresas->count() }},
            sucursales: {{ $empresas->sum(function($empresa) { return $empresa->sucursales->count(); }) }},
            empleados: {{ $empresas->sum(function($empresa) { return $empresa->sucursales->sum(function($sucursal) { return $sucursal->empleados->count(); }); }) }}
        };

        const userPermissions = {
            empresas: {{ auth()->user()->hasPermission('empresas', 'ver') ? 'true' : 'false' }},
            sucursales: {{ auth()->user()->hasPermission('sucursales', 'ver') ? 'true' : 'false' }},
            empleados: {{ auth()->user()->hasPermission('empleados', 'ver') ? 'true' : 'false' }}
        };

        // Función para toggle de submenús (expandir/colapsar) - solo para el botón de flecha
        function toggleSubmenuOnly(event, button) {
            event.preventDefault();
            event.stopPropagation();
            
            // Encontrar el elemento padre li
            const li = button.closest('li');
            const submenu = li.querySelector('.submenu');
            const arrow = button.querySelector('.menu-arrow');
            
            if (submenu) {
                // Toggle la clase active
                submenu.classList.toggle('active');
                
                // Rotar la flecha
                if (arrow) {
                    arrow.classList.toggle('rotated');
                }
            }
        }

        // Inicializar event listeners cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard cargado');
            
            // Verificar si el usuario tiene solo 1 sucursal asignada y redirigir automáticamente
            checkAutoRedirect();
        });

        // Función para verificar y auto-redirigir si solo hay 1 sucursal
        function checkAutoRedirect() {
            // Contar cuántas sucursales tiene el usuario en el menú
            const sucursalLinks = document.querySelectorAll('a[onclick*="sucursal-"]');
            
            if (sucursalLinks.length === 1) {
                // Solo hay 1 sucursal, obtener sus datos y cargar automáticamente
                const link = sucursalLinks[0];
                const onclickAttr = link.getAttribute('onclick');
                
                // Extraer los parámetros de loadContent
                const match = onclickAttr.match(/loadContent\('([^']+)',\s*'([^']+)',\s*'([^']+)'\)/);
                
                if (match) {
                    const type = match[1];
                    const slug = match[2];
                    const name = match[3];
                    
                    console.log('Auto-cargando única sucursal:', name);
                    loadContent(type, slug, name);
                }
            }
        }

        function showDashboard() {
            const contentArea = document.getElementById('content-area');
            
            // Mostrar el mensaje vacío inicial
            contentArea.innerHTML = `
                <!-- Mensaje inicial vacío - Se llenará cuando el usuario seleccione una empresa o sucursal -->
                <div class="flex items-center justify-center h-full min-h-[400px]">
                    <div class="text-center text-gray-400 dark:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 mx-auto mb-4 opacity-50">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                        <p class="text-lg font-medium mb-2">Selecciona una empresa o sucursal</p>
                        <p class="text-sm">Usa el menú lateral para navegar por la estructura organizacional</p>
                    </div>
                </div>
            `;
        }

        function loadContent(type, id, name) {
            console.log('Cargando contenido:', type, id, name);
            
            const contentArea = document.getElementById('content-area');
            
            // Mostrar loading
            contentArea.innerHTML = `
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                    <h3 class="mt-4 text-lg font-semibold">Cargando información...</h3>
                </div>
            `;
            
            // Determinar el tipo basado en el slug (id)
            let entityType = 'empleado'; // Por defecto
            let realId = id;
            
            if (id.startsWith('empresa-')) {
                entityType = 'empresa';
                realId = id.replace('empresa-', '');
            } else if (id.startsWith('sucursal-')) {
                entityType = 'sucursal';
                realId = id.replace('sucursal-', '');
            } else if (id.startsWith('empleado-')) {
                entityType = 'empleado';
                realId = id.replace('empleado-', '');
            }
            
            console.log('Tipo detectado:', entityType, 'ID real:', realId);
            
            // Hacer petición AJAX a la API correspondiente
            const apiUrl = `/api/${entityType}/${realId}`;
            
            fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let content = '';
                    switch(entityType) {
                        case 'empresa':
                            content = generateEmpresaContentReal(data.data);
                            break;
                        case 'sucursal':
                            content = generateSucursalContentReal(data.data);
                            break;
                        case 'empleado':
                            content = generateEmpleadoContentReal(data.data);
                            break;
                    }
                    contentArea.innerHTML = content;
                } else {
                    contentArea.innerHTML = `
                        <div class="bg-red-50 dark:bg-red-900 p-6 rounded-lg">
                            <h3 class="text-red-800 dark:text-red-200 font-semibold">Error</h3>
                            <p class="text-red-600 dark:text-red-300">${data.message}</p>
                            <button onclick="showDashboard()" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                ← Volver al Dashboard
                            </button>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                contentArea.innerHTML = `
                    <div class="bg-red-50 dark:bg-red-900 p-6 rounded-lg">
                        <h3 class="text-red-800 dark:text-red-200 font-semibold">Error de conexión</h3>
                        <p class="text-red-600 dark:text-red-300">No se pudo cargar la información.</p>
                        <button onclick="showDashboard()" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            ← Volver al Dashboard
                        </button>
                    </div>
                `;
            });
        }

        function generateEmpresaContentReal(empresa) {
            let sucursalesHtml = '';
            if (empresa.sucursales && empresa.sucursales.length > 0) {
                sucursalesHtml = `
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                            </svg>
                            Sucursales (${empresa.sucursales.length})
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            ${empresa.sucursales.map(sucursal => `
                                <div class="bg-white dark:bg-gray-700 p-3 rounded border-l-4 border-green-500">
                                    <h5 class="font-semibold text-green-800 dark:text-green-200">${sucursal.nombre}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">ID: ${sucursal.id}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        ${sucursal.direccion}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                        </svg>
                                        ${sucursal.telefono}
                                    </p>
                                    <p class="text-sm text-green-600 dark:text-green-400 font-medium flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                        ${sucursal.empleados_count} empleados
                                    </p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                sucursalesHtml = `
                    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                        <p class="text-gray-600 dark:text-gray-400 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                            </svg>
                            No hay sucursales registradas para esta empresa.
                        </p>
                    </div>
                `;
            }
            
            return `
                <div class="mb-4">
                    <button onclick="showDashboard()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        ← Volver al Dashboard
                    </button>
                </div>
                <h1 class="text-2xl font-bold mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                    </svg>
                    ${empresa.nombre}
                </h1>
                <div class="bg-blue-50 dark:bg-blue-900 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-4">Información de la Empresa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p><strong>ID:</strong> ${empresa.id}</p>
                            <p><strong>Nombre:</strong> ${empresa.nombre}</p>
                            <p><strong>RFC:</strong> ${empresa.rfc}</p>
                        </div>
                        <div>
                            <p><strong>Dirección:</strong> ${empresa.direccion}</p>
                            <p><strong>Fecha de registro:</strong> ${empresa.created_at}</p>
                            <p><strong>Estado:</strong> <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">Activa</span></p>
                        </div>
                    </div>
                    ${sucursalesHtml}
                    <div class="mt-6 text-center space-x-4">
                        <a href="/sucursales/create?empresa=${empresa.id}" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Agregar Sucursal
                        </a>
                        <a href="/empresas/${empresa.id}/edit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Editar Empresa
                        </a>
                    </div>
                </div>
            `;
        }

        function generateSucursalContentReal(sucursal) {
            let empleadosHtml = '';
            if (sucursal.empleados && sucursal.empleados.length > 0) {
                empleadosHtml = `
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            Empleados (${sucursal.empleados.length})
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            ${sucursal.empleados.map(empleado => `
                                <div class="bg-white dark:bg-gray-700 p-3 rounded border-l-4 border-purple-500">
                                    <h5 class="font-semibold text-purple-800 dark:text-purple-200">${empleado.nombre}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">ID: ${empleado.id}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Puesto: ${empleado.puesto || 'No definido'}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Correo: ${empleado.correo || 'No definido'}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Departamento: ${empleado.departamento || 'No definido'}</p>
                                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">RFC: ${empleado.rfc || 'No definido'}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tipo de sange: ${empleado.tipo_sangre || 'No definido'}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Validado: ${empleado.validado}</p>
                                    <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                        <a href="/empleados/${empleado.id}" class="text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                empleadosHtml = `
                    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                        <p class="text-gray-600 dark:text-gray-400 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            No hay empleados registrados en esta sucursal.
                        </p>
                    </div>
                `;
            }
            
            return `
                <div class="mb-4">
                    <button onclick="showDashboard()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        ← Volver al Dashboard
                    </button>
                </div>
                <h1 class="text-2xl font-bold mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                    </svg>
                    ${sucursal.nombre}
                </h1>
                <div class="bg-green-50 dark:bg-green-900 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-4">Información de la Sucursal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p><strong>ID:</strong> ${sucursal.id}</p>
                            <p><strong>Nombre:</strong> ${sucursal.nombre}</p>
                            <p><strong>Empresa:</strong> <span class="text-blue-600 font-medium">${sucursal.empresa.nombre}</span></p>
                        </div>
                        <div>
                            <p><strong>Dirección:</strong> ${sucursal.direccion}</p>
                            <p><strong>Fecha de registro:</strong> ${sucursal.created_at}</p>
                            <p><strong>Estado:</strong> <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">Activa</span></p>
                        </div>
                    </div>
                    ${empleadosHtml}
                    <div class="mt-6 text-center space-x-4">
                        <a href="/empleados/create?sucursal=${sucursal.id}" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Agregar Empleado
                        </a>
                        <a href="/sucursales/${sucursal.id}/edit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Editar Sucursal
                        </a>
                    </div>
                </div>
            `;
        }

        function generateEmpleadoContentReal(empleado) {
            return `
                <div class="mb-4">
                    <button onclick="showDashboard()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        ← Volver al Dashboard
                    </button>
                </div>
                <h1 class="text-2xl font-bold mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    ${empleado.nombre}
                </h1>
                <div class="bg-purple-50 dark:bg-purple-900 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-4">Información del Empleado</h3>
                    
                    <!-- Información organizacional -->
                    <div class="mb-4 p-3 bg-white dark:bg-gray-700 rounded border-l-4 border-blue-500">
                        <h4 class="font-semibold text-blue-800 dark:text-blue-200 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>
                            Ubicación Organizacional
                        </h4>
                        <p><strong>Empresa:</strong> <span class="text-blue-600 font-medium">${empleado.empresa.nombre}</span></p>
                        <p><strong>Sucursal:</strong> <span class="text-green-600 font-medium">${empleado.sucursal.nombre}</span></p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Datos Personales
                            </h4>
                            <p><strong>Nombre:</strong> ${empleado.nombre}</p>
                            <p><strong>ID Empleado:</strong> ${empleado.id}</p>
                            <p><strong>Email:</strong> ${empleado.email}</p>
                            <p><strong>Tipo de Sangre:</strong> ${empleado.tipo_sangre}</p>
                            <p><strong>Código RH:</strong> ${empleado.codigo_rh}</p>
                            <p><strong>NSS:</strong> ${empleado.numero_seguro_social}</p>
                            <p><strong>RFC:</strong> ${empleado.rfc}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                </svg>
                                Datos Laborales
                            </h4>
                            <p><strong>Puesto:</strong> ${empleado.puesto}</p>
                            <p><strong>Departamento:</strong> ${empleado.departamento}</p>
                            <p><strong>Validado:</strong> <span class="px-2 py-1 ${empleado.validado === 'Sí' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} rounded text-sm">${empleado.validado}</span></p>
                            <p><strong>Fecha de registro:</strong> ${empleado.created_at}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center space-x-4">
                        <a href="/empleados/${empleado.id}" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                            Ver Detalles y Validar
                        </a>
                        <a href="/empleados/${empleado.id}/edit" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Editar Empleado
                        </a>
                    </div>
                </div>
            `;
        }

        function generateDefaultContent(type, id, name) {
            return `
                <div class="mb-4">
                    <button onclick="showDashboard()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        ← Volver al Dashboard
                    </button>
                </div>
                <h1 class="text-2xl font-bold mb-6">${name}</h1>
                <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-lg">
                    <div>
                        <p><strong>Nombre:</strong> ${name}</p>
                        <p><strong>ID:</strong> ${id}</p>
                        <p><strong>Tipo:</strong> ${type}</p>
                    </div>
                </div>
            `;
        }
    </script>
</x-app-layout>