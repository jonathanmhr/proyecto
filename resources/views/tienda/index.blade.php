<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tienda') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-red-600 mb-6">Nuestros Productos</h1>

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
            <p class="text-gray-600">No hay productos disponibles en este momento.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <div 
                        class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl cursor-pointer"
                        @click="$dispatch('open-product-modal', {{ json_encode($producto) }})"
                    >
                        <div class="block">
                            <img src="{{ $producto->imagen ? asset('images/' . $producto->imagen) : 'https://via.placeholder.com/300x200?text=Producto' }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                                <span class="hover:text-indigo-600 transition-colors duration-200">{{ $producto->nombre }}</span>
                            </h2>
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

    <a href="{{ route('carrito.view') }}"
       title="Ver Cesta"
       class="fixed bottom-6 right-6 bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-full shadow-xl transition-transform duration-150 ease-in-out hover:scale-110 z-50 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>

        @if(isset($cartItemCount) && $cartItemCount > 0)
            <span class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white border-2 border-white">
                {{ $cartItemCount }}
            </span>
        @endif
    </a>
    <a href="{{ route('compra.show') }}"
       title="Mis pedidos"
       class="fixed bottom-6 right-6 bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-full shadow-xl transition-transform duration-150 ease-in-out hover:scale-110 z-50 flex items-center justify-center">
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
        x-data="productModal()"
        x-show="showModal"
        x-on:open-product-modal.window="openModal($event.detail)"
        x-on:keydown.escape.window="closeModal()"
        style="display: none;"
        class="fixed inset-0 z-[60] overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center"
        role="dialog"
        aria-modal="true"
    >
        <div 
            @click.outside="closeModal()" 
            x-show="showModal"
            x-transition
            class="bg-white rounded-2xl shadow-xl max-w-3xl w-full p-6 mx-4 overflow-hidden text-left transform transition-all"
        >
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-900" tabindex="-1" x-text="product.nombre"></h3>
                <button type="button" @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="sr-only">Cerrar modal</span>
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:order-1">
                    <img 
                        :src="product.imagen ? '{{ asset('images') }}/' + product.imagen : 'https://via.placeholder.com/400x300?text=Producto'"
                        :alt="product.nombre"
                        class="w-full h-auto max-h-[400px] object-contain rounded-lg shadow"
                    >
                </div>
                <div class="md:order-2 flex flex-col">
                    <p class="text-sm text-gray-500 mb-1" x-show="product.sku">SKU: <span x-text="product.sku"></span></p>
                    <p class="text-2xl font-bold text-indigo-600 mb-3">
                        <span x-text="typeof product.precio_unitario !== 'undefined' ? parseFloat(product.precio_unitario).toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }) : ''"></span>
                    </p>

                    <h4 class="font-semibold text-gray-700 mt-2 mb-1">Descripción:</h4>
                    <div class="text-sm text-gray-600 prose max-w-none overflow-y-auto max-h-40 pr-2" x-html="product.descripcion"></div>

                    <p class="text-xs text-gray-500 mt-3">
                        Disponibles: <span x-text="product.cantidad_disponible"></span>
                    </p>

                    <div class="mt-auto pt-4">
                        <form :action="`{{ url('/carrito/agregar') }}/${product.id}`" method="POST" class="w-full" x-show="product.cantidad_disponible > 0">
                            @csrf
                            <div class="flex items-center mb-3">
                                <label :for="`modal-cantidad-${product.id}`" class="mr-2 text-sm text-gray-700">Cant:</label>
                                <input 
                                    type="number" 
                                    name="cantidad" 
                                    :id="`modal-cantidad-${product.id}`" 
                                    value="1" min="1" 
                                    :max="product.cantidad_disponible > 0 ? product.cantidad_disponible : 1"
                                    class="w-20 px-2 py-1 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                >
                            </div>
                            <button type="submit"
                                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transform hover:scale-105"
                            >
                                Añadir al Carrito
                            </button>
                        </form>
                        <div x-show="product.cantidad_disponible == 0" class="mt-6 p-3 bg-gray-100 text-gray-600 rounded text-center">
                            Producto Agotado
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="button" @click="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
        function productModal() {
            return {
                showModal: false,
                product: {},
                openModal(productData) {
                    this.product = productData;
                    this.showModal = true;
                    this.$nextTick(() => {
                        // Puedes manejar el foco aquí si quieres
                        const modalTitle = document.getElementById('modal-title');
                        if(modalTitle) modalTitle.focus();
                    });
                },
                closeModal() {
                    this.showModal = false;
                    this.product = {};
                }
            }
        }
    </script>
</x-app-layout>
