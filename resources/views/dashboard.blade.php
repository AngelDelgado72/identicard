<x-app-layout>
    <div class="flex min-h-screen bg-gray-900">
        <!-- Barra lateral -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col py-8 px-4">
            <h2 class="text-2xl font-bold mb-8 text-center">Panel</h2>
            <nav class="flex flex-col gap-4">
                <a href="{{ route('empresas.crud') }}" class="px-4 py-2 rounded hover:bg-blue-600 transition">Empresas</a>
                <a href="{{ route('sucursales.crud') }}" class="px-4 py-2 rounded hover:bg-purple-600 transition">Sucursales</a>
                <a href="{{ route('empleados.crud') }}" class="px-4 py-2 rounded hover:bg-green-600 transition">Empleados</a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-semibold text-white mb-8">Bienvenido al panel de control</h1>
            <p class="text-gray-300">Selecciona una opción en la barra lateral para gestionar empresas o sucursales.</p>
        </main>
    </div>
</x-app-layout>