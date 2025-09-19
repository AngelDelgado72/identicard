<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white dark:bg-gray-900">
        <div class="w-full max-w-md p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-6">
                Iniciar sesión
            </h2>

            <!-- Estado de la sesión -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Correo electrónico -->
                <div class="mb-4">
                    <x-input-label for="email" :value="'Correo electrónico'" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:border-blue-500 focus:ring-blue-500 text-sm" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <x-input-label for="password" :value="'Contraseña'" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:border-blue-500 focus:ring-blue-500 text-sm" 
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Recuérdame -->
                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <input id="remember_me" type="checkbox" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="remember">
                        Recuérdame
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Botón -->
                <button type="submit" 
                    class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-150 text-sm">
                    Iniciar sesión
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
