<x-layouts.auth.panetto>
    <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
        @csrf

        @if (session('status'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50"
                placeholder="tu@email.com">
            @error('email')
                <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Contraseña</label>
            <input type="password" name="password" required autocomplete="current-password"
                class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50"
                placeholder="••••••••">
            @error('password')
                <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                    class="w-4 h-4 text-panetto-orange border-gray-300 rounded focus:ring-panetto-orange">
                <span class="ml-2 text-sm text-gray-600">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-panetto-orange hover:underline font-medium">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full bg-panetto-orange text-white py-3 rounded-lg font-bold text-lg hover:bg-orange-600 transition shadow-md active:scale-95">
            INGRESAR
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('menu.show', ['slug' => 'panetto-libertad']) }}" class="text-sm text-gray-400 hover:text-panetto-orange">
            ← Volver al Menú
        </a>
    </div>
</x-layouts.auth.panetto>
