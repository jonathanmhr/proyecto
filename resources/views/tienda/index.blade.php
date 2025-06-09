<x-app-layout>

    @push('styles')
    <style>
        /* Estilos personalizados para el input range */
        input[type="range"] {
            -webkit-appearance: none; appearance: none;
            width: 100%; height: 8px;
            background: #e5e7eb; /* bg-gray-200 */
            border-radius: 9999px; outline: none; opacity: 0.7;
            transition: opacity .2s;
        }
        input[type="range"]:hover { opacity: 1; }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none; appearance: none;
            width: 20px; height: 20px;
            background: #4f46e5; /* bg-indigo-600 */
            cursor: pointer; border-radius: 50%; border: 2px solid white;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
        input[type="range"]::-moz-range-thumb {
            width: 20px; height: 20px;
            background: #4f46e5; /* bg-indigo-600 */
            cursor: pointer; border-radius: 50%; border: 2px solid white;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tienda') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-red-600 mb-6 text-center md:text-left">Nuestros Productos</h1>

        <!-- FORMULARIO UNIFICADO DE FILTROS -->
        <form method="GET" action="{{ route('tienda.index') }}" class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <!-- Filtro de Búsqueda -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar producto</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        placeholder="Buscar por nombre..."
                        value="{{ $searchTerm ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    >
                </div>

                <!-- Filtro de Valoración -->
                <div>
                    <label for="rating-filter" class="block text-sm font-medium text-gray-700 mb-1">Valoración mínima</label>
                    <input
                        type="range"
                        id="rating-filter"
                        name="valoracion_minima"
                        min="0"
                        max="5"
                        step="1"
                        value="{{ $selectedRating ?? 0 }}"
                        class="w-full"
                    >
                    <div id="rating-display" class="text-sm text-gray-600 mt-2 flex items-center justify-center">
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition">Aplicar Filtros</button>
                    @if(count(request()->except('page')) > 0)
                        <a href="{{ route('tienda.index') }}" class="w-full text-center px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-md hover:bg-gray-300 transition">Limpiar</a>
                    @endif
                </div>
            </div>
        </form>
        
        <nav class="flex flex-wrap items-center gap-2 mb-8 border-b border-gray-200 pb-4">
            <span class="font-semibold mr-2 text-white">Filtrar por tipo:</span>
            <a href="{{ route('tienda.index', request()->except('tipo', 'page')) }}"
               class="px-4 py-2 text-sm font-medium rounded-full transition
                      {{ !isset($selectedTipo) || $selectedTipo == '' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-100' }}">
                Todos
            </a>

            @if(isset($tiposDisponibles) && is_array($tiposDisponibles))
                @foreach ($tiposDisponibles as $tipoValue)
                    @php
                        // CORRECCIÓN: Lógica mejorada para formatear las etiquetas de los nuevos tipos.
                        $tipoLabel = ucwords(strtolower(str_replace(['_', '/'], [' ', ' / '], $tipoValue)));
                    @endphp
                    <a href="{{ route('tienda.index', array_merge(request()->except('page'), ['tipo' => $tipoValue])) }}"
                       class="px-4 py-2 text-sm font-medium rounded-full transition
                              {{ (isset($selectedTipo) && $selectedTipo == $tipoValue) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-100' }}">
                        {{ $tipoLabel }}
                    </a>
                @endforeach
            @endif
        </nav>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($productos->isEmpty())
            <p class="text-gray-600 text-center py-10">No se encontraron productos que coincidan con los filtros seleccionados.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <div
                        class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl cursor-pointer"
                        @click="$dispatch('open-product-modal', {{ json_encode($producto->toArray()) }})"
                    >
                        <div class="block">
                            <img src="{{ asset('images/' . $producto->imagen) }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <h2 class="text-xl font-semibold text-gray-800 mb-1">
                                <span class="hover:text-indigo-600 transition-colors duration-200">{{ $producto->nombre }}</span>
                            </h2>

                            @if(isset($producto->valoracion) && $producto->valoracion > 0)
                            <div class="flex items-center mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 @if($i <= $producto->valoracion) text-yellow-400 @else text-gray-300 @endif" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">({{ $producto->valoracion }})</span>
                            </div>
                            @endif

                            @if($producto->tipo)
                                <p class="text-xs text-gray-500 mb-1">Tipo:
                                    {{ ucwords(strtolower(str_replace(['_', '/'], [' ', ' / '], $producto->tipo))) }}
                                </p>
                            @endif
                            <p class="text-gray-600 text-sm mb-2 flex-grow min-h-[4.5rem]">
                                {{ Str::limit($producto->descripcion, 90) }}
                            </p>
                            <p class="text-lg font-bold text-indigo-600 mb-1">
                                {{ number_format($producto->precio_unitario, 2, ',', '.') }} €
                            </p>
                            <p class="text-xs text-gray-500 mb-3">
                                Disponibles: {{ $producto->cantidad_disponible }}
                            </p>

                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-auto" @click.stop>
                                @csrf
                                <div class="flex items-center mb-3">
                                    <label for="cantidad-{{$producto->id}}" class="mr-2 text-sm text-gray-700">Cant:</label>
                                    <input type="number" name="cantidad" id="cantidad-{{$producto->id}}" value="1" min="1" max="{{ $producto->cantidad_disponible > 0 ? $producto->cantidad_disponible : 1 }}"
                                        class="w-16 px-2 py-1 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        @if($producto->cantidad_disponible == 0) disabled @endif>
                                </div>
                                <button type="submit"
                                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transform hover:scale-105
                                               @if($producto->cantidad_disponible == 0) bg-gray-400 hover:bg-gray-400 cursor-not-allowed @endif"
                                        @if($producto->cantidad_disponible == 0) disabled @endif>
                                    @if($producto->cantidad_disponible > 0)
                                        Añadir al Carrito
                                    @else
                                        Agotado
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $productos->links() }}
            </div>
        @endif
    </div>

    {{-- BOTÓN FLOTANTE DEL CARRITO Y MODAL ... --}}
    <a href="{{ route('carrito.view') }}" title="Ver Cesta" class="fixed bottom-6 right-6 bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-full shadow-xl transition-transform duration-150 ease-in-out hover:scale-110 z-50 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        @if(isset($cartItemCount) && $cartItemCount > 0)
            <span class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white border-2 border-white">{{ $cartItemCount }}</span>
        @endif
    </a>

    <div x-data="productModal()" x-show="showModal" x-on:open-product-modal.window="openModal($event.detail)" x-on:keydown.escape.window="closeModal()" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div @click.outside="closeModal()" x-show="showModal" x-transition class="bg-white rounded-2xl shadow-xl max-w-3xl w-full p-6 mx-auto overflow-hidden text-left transform transition-all">
            {{-- Contenido del modal sin cambios --}}
        </div>
    </div>

    @push('scripts')
    <script>
        function productModal() { return { showModal: false, product: {}, openModal(productData) { if (typeof productData === 'object' && productData !== null) { this.product = productData; } else { this.product = { nombre: 'Detalles no disponibles', descripcion: '', imagen: null, image_url: 'https://via.placeholder.com/400x300?text=Producto', precio_unitario: null, cantidad_disponible: 0, sku: null, id: null, tipo: null, valoracion: 0 }; console.error('Invalid product data received for modal:', productData); } this.showModal = true; this.$nextTick(() => { const modalTitle = document.getElementById('modal-title'); if(modalTitle) modalTitle.focus(); }); }, closeModal() { this.showModal = false; } } }
        document.addEventListener('DOMContentLoaded', function () { const ratingSlider = document.getElementById('rating-filter'); const ratingDisplay = document.getElementById('rating-display'); const starSVG = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>`; function updateRatingDisplay(value) { let starsHTML = ''; if (value == 0) { ratingDisplay.innerHTML = '<span class="text-gray-500">Cualquier valoración</span>'; return; } for (let i = 1; i <= 5; i++) { starsHTML += `<span class="${i <= value ? 'text-yellow-400' : 'text-gray-300'}">${starSVG}</span>`; } starsHTML += `<span class="ml-2 text-gray-700 font-medium">${value} o más</span>`; ratingDisplay.innerHTML = starsHTML; } if(ratingSlider) { ratingSlider.addEventListener('input', function () { updateRatingDisplay(this.value); }); updateRatingDisplay(ratingSlider.value); } });
    </script>
    @endpush
</x-app-layout>