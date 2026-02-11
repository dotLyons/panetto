<div class="min-h-screen bg-panetto-light flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

        <div class="bg-panetto-orange p-6 text-center">
            <h1 class="text-3xl font-bold text-white uppercase tracking-wider mb-1">¡Ganá con Panetto!</h1>
            <p class="text-white/90 text-sm font-medium">Completá el formulario y participá</p>
        </div>

        <div class="p-6">
            @if($submitted)
                <div class="text-center py-10 animate-pulse">
                    <div
                        class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-panetto-dark mb-2">¡Registro Exitoso!</h2>
                    <p class="text-gray-500 mb-6">Mucha suerte en el sorteo.</p>

                    <button wire:click="$set('submitted', false)" class="text-panetto-orange font-bold hover:underline">
                        Registrar otro comensal
                    </button>

                    <div class="mt-8 pt-4 border-t border-gray-100">
                        <a href="{{ route('menu.show', ['slug' => 'panetto-belgrano']) }}"
                            class="text-sm text-gray-400 hover:text-panetto-orange">
                            ← Ir al Menú
                        </a>
                    </div>
                </div>
            @else
                <form wire:submit.prevent="save" class="space-y-4">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">DNI</label>
                            <input type="tel" wire:model="dni"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition font-bold text-panetto-dark placeholder-gray-300"
                                placeholder="Sin puntos">
                            @error('dni') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre</label>
                            <input type="text" wire:model="name"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition"
                                placeholder="Tu nombre">
                            @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Apellido</label>
                            <input type="text" wire:model="last_name"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition"
                                placeholder="Tu apellido">
                            @error('last_name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Teléfono (WhatsApp)</label>
                        <input type="tel" wire:model="phone"
                            class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition"
                            placeholder="Ej: 385...">
                        @error('phone') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">N° de Mesa</label>
                        <input type="number" wire:model="table_number"
                            class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition font-bold text-lg text-center"
                            placeholder="Ej: 5">
                        @error('table_number') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Hora (HH)</label>
                            <select wire:model="visit_hour"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition text-center cursor-pointer">
                                <option value="">Hora</option>
                                @foreach(range(0,23) as $h)
                                    <option value="{{ $h }}">{{ str_pad($h, 2, '0', STR_PAD_LEFT) }} hs</option>
                                @endforeach
                            </select>
                            @error('visit_hour') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Minutos (MM)</label>
                            <select wire:model="visit_minute"
                                class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-panetto-orange focus:ring-0 outline-none transition text-center cursor-pointer">
                                <option value="">Min</option>
                                @foreach(range(0,59, 5) as $m) <option value="{{ $m }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }} min</option>
                                @endforeach
                            </select>
                            @error('visit_minute') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 text-center">
                        <label class="block text-sm font-bold text-panetto-dark mb-3">¿Qué te pareció la atención?</label>

                        <div class="flex justify-center gap-2 mb-2">
                            @foreach(range(1, 5) as $star)
                                <button type="button" wire:click="setRating({{ $star }})"
                                    class="transition transform active:scale-125 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-10 w-10 {{ $rating >= $star ? 'text-yellow-400 fill-current' : 'text-gray-200' }}"
                                        viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="{{ $rating >= $star ? '0' : '2' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </button>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 font-medium">
                            @if($rating == 1) 😡 Malo @elseif($rating == 2) 😕 Regular @elseif($rating == 3) 😐 Normal
                            @elseif($rating == 4) 🙂 Muy Bueno @elseif($rating == 5) 🤩 ¡Excelente! @endif
                        </p>
                        @error('rating') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-panetto-orange text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:bg-orange-600 transition transform active:scale-95 mt-4">
                        ENVIAR
                    </button>

                    <p class="text-[10px] text-center text-gray-400 mt-4">
                        Al enviar aceptas participar del sorteo presencial.
                    </p>
                </form>
            @endif
        </div>
    </div>
</div>
