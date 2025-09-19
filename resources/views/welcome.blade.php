<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Identicard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] min-h-screen">
    <div class="absolute top-6 right-8 flex gap-4">
        <a
            href="{{ route('login') }}"
            class="inline-block px-5 py-2 border border-[#19140035] text-[#1b1b18] rounded-sm text-base leading-normal hover:border-[#1915014a]"
        >
            Iniciar sesión
        </a>
        <a
            href="{{ route('register') }}"
            class="inline-block px-5 py-2 border border-green-600 bg-green-600 text-white rounded-sm text-base leading-normal hover:bg-green-700 hover:border-green-700"
        >
            Registrarse
        </a>
    </div>
</body>
</html>