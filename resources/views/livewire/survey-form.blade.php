<div class="min-h-screen bg-panetto-light flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-10">

        <div class="bg-panetto-orange p-6 text-center">
            <h1 class="text-3xl font-bold text-white uppercase tracking-wider mb-1">Tu Opinión Cuenta</h1>
            <p class="text-white/90 text-sm font-medium">Ayudanos a mejorar Panetto</p>
        </div>

        <div class="p-6">
            @if ($submitted)
                <div class="text-center py-10 animate-pulse">
                    <div
                        class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-panetto-dark mb-2">¡Gracias por tu tiempo!</h2>
                    <p class="text-gray-500 mb-6">Tus respuestas nos ayudan a crecer.</p>

                    <div class="mt-8 pt-4 border-t border-gray-100">
                        <a href="{{ route('menu.show', ['slug' => 'panetto-belgrano']) }}"
                            class="text-sm text-gray-400 hover:text-panetto-orange font-bold">
                            ← Ir al Menú Digital
                        </a>
                    </div>
                </div>
            @elseif(!session()->has('survey_google_user'))
                <div class="text-center py-8">
                    <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-panetto-orange" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-panetto-dark mb-2">¡Hola!</h2>
                    <p class="text-gray-500 mb-8 text-sm px-4">Para completar la encuesta y participar del sorteo, por
                        favor vincula tu cuenta.</p>

                    <a href="{{ route('google.login') }}"
                        class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-200 text-gray-700 py-3.5 rounded-xl font-bold text-lg hover:bg-gray-50 transition shadow-sm active:scale-95">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-6 h-6" alt="Google">
                        Continuar con Google
                    </a>
                    <p class="text-[10px] text-gray-400 mt-4">Solo usaremos tu correo para contactarte si ganas.</p>
                </div>
            @else
                @php $googleUser = session('survey_google_user'); @endphp

                <div
                    class="flex justify-between items-center mb-6 bg-gray-50 p-3 rounded-xl border border-gray-200 shadow-inner">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <img src="{{ $googleUser['avatar'] }}" alt="Avatar"
                            class="w-10 h-10 rounded-full shadow-sm border border-gray-200">
                        <div class="truncate">
                            <span
                                class="text-sm font-bold text-gray-700 block truncate">{{ $googleUser['name'] }}</span>
                            <span
                                class="text-[10px] text-gray-500 block truncate font-medium">{{ $googleUser['email'] }}</span>
                        </div>
                    </div>
                    <form action="{{ route('logout.public') }}" method="POST" class="flex-shrink-0 ml-2">
                        @csrf
                        <button type="submit"
                            class="text-xs text-gray-500 font-bold hover:text-red-500 bg-white border border-gray-200 hover:border-red-200 px-3 py-1.5 rounded-lg transition shadow-sm">Cambiar</button>
                    </form>
                </div>

                <form wire:submit.prevent="save" class="space-y-5">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">DNI</label>
                            <input type="tel" wire:model="dni"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition font-bold text-panetto-dark placeholder-gray-300"
                                placeholder="Sin puntos">
                            @error('dni')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre</label>
                            <input type="text" wire:model="name"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition"
                                placeholder="Tu nombre">
                            @error('name')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Apellido</label>
                            <input type="text" wire:model="last_name"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition"
                                placeholder="Tu apellido">
                            @error('last_name')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Teléfono (WhatsApp)</label>
                        <input type="tel" wire:model="phone"
                            class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition"
                            placeholder="Ej: 385...">
                        @error('phone')
                            <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Hora</label>
                            <select wire:model="visit_hour"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange outline-none text-center">
                                <option value="">HH</option>
                                @foreach (range(0, 23) as $h)
                                    <option value="{{ $h }}">{{ str_pad($h, 2, '0', STR_PAD_LEFT) }} hs
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Min</label>
                            <select wire:model="visit_minute"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange outline-none text-center">
                                <option value="">MM</option>
                                @foreach (range(0, 59) as $m)
                                    <option value="{{ $m }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }} min
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200 space-y-6">
                        <h3 class="font-bold text-panetto-dark text-lg mb-2">Sobre tu experiencia familiar</h3>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">1️⃣ ¿Venís al local con
                                niños/as?</label>
                            <div class="space-y-2">
                                @foreach (['Sí, frecuentemente', 'A veces', 'No'] as $option)
                                    <label
                                        class="flex items-center p-3 bg-gray-50 border border-gray-100 rounded-lg cursor-pointer hover:bg-panetto-orange/10 transition">
                                        <input type="radio" wire:model="brings_kids" value="{{ $option }}"
                                            class="w-4 h-4 text-panetto-orange focus:ring-panetto-orange border-gray-300">
                                        <span
                                            class="ml-3 text-sm font-medium text-gray-700">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('brings_kids')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">2️⃣ Si venís con niños/as, ¿qué
                                edades tienen? <span class="text-xs font-normal text-gray-400 block">(Podés marcar más
                                    de una)</span></label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach (['0–2 años', '3–5 años', '6–9 años', '10+', 'No tengo hijos/as'] as $option)
                                    <label
                                        class="flex items-center p-3 bg-gray-50 border border-gray-100 rounded-lg cursor-pointer hover:bg-panetto-orange/10 transition">
                                        <input type="checkbox" wire:model="kids_ages" value="{{ $option }}"
                                            class="w-4 h-4 text-panetto-orange rounded focus:ring-panetto-orange border-gray-300">
                                        <span
                                            class="ml-3 text-sm font-medium text-gray-700">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">3️⃣ ¿Te resultaría útil que el
                                local tenga plaza blanda y pelotero para niños?</label>
                            <div class="space-y-2">
                                @foreach (['Muy útil', 'Algo útil', 'Me da igual', 'No me interesa'] as $option)
                                    <label
                                        class="flex items-center p-3 bg-gray-50 border border-gray-100 rounded-lg cursor-pointer hover:bg-panetto-orange/10 transition">
                                        <input type="radio" wire:model="useful_play_area"
                                            value="{{ $option }}"
                                            class="w-4 h-4 text-panetto-orange focus:ring-panetto-orange border-gray-300">
                                        <span
                                            class="ml-3 text-sm font-medium text-gray-700">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('useful_play_area')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">4️⃣ Si el local tuviera plaza
                                blanda + pelotero, ¿vendrías más seguido?</label>
                            <div class="space-y-2">
                                @foreach (['Sí, mucho más seguido', 'Un poco más seguido', 'Igual que ahora', 'Vendría menos'] as $option)
                                    <label
                                        class="flex items-center p-3 bg-gray-50 border border-gray-100 rounded-lg cursor-pointer hover:bg-panetto-orange/10 transition">
                                        <input type="radio" wire:model="visit_more_often"
                                            value="{{ $option }}"
                                            class="w-4 h-4 text-panetto-orange focus:ring-panetto-orange border-gray-300">
                                        <span
                                            class="ml-3 text-sm font-medium text-gray-700">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('visit_more_often')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-panetto-orange text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:bg-orange-600 transition transform active:scale-95 mt-6">
                        ENVIAR ENCUESTA
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
