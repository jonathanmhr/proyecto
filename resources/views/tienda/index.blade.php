<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tienda') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-red-600 mb-4 md:mb-0">Nuestros Productos</h1>

            <form method="GET" action="{{ route('tienda.index') }}" class="w-full md:w-auto">
                <div class="flex flex-wrap items-center gap-2">
                    <input
                        type="text"
                        name="search"
                        placeholder="Buscar por nombre..."
                        value="{{ $searchTerm ?? '' }}"
                        class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-auto md:w-64"
                    >
                    <select
                        name="tipo"
                        class="px-8 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-auto"
                        onchange="this.form.submit()"
                    >
                        <option value="">Todos los tipos</option>
                        @if(isset($tiposDisponibles) && is_array($tiposDisponibles))
                            @foreach ($tiposDisponibles as $tipoValue)
                                <option value="{{ $tipoValue }}" {{ (isset($selectedTipo) && $selectedTipo == $tipoValue) ? 'selected' : '' }}>
                                    {{ $tipoValue === 'CONSUMICION' ? 'Consumición' : ($tipoValue === 'EQUIPAMIENTO' ? 'Equipamiento' : ucfirst(strtolower($tipoValue))) }}
                                </option>
                            @endforeach
                        @else
                            <option value="CONSUMICION" {{ (isset($selectedTipo) && $selectedTipo == 'CONSUMICION') ? 'selected' : '' }}>Consumición</option>
                            <option value="EQUIPAMIENTO" {{ (isset($selectedTipo) && $selectedTipo == 'EQUIPAMIENTO') ? 'selected' : '' }}>Equipamiento</option>
                        @endif
                    </select>
                    @if((isset($searchTerm) && $searchTerm) || (isset($selectedTipo) && $selectedTipo))
                        <a href="{{ route('tienda.index') }}" class="ml-2 text-sm text-gray-600 hover:text-gray-800 underline">Limpiar filtros</a>
                    @endif
                </div>
            </form>
        </div>

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
            <p class="text-gray-600 text-center py-10">
                @php
                    $mensaje = "";
                    $hasSearch = isset($searchTerm) && $searchTerm;
                    $hasType = isset($selectedTipo) && $selectedTipo;
                    $tipoLabel = $hasType ? ($selectedTipo === 'CONSUMICION' ? 'Consumición' : ($selectedTipo === 'EQUIPAMIENTO' ? 'Equipamiento' : ucfirst(strtolower($selectedTipo)) )) : '';

                    if ($hasSearch && $hasType) {
                        $mensaje = "No se encontraron productos que coincidan con \"<strong>" . e($searchTerm) . "</strong>\" y tipo \"<strong>" . e($tipoLabel) . "</strong>\".";
                    } elseif ($hasSearch) {
                        $mensaje = "No se encontraron productos que coincidan con \"<strong>" . e($searchTerm) . "</strong>\".";
                    } elseif ($hasType) {
                        $mensaje = "No se encontraron productos del tipo \"<strong>" . e($tipoLabel) . "</strong>\".";
                    } else {
                        $mensaje = "No hay productos disponibles en este momento.";
                    }
                @endphp
                {!! $mensaje !!}
            </p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <div
                        class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl cursor-pointer"
                        @click="$dispatch('open-product-modal', {{ json_encode($producto->toArray()) }})"
                    >
                        <div class="block">
                            <img src="{{ $producto->image_url ?? ($producto->imagen ? asset('images/' . $producto->imagen) : 'https://via.placeholder.com/300x200?text=Producto') }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                                <span class="hover:text-indigo-600 transition-colors duration-200">{{ $producto->nombre }}</span>
                            </h2>
                            @if($producto->tipo)
                                <p class="text-xs text-gray-500 mb-1">Tipo:
                                    {{ $producto->tipo === 'CONSUMICION' ? 'Consumición' : ($producto->tipo === 'EQUIPAMIENTO' ? 'Equipamiento' : ucfirst(strtolower($producto->tipo))) }}
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

    <div
        x-data="productModal()"
        x-show="showModal"
        x-on:open-product-modal.window="openModal($event.detail)"
        x-on:keydown.escape.window="closeModal()"
        style="display: none;"
        class="fixed inset-0 z-[60] overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-title"
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
            class="bg-white rounded-2xl shadow-xl max-w-3xl w-full p-6 mx-auto overflow-hidden text-left transform transition-all"
        >
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-900" id="modal-title" tabindex="-1" x-text="product.nombre"></h3>
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
                        :src="product.image_url ? product.image_url : (product.imagen ? '{{ asset('images') }}/' + product.imagen : 'https://via.placeholder.com/400x300?text=Producto')"
                        :alt="product.nombre"
                        class="w-full h-auto max-h-[400px] object-contain rounded-lg shadow"
                    >
                </div>
                <div class="md:order-2 flex flex-col">
                    <p class="text-sm text-gray-500 mb-1" x-show="product.sku">SKU: <span x-text="product.sku"></span></p>
                    <p class="text-sm text-gray-500 mb-1" x-show="product.tipo">
                        Tipo: <span x-text="product.tipo ? (product.tipo === 'CONSUMICION' ? 'Consumición' : (product.tipo === 'EQUIPAMIENTO' ? 'Equipamiento' : (product.tipo.charAt(0).toUpperCase() + product.tipo.slice(1).toLowerCase()))) : ''"></span>
                    </p>
                    <p class="text-2xl font-bold text-indigo-600 mb-3">
                        <span x-text="typeof product.precio_unitario !== 'undefined' && product.precio_unitario !== null ? parseFloat(product.precio_unitario).toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }) : ''"></span>
                    </p>

                    <h4 class="font-semibold text-gray-700 mt-2 mb-1">Descripción:</h4>
                    <div class="text-sm text-gray-600 prose max-w-none overflow-y-auto max-h-40 pr-2" x-html="product.descripcion || 'No hay descripción disponible.'"></div>

                    <p class="text-xs text-gray-500 mt-3">
                        Disponibles: <span x-text="product.cantidad_disponible"></span>
                    </p>

                    <div class="mt-auto pt-4">
                        <form :action="product.id ? `{{ url('/carrito/agregar') }}/${product.id}` : '#'" method="POST" class="w-full" x-show="product.id && product.cantidad_disponible > 0">
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
                        <div x-show="!product.id || product.cantidad_disponible == 0" class="mt-6 p-3 bg-gray-100 text-gray-600 rounded text-center">
                            <span x-show="product.id && product.cantidad_disponible == 0">Producto Agotado</span>
                            <span x-show="!product.id">Información del producto no disponible</span>
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

    @push('scripts')
    <script>
        function productModal() {
            return {
                showModal: false,
                product: {},
                openModal(productData) {
                    if (typeof productData === 'object' && productData !== null) {
                        this.product = productData;
                    } else {
                        this.product = {
                            nombre: 'Detalles no disponibles',
                            descripcion: '',
                            imagen: null,
                            image_url: 'https://via.placeholder.com/400x300?text=Producto',
                            precio_unitario: null,
                            cantidad_disponible: 0,
                            sku: null,
                            id: null,
                            tipo: null
                        };
                        console.error('Invalid product data received for modal:', productData);
                    }
                    this.showModal = true;
                    this.$nextTick(() => {
                        const modalTitle = document.getElementById('modal-title');
                        if(modalTitle) modalTitle.focus();
                    });
                },
                closeModal() {
                    this.showModal = false;
                }
            }
        }
    </script>
    @endpush

</x-app-layout>