<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
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

        .sidebar-menu > ul > li > a {
            display: block;
            padding: 12px 20px;
            color: #d1d5db;
            text-decoration: none;
            border-bottom: 1px solid #4b5563;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-menu > ul > li > a:hover {
            background: #4b5563;
            color: #ffffff;
        }

        .sidebar-menu .submenu {
            background: #4b5563;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .sidebar-menu li:hover .submenu {
            max-height: 500px;
        }

        .sidebar-menu .submenu li a {
            padding: 10px 40px;
            color: #9ca3af;
            border-bottom: 1px solid #6b7280;
            font-size: 14px;
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
                            <h3 class="text-white font-semibold text-lg">🌐 Navegación Organizacional</h3>
                        </div>
                        <ul>
                            <li>
                                <a href="#" onclick="showDashboard()">
                                    <span class="menu-icon">🏠</span> Inicio
                                </a>
                            </li>


                            
                            @foreach ($menus as $key => $item)
                                @if ($item['parent'] != 0)
                                    @break
                                @endif
                                @include('partials.menu-item-sidebar', ['item' => $item])
                            @endforeach

                            <!-- Menús de administración -->
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
                        </ul>
                    </div>
                </div>

                <!-- Columna principal (derecha) -->
                <div class="main-column">
                    <div id="content-area">
                    <h3 class="text-lg font-semibold mb-4">¡Bienvenido al sistema!</h3>
                    
                    @auth
                        <!-- Estadísticas principales -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-lg text-center">
                                <div class="text-3xl font-bold text-blue-800 dark:text-blue-200">{{ $empresas->count() }}</div>
                                <div class="text-blue-600 dark:text-blue-300">Empresas</div>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 p-6 rounded-lg text-center">
                                <div class="text-3xl font-bold text-green-800 dark:text-green-200">
                                    {{ $empresas->sum(function($empresa) { return $empresa->sucursales->count(); }) }}
                                </div>
                                <div class="text-green-600 dark:text-green-300">Sucursales</div>
                            </div>
                            <div class="bg-purple-100 dark:bg-purple-900 p-6 rounded-lg text-center">
                                <div class="text-3xl font-bold text-purple-800 dark:text-purple-200">
                                    {{ $empresas->sum(function($empresa) { return $empresa->sucursales->sum(function($sucursal) { return $sucursal->empleados->count(); }); }) }}
                                </div>
                                <div class="text-purple-600 dark:text-purple-300">Empleados</div>
                            </div>
                        </div>

                        <!-- Tarjetas de acceso rápido -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            @if(auth()->user()->hasPermission('empresas', 'ver'))
                                <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-lg hover:shadow-lg transition-shadow">
                                    <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">🏢 Empresas</h4>
                                    <p class="text-blue-600 dark:text-blue-300 mb-4">Gestiona las empresas del sistema</p>
                                    <a href="{{ route('empresas.crud') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                        Ver empresas
                                    </a>
                                </div>
                            @endif

                            @if(auth()->user()->hasPermission('sucursales', 'ver'))
                                <div class="bg-green-100 dark:bg-green-900 p-6 rounded-lg hover:shadow-lg transition-shadow">
                                    <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">🏪 Sucursales</h4>
                                    <p class="text-green-600 dark:text-green-300 mb-4">Administra las sucursales</p>
                                    <a href="{{ route('sucursales.crud') }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                                        Ver sucursales
                                    </a>
                                </div>
                            @endif

                            @if(auth()->user()->hasPermission('empleados', 'ver'))
                                <div class="bg-purple-100 dark:bg-purple-900 p-6 rounded-lg hover:shadow-lg transition-shadow">
                                    <h4 class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-2">👤 Empleados</h4>
                                    <p class="text-purple-600 dark:text-purple-300 mb-4">Gestiona los empleados</p>
                                    <a href="{{ route('empleados.crud') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">
                                        Ver empleados
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Administración del Sistema -->
                        @if(auth()->user()->hasPermission('usuarios', 'ver') || auth()->user()->hasPermission('perfiles', 'ver'))
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-lg font-semibold mb-4">⚙️ Administración del Sistema</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if(auth()->user()->hasPermission('perfiles', 'ver'))
                                        <div class="bg-yellow-100 dark:bg-yellow-900 p-6 rounded-lg hover:shadow-lg transition-shadow">
                                            <h5 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">🛡️ Perfiles</h5>
                                            <p class="text-yellow-600 dark:text-yellow-300 mb-4">Administra perfiles y permisos</p>
                                            <a href="{{ route('admin.perfiles.index') }}" class="inline-block px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition-colors">
                                                Gestionar perfiles
                                            </a>
                                        </div>
                                    @endif

                                    @if(auth()->user()->hasPermission('usuarios', 'ver'))
                                        <div class="bg-red-100 dark:bg-red-900 p-6 rounded-lg hover:shadow-lg transition-shadow">
                                            <h5 class="font-semibold text-red-800 dark:text-red-200 mb-2">👥 Usuarios</h5>
                                            <p class="text-red-600 dark:text-red-300 mb-4">Administra usuarios del sistema</p>
                                            <a href="{{ route('admin.usuarios.index') }}" class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                                                Gestionar usuarios
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Información del usuario -->
                        <div class="mt-8 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        <strong>👤 Perfil:</strong> {{ auth()->user()->perfil->nombre ?? 'Sin perfil asignado' }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        <strong>🔐 Permisos:</strong> 
                                        {{ auth()->user()->perfil ? auth()->user()->perfil->permisos->count() : 0 }} permisos asignados
                                    </p>
                                </div>
                                <div>
                                    @if(auth()->user()->sucursales->count() > 0)
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            <strong>🏪 Sucursales asignadas:</strong> {{ auth()->user()->sucursales->count() }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            Solo verás las empresas/sucursales que tienes asignadas en el menú lateral
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            <strong>🌟 Acceso:</strong> Todas las sucursales
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            Tienes acceso completo a toda la estructura organizacional
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Consejos de navegación -->
                            <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900 rounded border-l-4 border-blue-400">
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    <strong>💡 Navegación:</strong> Usa el menú lateral para explorar la estructura organizacional. 
                                    Pasa el cursor sobre las empresas para ver sus sucursales y empleados.
                                </p>
                            </div>
                        </div>
                    @endauth
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

        function showDashboard() {
            const contentArea = document.getElementById('content-area');
            
            let accessCards = '';
            
            if (userPermissions.empresas) {
                accessCards += `
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-center">
                            <div class="text-4xl mb-3">🏢</div>
                            <h4 class="text-lg font-semibold mb-2">Gestión de Empresas</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Administra todas las empresas del sistema</p>
                            <a href="/empresas/crud" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                Gestionar Empresas
                            </a>
                        </div>
                    </div>
                `;
            }
            
            if (userPermissions.sucursales) {
                accessCards += `
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-center">
                            <div class="text-4xl mb-3">�</div>
                            <h4 class="text-lg font-semibold mb-2">Gestión de Sucursales</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Administra sucursales por empresa</p>
                            <a href="/sucursales/crud" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                                Gestionar Sucursales
                            </a>
                        </div>
                    </div>
                `;
            }
            
            if (userPermissions.empleados) {
                accessCards += `
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-center">
                            <div class="text-4xl mb-3">👤</div>
                            <h4 class="text-lg font-semibold mb-2">Gestión de Empleados</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Administra empleados y validaciones</p>
                            <a href="/empleados/crud" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">
                                Gestionar Empleados
                            </a>
                        </div>
                    </div>
                `;
            }
            
            // Restaurar el dashboard original ocupando todo el ancho
            contentArea.innerHTML = `
                <h3 class="text-lg font-semibold mb-4">¡Bienvenido al sistema!</h3>
                
                <!-- Estadísticas principales -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-lg text-center">
                        <div class="text-3xl font-bold text-blue-800 dark:text-blue-200">${dashboardStats.empresas}</div>
                        <div class="text-blue-600 dark:text-blue-300">Empresas</div>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900 p-6 rounded-lg text-center">
                        <div class="text-3xl font-bold text-green-800 dark:text-green-200">${dashboardStats.sucursales}</div>
                        <div class="text-green-600 dark:text-green-300">Sucursales</div>
                    </div>
                    <div class="bg-purple-100 dark:bg-purple-900 p-6 rounded-lg text-center">
                        <div class="text-3xl font-bold text-purple-800 dark:text-purple-200">${dashboardStats.empleados}</div>
                        <div class="text-purple-600 dark:text-purple-300">Empleados</div>
                    </div>
                </div>

                <!-- Accesos rápidos principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    ${accessCards}
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
                        <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-3">🏪 Sucursales (${empresa.sucursales.length})</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            ${empresa.sucursales.map(sucursal => `
                                <div class="bg-white dark:bg-gray-700 p-3 rounded border-l-4 border-green-500">
                                    <h5 class="font-semibold text-green-800 dark:text-green-200">${sucursal.nombre}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">ID: ${sucursal.id}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">📍 ${sucursal.direccion}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">📞 ${sucursal.telefono}</p>
                                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">👥 ${sucursal.empleados_count} empleados</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                sucursalesHtml = `
                    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                        <p class="text-gray-600 dark:text-gray-400">🏪 No hay sucursales registradas para esta empresa.</p>
                    </div>
                `;
            }
            
            return `
                <div class="mb-4">
                    <button onclick="showDashboard()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        ← Volver al Dashboard
                    </button>
                </div>
                <h1 class="text-2xl font-bold mb-6">🏢 ${empresa.nombre}</h1>
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
                        <a href="/sucursales/create?empresa=${empresa.id}" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                            ➕ Agregar Sucursal
                        </a>
                        <a href="/empresas/${empresa.id}/edit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                            📋 Editar Empresa
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
                        <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-3">👥 Empleados (${sucursal.empleados.length})</h4>
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
                                        <a href="/empleados/${empleado.id}" class="text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                            🔍 Ver Detalles
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
                        <p class="text-gray-600 dark:text-gray-400">👥 No hay empleados registrados en esta sucursal.</p>
                    </div>
                `;
            }
            
            return `
                <div class="mb-4">
                    <button onclick="showDashboard()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        ← Volver al Dashboard
                    </button>
                </div>
                <h1 class="text-2xl font-bold mb-6">🏪 ${sucursal.nombre}</h1>
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
                        <a href="/empleados/create?sucursal=${sucursal.id}" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">
                            ➕ Agregar Empleado
                        </a>
                        <a href="/sucursales/${sucursal.id}/edit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                            🏪 Editar Sucursal
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
                <h1 class="text-2xl font-bold mb-6">👤 ${empleado.nombre}</h1>
                <div class="bg-purple-50 dark:bg-purple-900 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-4">Información del Empleado</h3>
                    
                    <!-- Información organizacional -->
                    <div class="mb-4 p-3 bg-white dark:bg-gray-700 rounded border-l-4 border-blue-500">
                        <h4 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">🏢 Ubicación Organizacional</h4>
                        <p><strong>Empresa:</strong> <span class="text-blue-600 font-medium">${empleado.empresa.nombre}</span></p>
                        <p><strong>Sucursal:</strong> <span class="text-green-600 font-medium">${empleado.sucursal.nombre}</span></p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-2">👤 Datos Personales</h4>
                            <p><strong>Nombre:</strong> ${empleado.nombre}</p>
                            <p><strong>ID Empleado:</strong> ${empleado.id}</p>
                            <p><strong>Email:</strong> ${empleado.email}</p>
                            <p><strong>Tipo de Sangre:</strong> ${empleado.tipo_sangre}</p>
                            <p><strong>Código RH:</strong> ${empleado.codigo_rh}</p>
                            <p><strong>NSS:</strong> ${empleado.numero_seguro_social}</p>
                            <p><strong>RFC:</strong> ${empleado.rfc}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">💼 Datos Laborales</h4>
                            <p><strong>Puesto:</strong> ${empleado.puesto}</p>
                            <p><strong>Departamento:</strong> ${empleado.departamento}</p>
                            <p><strong>Validado:</strong> <span class="px-2 py-1 ${empleado.validado === 'Sí' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} rounded text-sm">${empleado.validado}</span></p>
                            <p><strong>Fecha de registro:</strong> ${empleado.created_at}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center space-x-4">
                        <a href="/empleados/${empleado.id}" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                            🔍 Ver Detalles y Validar
                        </a>
                        <a href="/empleados/${empleado.id}/edit" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">
                            ✏️ Editar Empleado
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