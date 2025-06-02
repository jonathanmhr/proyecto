<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Tienda') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-orange-500 mb-4 md:mb-0">Nuestros Productos</h1>
            <form method="GET" action="{{ route('tienda.index') }}" class="w-full md:w-auto">
                <div class="flex items-center">
                    <input
                        type="text"
                        name="search"
                        placeholder="Buscar por nombre..."
                        value="{{ $searchTerm ?? '' }}"
                        class="px-4 py-2 border border-gray-700 bg-gray-800 text-gray-200 rounded-l-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 w-full md:w-64"
                    >
                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-r-md transition duration-150 ease-in-out"
                    >
                        Buscar
                    </button>
                    @if(isset($searchTerm) && $searchTerm)
                        <a href="{{ route('tienda.index') }}" class="ml-2 text-sm text-gray-400 hover:text-gray-200 underline">Limpiar</a>
                    @endif
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-700 border border-green-600 text-white px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-700 border border-red-600 text-white px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($productos->isEmpty())
            @if(isset($searchTerm) && $searchTerm)
                <p class="text-gray-400 text-center py-10">No se encontraron productos que coincidan con "<strong>{{ $searchTerm }}</strong>".</p>
            @else
                <p class="text-gray-400 text-center py-10">No hay productos disponibles en este momento.</p>
            @endif
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <div
                        class="bg-gray-800 shadow-lg rounded-lg overflow-hidden flex flex-col transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-700"
                        @click="$dispatch('open-product-modal', {{ $producto->id }})" {{-- Solo pasamos el ID --}}
                    >
                        <div class="block">
                            <img src="{{ $producto->imagen ? asset('storage/images/' . $producto->imagen) : asset('images/default_product.png') }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <h2 class="text-xl font-semibold text-gray-100 mb-2">
                                <span class="hover:text-orange-500 transition-colors duration-200">{{ $producto->nombre }}</span>
                            </h2>
                            <p class="text-gray-400 text-sm mb-2 flex-grow min-h-[4.5rem]">
                                {{ Str::limit($producto->descripcion, 90) }}
                            </p>
                            <p class="text-lg font-bold text-orange-500 mb-1">
                                {{ number_format($producto->precio_unitario, 2, ',', '.') }} €
                            </p>
                            <p class="text-xs text-gray-500 mb-3">
                                Disponibles: {{ $producto->cantidad_disponible }}
                            </p>

                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-auto" @click.stop>
                                @csrf
                                <div class="flex items-center mb-3">
                                    <label for="cantidad-{{$producto->id}}" class="mr-2 text-sm text-gray-300">Cant:</label>
                                    <input type="number" name="cantidad" id="cantidad-{{$producto->id}}" value="1" min="1" max="{{ $producto->cantidad_disponible > 0 ? $producto->cantidad_disponible : 1 }}"
                                        class="w-16 px-2 py-1 border border-gray-700 bg-gray-900 text-gray-200 rounded-md text-sm focus:ring-orange-500 focus:border-orange-500"
                                        @if($producto->cantidad_disponible == 0) disabled @endif>
                                </div>
                                <button type="submit"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transform hover:scale-105
                                                @if($producto->cantidad_disponible == 0) bg-gray-700 hover:bg-gray-700 cursor-not-allowed @endif"
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

    <a href="{{ route('carrito.view') }}"
       title="Ver Cesta"
       class="fixed bottom-6 right-6 bg-orange-600 hover:bg-orange-700 text-white p-3 rounded-full shadow-xl transition-transform duration-150 ease-in-out hover:scale-110 z-50 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>

        @if(isset($cartItemCount) && $cartItemCount > 0)
            <span class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white border-2 border-white">
                {{ $cartItemCount }}
            </span>
        @endif
    </a>

    {{-- Modal del Producto --}}
    <div
        x-data="productModal({{ json_encode($productos->toArray()) }})" {{-- Pasar todos los productos aquí --}}
        x-show="showModal"
        x-on:open-product-modal.window="openModal($event.detail)"
        x-on:keydown.escape.window="closeModal()"
        style="display: none;"
        class="fixed inset-0 z-[60] overflow-y-auto bg-black bg-opacity-75 flex items-center justify-center"
        role="dialog"
        aria-modal="true"
    >
        <div
            @click.outside="closeModal()"
            x-show="showModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="bg-gray-800 rounded-2xl shadow-xl max-w-3xl w-full p-6 mx-4 overflow-hidden text-left transform transition-all border border-gray-700"
        >
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-100" id="modal-title" tabindex="-1" x-text="product.nombre"></h3>
                <button type="button" @click="closeModal()" class="text-gray-400 hover:text-red-500 transition-colors duration-200">
                    <span class="sr-only">Cerrar modal</span>
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:order-1">
                    <img
                        :src="product.imagen ? '{{ asset('storage/images') }}/' + product.imagen : '{{ asset('images/default_product.png') }}'"
                        :alt="product.nombre"
                        class="w-full h-auto max-h-[400px] object-contain rounded-lg shadow-lg"
                    >
                </div>
                <div class="md:order-2 flex flex-col">
                    <p class="text-sm text-gray-400 mb-1" x-show="product.sku">SKU: <span x-text="product.sku"></span></p>
                    <p class="text-3xl font-extrabold text-orange-500 mb-3">
                        <span x-text="typeof product.precio_unitario !== 'undefined' ? parseFloat(product.precio_unitario).toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }) : ''"></span>
                    </p>

                    <h4 class="font-semibold text-gray-300 mt-2 mb-1 border-b border-gray-700 pb-1">Descripción:</h4>
                    <div class="text-sm text-gray-400 prose max-w-none overflow-y-auto max-h-40 pr-2 custom-scrollbar">
                        <p x-html="product.descripcion"></p>
                    </div>

                    <p class="text-xs text-gray-500 mt-3">
                        Disponibles: <span x-text="product.cantidad_disponible"></span>
                    </p>

                    <div class="mt-auto pt-4 border-t border-gray-700">
                        <form :action="`{{ url('/carrito/agregar') }}/${product.id}`" method="POST" class="w-full" x-show="product.cantidad_disponible > 0">
                            @csrf
                            <div class="flex items-center mb-3">
                                <label :for="`modal-cantidad-${product.id}`" class="mr-2 text-sm text-gray-300">Cantidad:</label>
                                <input
                                    type="number"
                                    name="cantidad"
                                    :id="`modal-cantidad-${product.id}`"
                                    x-model="quantity"
                                    min="1"
                                    :max="product.cantidad_disponible > 0 ? product.cantidad_disponible : 1"
                                    class="w-20 px-3 py-2 border border-gray-700 bg-gray-900 text-gray-200 rounded-lg text-base focus:ring-orange-500 focus:border-orange-500 focus:outline-none"
                                >
                            </div>
                            <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transform hover:scale-[1.02]"
                            >
                                Añadir al Carrito
                            </button>
                        </form>
                        <div x-show="product.cantidad_disponible == 0" class="mt-6 p-4 bg-gray-700 text-gray-300 rounded-lg text-center border border-gray-600 font-semibold">
                            Producto Agotado
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="button" @click="closeModal()"
                        class="px-5 py-2 text-sm font-medium text-gray-200 bg-gray-700 border border-transparent rounded-lg hover:bg-gray-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500 transition-colors duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
        function productModal(allProducts) {
            return {
                showModal: false,
                product: {},
                allProducts: allProducts, // Almacenar todos los productos
                quantity: 1, // Cantidad por defecto para el modal

                openModal(productId) {
                    // Buscar el producto por ID en la lista allProducts
                    this.product = this.allProducts.find(p => p.id === productId);
                    this.quantity = 1; // Resetear cantidad al abrir
                    this.showModal = true;
                    this.$nextTick(() => {
                        const modalTitle = document.getElementById('modal-title');
                        if(modalTitle) modalTitle.focus();
                    });
                },
                closeModal() {
                    this.showModal = false;
                    this.product = {};
                    this.quantity = 1; // Resetear cantidad al cerrar
                }
            }
        }
    </script>
    <style>
        /* Estilo personalizado para el scrollbar en navegadores Webkit (Chrome, Safari) */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #4a5568; /* gray-700 */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #f6ad55; /* orange-400, o puedes usar orange-500 si prefieres */
            border-radius: 10px;
            border: 2px solid #4a5568; /* gray-700 */
        }
    </style>
</x-app-layout>