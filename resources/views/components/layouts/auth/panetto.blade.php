<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Iniciar Sesión - Panetto' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'panetto-orange': '#F97316',
                        'panetto-light': '#FFF7ED',
                        'panetto-dark': '#1F2937',
                        'panetto-accent': '#FFEDD5',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-panetto-light min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('admin.index') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Panetto" class="w-24 h-24 mx-auto rounded-full shadow-lg border-4 border-panetto-orange">
            </a>
            <h1 class="text-3xl font-bold text-panetto-dark mt-4 tracking-wide">PANETTO</h1>
            <p class="text-gray-500 text-sm mt-1">Acceso Administrativo</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-panetto-orange">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
