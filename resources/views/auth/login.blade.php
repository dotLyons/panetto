<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Panetto</title>
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
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-panetto-light min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="text-center mb-8">
            <a href="{{ route('admin.index') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Panetto" class="w-24 h-24 mx-auto rounded-full shadow-lg border-4 border-panetto-orange">
            </a>
            <h1 class="text-3xl font-bold text-panetto-dark mt-4 tracking-wide">PANETTO</h1>
            <p class="text-gray-500 text-sm mt-1">Acceso Administrativo</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-panetto-orange">
            <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                @csrf

                @if (session('status'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50"
                        placeholder="tu@email.com">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contraseña</label>
                    <input type="password" name="password" required autocomplete="current-password"
                        class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 text-panetto-orange border-gray-300 rounded focus:ring-panetto-orange">
                        <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-panetto-orange text-white py-3 rounded-lg font-bold text-lg hover:bg-orange-600 transition shadow-md active:scale-95">
                    INGRESAR
                </button>
            </form>
        </div>
    </div>
</body>

</html>
