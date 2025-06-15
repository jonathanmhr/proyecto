<x-app-layout>

    @push('styles')
    <style>
        /* Estilos para el input range personalizado con tema oscuro */
        .custom-range {
            -webkit-appearance: none; appearance: none;
            width: 100%; height: 6px;
            background: #374151; /* bg-gray-700 */
            border-radius: 9999px; outline: none;
            cursor: pointer;
            background: linear-gradient(to right, #dc2626 var(--value-percent, 0%), #374151 var(--value-percent, 0%));
            transition: background 0.1s ease-in-out;
        }

        /* Thumb para Chrome, etc. - Tema Oscuro */
        .custom-range::-webkit-slider-thumb {
            -webkit-appearance: none; appearance: none;
            width: 22px; height: 22px;
            background: #ffffff; /* bg-white */
            border-radius: 50%;
            border: 5px solid #dc2626; /* border-red-600 */
            box-shadow: 0 0 5px rgba(0,0,0,0.4);
            margin-top: -8px; /* Centra el thumb */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .custom-range:hover::-webkit-slider-thumb,
        .custom-range:focus::-webkit-slider-thumb {
            transform: scale(1.1);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.3); /* Efecto "glow" rojo */
        }

        /* Thumb para Firefox - Tema Oscuro */
        .custom-range::-moz-range-thumb {
            width: 22px; height: 22px;
            background: #ffffff;
            border-radius: 50%;
            border: 5px solid #dc2626;
            box-shadow: 0 0 5px rgba(0,0,0,0.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .custom-range:hover::-moz-range-thumb,
        .custom-range:focus::-moz-range-thumb {
            transform: scale(1.1);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.3); /* Efecto "glow" rojo */
        }

        /* === INICIO: CORRECCIÓN PARA LA PAGINACIÓN EN MODO OSCURO === */
        /* Estilos para que la paginación por defecto de Laravel se vea bien en tema oscuro */
        .pagination {
            /* Contenedor principal de los enlaces */
        }
        .pagination a,
        .pagination span {
            /* Estilo base para todos los elementos de paginación */
            background-color: #1f2937; /* bg-gray-800 */
            color: #d1d5db; /* text-gray-300 */
            border-color: #374151; /* border-gray-700 */
        }
        .pagination a:hover {
            /* Estilo al pasar el ratón por un enlace */
            background-color: #374151; /* bg-gray-700 */
        }
        .pagination .active span {
            /* Estilo para la página activa */
            background-color: #dc2626; /* bg-red-600 */
            border-color: #b91c1c; /* border-red-700 */
            color: #ffffff; /* text-white */
        }
        .pagination .disabled span {
            /* Estilo para los botones deshabilitados (primera/última página) */
            color: #4b5563; /* text-gray-600 */
            background-color: #1f2937; /* bg-gray-800 */
        }
        /* === FIN: CORRECCIÓN PARA LA PAGINACIÓN === */
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Tienda') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con el fondo oscuro de tu app --}}
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-red-500 mb-6 text-center md:text-left">Nuestros Productos</h1>

        <!-- === INICIO: FORMULARIO DE FILTROS INTEGRADO CON EL TEMA OSCURO === -->
        <form method="GET" action="{{ route('tienda.index') }}" class="bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-700 mb-8">
            <div class="lg:col-span-2">
                <label for="search" class="block text-sm font-semibold text-gray-400 mb-2">Buscar por producto</label>
                <div class="relative">
                    <div class="absolute mr-1 inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $searchTerm ?? '' }}"
                        class="w-full pl-12 pr-4 py-2.5 bg-gray-700 text-gray-200 border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-500"
                    >
                </div>
            </div>

                <!-- Filtro de Valoración -->
                <div class="lg:col-span-2">
                    <div class="flex justify-between items-center mb-2">
                        <label for="rating-filter" class="block text-sm font-semibold text-gray-400">Valoración mínima</label>
                        <div id="rating-display" class="text-sm font-medium text-gray-300 bg-gray-700 px-3 py-1 rounded-full shadow-sm flex items-center gap-1 border border-gray-600">
                            <!-- El JS llenará esto -->
                        </div>
                    </div>
                    <input
                        type="range"
                        id="rating-filter"
                        name="valoracion_minima"
                        min="0"
                        max="5"
                        step="1"
                        value="{{ $selectedRating ?? 0 }}"
                        class="w-full custom-range"
                    >
                </div>

                <!-- Botones de Acción -->
                <div class="lg:col-span-1 flex flex-col sm:flex-row lg:flex-col gap-3">
                    <button type="submit" class="w-full px-5 py-2.5 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 ease-in-out">Aplicar</button>
                    @if(count(request()->except('page')) > 0)
                        <a href="{{ route('tienda.index') }}" class="w-full text-center px-4 py-2.5 bg-transparent text-sm text-gray-400 font-semibold border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-gray-500 transition-all">Limpiar</a>
                    @endif
                </div>
            </div>
        </form>
        <!-- === FIN: FORMULARIO DE FILTROS REDISEÑADO === -->
        
        <nav class="flex flex-wrap items-center gap-2 mb-8 border-b border-gray-700 pb-4">
            <span class="font-semibold mr-2 text-gray-300">Filtrar por tipo:</span>
            <a href="{{ route('tienda.index', request()->except('tipo', 'page')) }}"
               class="px-4 py-2 text-sm font-medium rounded-full transition
                      {{ !isset($selectedTipo) || $selectedTipo == '' ? 'bg-red-600 text-white' : 'bg-gray-700 text-gray-300 border border-gray-600 hover:bg-gray-600' }}">
                Todos
            </a>

            @if(isset($tiposDisponibles) && is_array($tiposDisponibles))
                @foreach ($tiposDisponibles as $tipoValue)
                    @php
                        $tipoLabel = ucwords(strtolower(str_replace(['_', '/'], [' ', ' / '], $tipoValue)));
                    @endphp
                    <a href="{{ route('tienda.index', array_merge(request()->except('page'), ['tipo' => $tipoValue])) }}"
                       class="px-4 py-2 text-sm font-medium rounded-full transition
                              {{ (isset($selectedTipo) && $selectedTipo == $tipoValue) ? 'bg-red-600 text-white' : 'bg-gray-700 text-gray-300 border border-gray-600 hover:bg-gray-600' }}">
                        {{ $tipoLabel }}
                    </a>
                @endforeach
            @endif
        </nav>
        
        @if(session('success'))
            <div class="bg-green-700 border border-green-600 text-white px-4 py-3 rounded-lg relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-700 border border-red-600 text-white px-4 py-3 rounded-lg relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($productos->isEmpty())
            <p class="text-gray-400 text-center py-10 text-lg">No se encontraron productos que coincidan con tu búsqueda.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    {{-- Tarjetas de producto adaptadas al tema oscuro --}}
                    <div
                        class="bg-gray-800 shadow-lg rounded-xl overflow-hidden flex flex-col border border-gray-700 transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-red-500/20 hover:border-gray-600 cursor-pointer"
                        @click="$dispatch('open-product-modal', {{ json_encode($producto->toArray()) }})"
                    >
                        <div class="block">
                            <img src="{{ asset('images/' . $producto->imagen) }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <h2 class="text-xl font-semibold text-gray-100 mb-1">
                                <span class="hover:text-red-500 transition-colors duration-200">{{ $producto->nombre }}</span>
                            </h2>

                            @if(isset($producto->valoracion) && $producto->valoracion > 0)
                            <div class="flex items-center mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 @if($i <= $producto->valoracion) text-yellow-400 @else text-gray-600 @endif" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="text-xs text-gray-400 ml-1">({{ $producto->valoracion }})</span>
                            </div>
                            @endif

                            @if($producto->tipo)
                                <p class="text-xs text-gray-400 mb-1">Tipo:
                                    {{ ucwords(strtolower(str_replace(['_', '/'], [' ', ' / '], $producto->tipo))) }}
                                </p>
                            @endif
                            <p class="text-gray-300 text-sm mb-2 flex-grow min-h-[4.5rem]">
                                {{ Str::limit($producto->descripcion, 90) }}
                            </p>
                            <p class="text-lg font-bold text-red-500 mb-1">
                                {{ number_format($producto->precio_unitario, 2, ',', '.') }} €
                            </p>
                            <p class="text-xs text-gray-400 mb-3">
                                Disponibles: {{ $producto->cantidad_disponible }}
                            </p>

                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-auto" @click.stop>
                                @csrf
                                <div class="flex items-center mb-3">
                                    <label for="cantidad-{{$producto->id}}" class="mr-2 text-sm text-gray-300">Cant:</label>
                                    <input type="number" name="cantidad" id="cantidad-{{$producto->id}}" value="1" min="1" max="{{ $producto->cantidad_disponible > 0 ? $producto->cantidad_disponible : 1 }}"
                                        class="w-16 px-2 py-1 bg-gray-700 text-gray-200 border border-gray-600 rounded-md text-sm focus:ring-red-500 focus:border-red-500"
                                        @if($producto->cantidad_disponible == 0) disabled @endif>
                                </div>
                                <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transform hover:scale-105
                                               @if($producto->cantidad_disponible == 0) bg-gray-600 hover:bg-gray-600 cursor-not-allowed @endif"
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
                {{-- CORRECCIÓN: Se usa la paginación por defecto, que será estilizada por el CSS de arriba --}}
                {{ $productos->links() }}
            </div>
        @endif
    </div>

    {{-- BOTÓN FLOTANTE DEL CARRITO Y MODAL (adaptado) --}}
    <a href="{{ route('carrito.view') }}" title="Ver Cesta" class="fixed bottom-6 right-6 bg-red-600 hover:bg-red-700 text-white p-3 rounded-full shadow-xl transition-transform duration-150 ease-in-out hover:scale-110 z-50 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        @if(isset($cartItemCount) && $cartItemCount > 0)
            <span class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full bg-blue-500 text-xs font-bold text-white border-2 border-gray-800">{{ $cartItemCount }}</span>
        @endif
    </a>

    <div x-data="productModal()" x-show="showModal" x-on:open-product-modal.window="openModal($event.detail)" x-on:keydown.escape.window="closeModal()" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto bg-black bg-opacity-75 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div @click.outside="closeModal()" x-show="showModal" x-transition class="bg-gray-800 border border-gray-700 rounded-2xl shadow-xl max-w-3xl w-full p-6 mx-auto overflow-hidden text-left transform transition-all">
            {{-- Aquí iría el contenido del modal, que también debería seguir el tema oscuro --}}
        </div>
    </div>

    @push('scripts')
    <script>
        function productModal() { return { showModal: false, product: {}, openModal(productData) { if (typeof productData === 'object' && productData !== null) { this.product = productData; } else { this.product = { nombre: 'Detalles no disponibles', descripcion: '', imagen: null, image_url: 'https://via.placeholder.com/400x300?text=Producto', precio_unitario: null, cantidad_disponible: 0, sku: null, id: null, tipo: null, valoracion: 0 }; console.error('Invalid product data received for modal:', productData); } this.showModal = true; this.$nextTick(() => { const modalTitle = document.getElementById('modal-title'); if(modalTitle) modalTitle.focus(); }); }, closeModal() { this.showModal = false; } } }
        
        document.addEventListener('DOMContentLoaded', function () {
            const ratingSlider = document.getElementById('rating-filter');
            const ratingDisplay = document.getElementById('rating-display');
            const starSVG = `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>`;

            function updateRatingDisplay(value) {
                let starsHTML = '';
                if (value == 0) {
                    ratingDisplay.innerHTML = '<span class="text-gray-400">Cualquiera</span>';
                    return;
                }
                for (let i = 1; i <= 5; i++) {
                    starsHTML += `<span class="${i <= value ? 'text-yellow-400' : 'text-gray-600'}">${starSVG}</span>`;
                }
                starsHTML += `<span class="ml-1.5 text-gray-200 font-semibold">${value}</span>`;
                ratingDisplay.innerHTML = starsHTML;
            }
            
            function updateSliderStyle(slider) {
                const value = slider.value;
                const min = slider.min;
                const max = slider.max;
                const percent = (value - min) / (max - min) * 100;
                slider.style.setProperty('--value-percent', `${percent}%`);
                updateRatingDisplay(value);
            }

            if(ratingSlider) {
                ratingSlider.addEventListener('input', function () { updateSliderStyle(this); });
                updateSliderStyle(ratingSlider);
            }
        });
    </script>
    @endpush
</x-app-layout>