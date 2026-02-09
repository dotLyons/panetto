<div class="min-h-screen pb-10 bg-panetto-light font-sans">

    @if ($promoProducts->isNotEmpty())
        <div class="relative w-full h-[220px] md:h-[350px] bg-gray-900 overflow-hidden shadow-xl">

            <div class="flex overflow-x-auto snap-x snap-mandatory h-full w-full no-scrollbar">
                @foreach ($promoProducts as $promo)
                    <div class="snap-center shrink-0 w-full h-full relative">
                        @if ($promo->image_path)
                            <img src="{{ Storage::url($promo->image_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-panetto-orange flex items-center justify-center">
                                <span class="text-4xl md:text-6xl">🔥</span>
                            </div>
                        @endif

                        <div
                            class="absolute bottom-0 left-0 w-full p-4 md:p-6 pt-10 bg-gradient-to-t from-black/90 via-black/50 to-transparent z-10 text-center">
                            <span
                                class="inline-block px-2 py-0.5 mb-1 text-[10px] font-bold tracking-widest text-white bg-panetto-orange rounded-full uppercase shadow-sm">
                                Promo
                            </span>
                            <h2 class="text-xl md:text-2xl font-bold text-white leading-tight mb-0.5 drop-shadow-md">
                                {{ $promo->name }}
                            </h2>
                            <p class="text-2xl md:text-3xl font-serif font-bold text-yellow-400 drop-shadow-sm">
                                ${{ number_format($promo->price, 0) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($promoProducts->count() > 1)
                <div class="absolute bottom-2 left-0 w-full flex justify-center gap-1 z-20">
                    @foreach ($promoProducts as $index => $p)
                        <div class="w-1.5 h-1.5 rounded-full bg-white/50"></div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <header
            class="bg-panetto-orange text-white py-2 px-4 shadow-md text-center sticky top-0 z-20 transition-all duration-300">
            <div class="flex justify-center mb-1">
                <div class="bg-white rounded-full p-0.5 shadow-lg">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Panetto"
                        class="w-12 h-12 object-contain rounded-full">
                </div>
            </div>
            <h1 class="text-lg md:text-2xl font-serif font-bold tracking-wider uppercase drop-shadow-sm leading-tight">
                {{ $locationName }}
            </h1>
            <p class="text-[10px] md:text-xs text-white/90 uppercase tracking-widest font-semibold">
                Menú Digital
            </p>
        </header>
    @endif

    <div
        class="sticky z-10 bg-panetto-light/95 backdrop-blur shadow-sm py-2 px-4 flex gap-2 overflow-x-auto no-scrollbar border-b border-panetto-orange/10 transition-all duration-300 {{ $promoProducts->isNotEmpty() ? 'top-0' : 'top-[105px] md:top-[120px]' }}">
        <button wire:click="selectCategory(null)"
            class="px-3 py-1 rounded-full whitespace-nowrap text-xs font-bold transition border border-transparent shadow-sm {{ is_null($selectedCategory) ? 'bg-panetto-orange text-white' : 'bg-white text-gray-600 border-gray-200 hover:border-panetto-orange/30' }}">
            Todos
        </button>
        @foreach ($categories as $cat)
            <button wire:click="selectCategory({{ $cat->id }})"
                class="px-3 py-1 rounded-full whitespace-nowrap text-xs font-bold transition border border-transparent shadow-sm {{ $selectedCategory == $cat->id ? 'bg-panetto-orange text-white' : 'bg-white text-gray-600 border-gray-200 hover:border-panetto-orange/30' }}">
                {{ $cat->name }}
            </button>
        @endforeach
    </div>

    <div class="container mx-auto px-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
            @forelse($products as $product)
                <div
                    class="bg-white rounded-xl shadow-sm border border-panetto-orange/10 overflow-hidden flex flex-row md:flex-col h-24 md:h-auto transition hover:shadow-md">

                    <div
                        class="w-24 h-full md:w-full md:h-48 relative flex-shrink-0 bg-panetto-accent/20 flex items-center justify-center">
                        @if ($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}"
                                class="w-full h-full object-contain p-1">
                        @else
                            <span class="text-3xl opacity-40 text-panetto-orange">🍽️</span>
                        @endif

                        <div
                            class="hidden md:block absolute top-0 left-0 bg-panetto-orange text-white text-xs font-bold px-3 py-1 rounded-br-lg shadow-sm">
                            {{ $product->category->name }}
                        </div>
                    </div>

                    <div class="p-3 md:p-5 flex-1 flex flex-col justify-center md:justify-between">
                        <div>
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <h3 class="text-sm md:text-xl font-bold text-panetto-dark leading-tight line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <span class="font-bold text-panetto-orange text-base md:text-xl whitespace-nowrap">
                                    ${{ number_format($product->price, 0) }}
                                </span>
                            </div>

                            <p class="text-gray-500 text-[11px] md:text-sm leading-tight line-clamp-2">
                                {{ $product->description }}
                            </p>
                        </div>
                        <div class="md:hidden mt-2">
                            <span
                                class="text-[10px] font-semibold text-panetto-orange bg-panetto-accent/30 px-2 py-0.5 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-panetto-orange/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-50" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg font-semibold">No hay productos disponibles aquí.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
