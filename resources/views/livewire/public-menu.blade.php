<div class="min-h-screen pb-10 bg-panetto-light">
    <header class="bg-panetto-orange text-white p-5 shadow-md text-center sticky top-0 z-20">
        <h1 class="text-2xl md:text-3xl font-serif font-bold tracking-wider uppercase">{{ $locationName }}</h1>
        <p class="text-xs md:text-sm text-white/90 mt-1 uppercase tracking-widest font-semibold">Menú Digital</p>
    </header>

    <div
        class="sticky top-[80px] md:top-[98px] z-10 bg-panetto-light/95 backdrop-blur shadow-sm py-3 px-4 flex gap-2 overflow-x-auto no-scrollbar border-b border-panetto-orange/10">
        <button wire:click="selectCategory(null)"
            class="px-4 py-1.5 rounded-full whitespace-nowrap text-xs font-bold transition border border-transparent shadow-sm {{ is_null($selectedCategory) ? 'bg-panetto-orange text-white' : 'bg-white text-gray-600 border-gray-200 hover:border-panetto-orange/30' }}">
            Todos
        </button>
        @foreach ($categories as $cat)
            <button wire:click="selectCategory({{ $cat->id }})"
                class="px-4 py-1.5 rounded-full whitespace-nowrap text-xs font-bold transition border border-transparent shadow-sm {{ $selectedCategory == $cat->id ? 'bg-panetto-orange text-white' : 'bg-white text-gray-600 border-gray-200 hover:border-panetto-orange/30' }}">
                {{ $cat->name }}
            </button>
        @endforeach
    </div>

    <div class="container mx-auto px-4 mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
            @forelse($products as $product)
                <div
                    class="bg-white rounded-xl shadow-sm border border-panetto-orange/10 overflow-hidden flex flex-row md:flex-col h-24 md:h-auto transition hover:shadow-md">

                    <div
                        class="w-24 h-full md:w-full md:h-48 relative flex-shrink-0 bg-panetto-accent/20 flex items-center justify-center">
                        @if ($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" class="w-full h-full object-contain p-1">
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