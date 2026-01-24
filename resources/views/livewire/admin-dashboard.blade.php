<div class="min-h-screen bg-panetto-light flex flex-col items-center pt-6 px-4 pb-10">

    @if (!$isAuthenticated)
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm text-center border-t-4 border-panetto-orange mt-10">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-panetto-orange uppercase tracking-wider">Panetto</h2>
                <p class="text-sm text-gray-500 font-semibold">Acceso Administrativo</p>
            </div>
            <form wire:submit.prevent="login">
                <input type="password" wire:model="passcode" placeholder="Passcode (2468)" inputmode="numeric"
                    class="w-full text-center text-xl p-3 border-2 border-gray-200 rounded-lg mb-4 focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition">
                @error('passcode')
                    <span class="text-red-500 text-sm block mb-3 font-bold">{{ $message }}</span>
                @enderror
                <button type="submit"
                    class="w-full bg-panetto-orange text-white py-3 rounded-lg font-bold hover:bg-orange-600 transition shadow-md active:scale-95">
                    Desbloquear
                </button>
            </form>
        </div>
    @elseif(!$selectedLocationId)
        <div class="w-full max-w-4xl mt-10">
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-panetto-orange/20">
                <div>
                    <h2 class="text-2xl font-bold text-panetto-dark">Seleccione Sucursal</h2>
                    <p class="text-sm text-gray-500">Elija qué carta digital desea gestionar.</p>
                </div>
                <button wire:click="logout"
                    class="text-sm text-red-500 hover:text-red-700 font-bold border border-red-200 px-4 py-2 rounded-lg hover:bg-red-50 transition">
                    Cerrar Sesión
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($locations as $loc)
                    <button wire:click="selectLocation({{ $loc->id }})"
                        class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition border-2 border-transparent hover:border-panetto-orange group text-left relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition text-panetto-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-panetto-dark group-hover:text-panetto-orange transition">
                            {{ $loc->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-2 font-medium">Gestionar productos y categorías</p>
                        <div class="mt-6 text-panetto-orange font-bold text-sm flex items-center">
                            Ingresar <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 ml-1 group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </button>
                @empty
                    <div
                        class="col-span-full bg-yellow-50 p-8 rounded-xl text-center text-yellow-800 border-2 border-yellow-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-yellow-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="font-bold text-lg">No se encontraron sucursales.</p>
                        <p class="text-sm mt-2">Contacte al administrador de la base de datos.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @else
        <div
            class="w-full max-w-6xl bg-white rounded-xl shadow-lg overflow-hidden min-h-[600px] flex flex-col border border-gray-200">

            <div
                class="bg-white text-panetto-dark p-4 flex justify-between items-center sticky top-0 z-20 border-b border-gray-200 shadow-sm">
                <div class="flex items-center gap-6">
                    <h2 class="font-bold text-lg flex items-center gap-2 text-panetto-dark">
                        <span class="text-2xl text-panetto-orange">🏢</span> {{ $selectedLocationName }}
                    </h2>

                    <button wire:click="switchLocation"
                        class="text-xs bg-gray-100 px-3 py-1.5 rounded-full hover:bg-gray-200 text-gray-600 border border-gray-200 font-semibold transition flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Cambiar Local
                    </button>
                </div>

                <button wire:click="logout"
                    class="text-xs bg-panetto-dark text-white px-4 py-2 rounded-lg hover:bg-black font-bold uppercase tracking-wide transition shadow-sm">
                    Salir
                </button>
            </div>

            <div class="p-4 md:p-6 flex-1 bg-gray-50">

                @if (session()->has('message'))
                    <div
                        class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 text-sm flex items-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="font-semibold">{{ session('message') }}</span>
                    </div>
                @endif

                <div class="flex gap-2 mb-6 border-b border-gray-200 pb-1 overflow-x-auto no-scrollbar whitespace-nowrap">
                    <button wire:click="changeView('list')"
                        class="px-5 py-2.5 rounded-t-lg font-bold transition flex items-center gap-2 {{ $view === 'list' ? 'bg-white text-panetto-orange border-b-2 border-panetto-orange shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                        📋 Listado
                    </button>
                    <button wire:click="changeView('create_product')"
                        class="px-5 py-2.5 rounded-t-lg font-bold transition flex items-center gap-2 {{ $view === 'create_product' ? 'bg-white text-panetto-orange border-b-2 border-panetto-orange shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                        {{ $productId ? '✏️ Editando' : '➕ Producto' }}
                    </button>
                    <button wire:click="changeView('create_category')"
                        class="px-5 py-2.5 rounded-t-lg font-bold transition flex items-center gap-2 {{ $view === 'create_category' ? 'bg-white text-panetto-orange border-b-2 border-panetto-orange shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                        🏷️ Categorías
                    </button>
                </div>

                @if ($view === 'create_category')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 h-fit">
                            <h3
                                class="text-lg font-bold text-panetto-dark mb-6 border-b border-gray-100 pb-3 flex items-center gap-2">
                                <span class="text-panetto-orange">✨</span> Nueva Categoría
                            </h3>

                            <form wire:submit.prevent="saveCategory">
                                <label class="block mb-2 text-sm font-bold text-gray-700">Nombre de la categoría</label>
                                <input type="text" wire:model="cat_name" placeholder="Ej: Cafetería, Panificados..."
                                    class="w-full p-3 border-2 border-gray-200 rounded-lg mb-4 focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50 focus:bg-white">

                                @error('cat_name')
                                    <span class="text-red-500 text-xs block mb-3 font-bold flex items-center"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg> {{ $message }}</span>
                                @enderror

                                <button type="submit"
                                    class="w-full bg-panetto-orange text-white py-3 rounded-lg font-bold hover:bg-orange-600 transition shadow-md active:scale-95 flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Guardar Categoría
                                </button>
                            </form>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col max-h-[500px]">
                            <h3
                                class="text-lg font-bold text-panetto-dark p-4 bg-panetto-accent/30 border-b border-gray-200 flex justify-between items-center">
                                <span>Categorías Activas</span>
                                <span
                                    class="bg-panetto-orange text-white text-xs px-2.5 py-1 rounded-full font-bold shadow-sm">{{ $categories->count() }}</span>
                            </h3>

                            <div class="overflow-y-auto flex-1 custom-scrollbar p-2">
                                <ul class="divide-y divide-gray-100">
                                    @forelse($categories as $cat)
                                        <li
                                            class="p-3 flex justify-between items-center hover:bg-panetto-accent/10 transition rounded-lg group">
                                            <span
                                                class="font-semibold text-gray-700 group-hover:text-panetto-orange transition">{{ $cat->name }}</span>
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-full border border-gray-200">
                                                    {{ $cat->products_count }} prods.
                                                </span>
                                                <button wire:click="deleteCategory({{ $cat->id }})"
                                                    onclick="confirm('¿Seguro que desea eliminar la categoría \'{{ $cat->name }}\'?') || event.stopImmediatePropagation()"
                                                    class="text-red-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-full transition shadow-sm border border-transparent hover:border-red-200"
                                                    title="Eliminar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="p-8 text-center text-gray-400 text-sm italic flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 opacity-50" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            No hay categorías creadas en este local.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($view === 'create_product')
                    <div class="max-w-3xl mx-auto">
                        <div class="mb-6 flex justify-between items-center pb-4 border-b border-gray-200">
                            <h3 class="text-xl font-bold text-panetto-orange flex items-center gap-2">
                                <span>{{ $productId ? '✏️' : '🔥' }}</span>
                                {{ $productId ? 'Editar Producto Existente' : 'Crear Nuevo Producto' }}
                            </h3>
                            @if ($productId)
                                <button wire:click="resetForm"
                                    class="text-sm text-gray-500 hover:text-red-500 font-bold flex items-center gap-1 px-3 py-1.5 rounded hover:bg-red-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancelar Edición
                                </button>
                            @endif
                        </div>

                        <form wire:submit.prevent="saveProduct"
                            class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold mb-2 text-gray-700">Nombre del Producto</label>
                                <input type="text" wire:model="name" placeholder="Ej: Tostado de Miga"
                                    class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50 focus:bg-white">
                                @error('name')
                                    <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold mb-2 text-gray-700">Categoría</label>
                                <select wire:model="category_id"
                                    class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50 focus:bg-white cursor-pointer">
                                    <option value="">Seleccione una categoría...</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold mb-2 text-gray-700">Precio ($)</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center font-bold text-gray-500">$</span>
                                    <input type="number" wire:model="price" placeholder="0.00"
                                        class="w-full p-3 pl-8 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50 focus:bg-white font-bold text-panetto-orange">
                                </div>
                                @error('price')
                                    <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-bold mb-2 text-gray-700">Descripción
                                    (Opcional)</label>
                                <textarea wire:model="description" rows="3" placeholder="Ingredientes, detalles..."
                                    class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none transition bg-gray-50 focus:bg-white resize-none"></textarea>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-bold mb-2 text-gray-700">Foto del Producto</label>

                                <div
                                    class="flex items-start gap-4 p-4 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg hover:border-panetto-orange transition relative">
                                    @if ($currentImage && !$image)
                                        <div class="flex-shrink-0 text-center p-2 bg-white border rounded shadow-sm">
                                            <img src="{{ Storage::url($currentImage) }}"
                                                class="w-16 h-16 object-contain rounded mb-1">
                                            <span class="text-[10px] font-bold text-green-600 uppercase block">Actual</span>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <input type="file" wire:model="image" accept="image/png, image/jpeg, image/jpg"
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-panetto-orange file:text-white hover:file:bg-orange-600 cursor-pointer">
                                        <p class="text-xs text-gray-400 mt-2 font-medium">PNG, JPG hasta 2MB.</p>
                                    </div>

                                    <div wire:loading wire:target="image"
                                        class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-lg">
                                        <div class="flex items-center gap-2 text-panetto-orange font-bold">
                                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Subiendo...
                                        </div>
                                    </div>
                                </div>
                                @error('image')
                                    <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-span-2 mt-4 pt-4 border-t border-gray-100">
                                <button type="submit"
                                    class="w-full bg-panetto-orange text-white py-4 rounded-xl font-bold text-lg hover:bg-orange-600 shadow-md transition transform active:scale-[0.98] flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $productId ? 'Guardar Cambios' : 'Publicar Producto Ahora' }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                @if ($view === 'list')
                    <div class="flex flex-col h-full">
                        <div class="mb-6 relative max-w-md">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Buscar producto por nombre..."
                                class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange outline-none shadow-sm transition">
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm bg-white">
                            <table class="w-full text-left border-collapse min-w-[700px]">
                                <thead
                                    class="bg-panetto-accent/30 text-panetto-dark text-xs uppercase font-bold tracking-wider">
                                    <tr>
                                        <th class="p-4 rounded-tl-xl">Producto</th>
                                        <th class="p-4">Categoría</th>
                                        <th class="p-4">Precio</th>
                                        <th class="p-4 text-right rounded-tr-xl">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm">
                                    @forelse($products as $prod)
                                        <tr class="hover:bg-panetto-accent/10 transition group">
                                            <td class="p-4 flex items-center gap-4">
                                                <div
                                                    class="w-14 h-14 flex-shrink-0 bg-gray-100 rounded-lg border border-gray-200 p-1 flex items-center justify-center">
                                                    @if ($prod->image_path)
                                                        <img src="{{ Storage::url($prod->image_path) }}"
                                                            class="w-full h-full object-contain">
                                                    @else
                                                        <span class="text-2xl opacity-40">🥐</span>
                                                    @endif
                                                </div>
                                                <span
                                                    class="font-bold text-gray-800 text-base group-hover:text-panetto-orange transition">{{ $prod->name }}</span>
                                            </td>
                                            <td class="p-4">
                                                <span
                                                    class="bg-white border border-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                                    {{ $prod->category->name }}
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                <span
                                                    class="font-bold text-panetto-orange text-base bg-panetto-accent/20 px-3 py-1 rounded-lg">
                                                    ${{ number_format($prod->price, 0) }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <button wire:click="editProduct({{ $prod->id }})"
                                                        class="text-blue-500 hover:text-white hover:bg-blue-500 p-2 rounded-lg transition border border-blue-200 hover:border-transparent shadow-sm group/btn"
                                                        title="Editar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 group-hover/btn:scale-110 transition" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                    <button wire:click="deleteProduct({{ $prod->id }})"
                                                        class="text-red-500 hover:text-white hover:bg-red-500 p-2 rounded-lg transition border border-red-200 hover:border-transparent shadow-sm group/btn"
                                                        onclick="confirm('¿Estás seguro de eliminar este producto?') || event.stopImmediatePropagation()"
                                                        title="Eliminar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 group-hover/btn:scale-110 transition" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-12 text-center text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-12 w-12 mb-4 opacity-40 text-panetto-orange" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                    </svg>
                                                    @if ($search)
                                                        <p class="font-medium text-gray-600">No se encontraron
                                                            productos para "<strong>{{ $search }}</strong>".</p>
                                                    @else
                                                        <p class="font-bold text-lg text-gray-700">Aún no hay productos
                                                            cargados.</p>
                                                        <p class="text-sm mt-2 cursor-pointer text-panetto-orange hover:underline"
                                                            wire:click="changeView('create_product')">¡Comienza creando
                                                            uno ahora!</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>