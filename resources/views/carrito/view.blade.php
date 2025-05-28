<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carrito') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-red-600 mb-6">Carrito</h1>

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

        @if(empty($carrito))
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-red-600">Tu carrito está vacío</h3>
                <p class="mt-1 text-sm text-gray-100">Empieza a añadir productos para verlos aquí.</p>
                <div class="mt-6">
                    <a href="{{ route('tienda.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Ir a la tienda
                    </a>
                </div>
            </div>
        @else
            {{-- CORRECCIÓN AQUÍ: Añadido el > --}}
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-2/3">
                    <div class="bg-white shadow-md rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Artículos del Carrito ({{ count($carrito) }})</h2>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach ($carrito as $id => $item)
                            <li class="p-4 sm:p-6">
                                <div class="flex items-start sm:items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-20 w-20 sm:h-24 sm:w-24 rounded-md object-cover"
                                             src="{{ (isset($item['imagen_url']) && $item['imagen_url']) ? asset('images/' . $item['imagen_url']) : 'https://via.placeholder.com/100?text=Producto' }}"
                                             alt="{{ $item['nombre'] }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base sm:text-lg font-medium text-gray-900 hover:text-blue-600">
                                            <a href="#">{{ $item['nombre'] }}</a>
                                        </h3>
                                        @if(isset($item['sku']) && $item['sku']) {{-- Añadida comprobación isset para sku --}}
                                            <p class="text-xs sm:text-sm text-gray-500">SKU: {{ $item['sku'] }}</p>
                                        @endif
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                            Precio Unit.: {{ number_format($item['precio_unitario'], 2, ',', '.') }} €
                                        </p>

                                        <div class="mt-2 flex items-center">
                                            <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="inline-flex items-center">
                                                @csrf
                                                <label for="cantidad-{{ $id }}" class="sr-only">Cantidad</label>
                                                <input type="number" name="cantidad" id="cantidad-{{ $id }}" value="{{ $item['cantidad'] }}" min="1"
                                                       class="w-16 px-2 py-1 border border-gray-300 rounded-md text-sm text-center mr-2 focus:ring-blue-500 focus:border-blue-500">
                                                <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end ml-auto">
                                        <p class="text-sm sm:text-base font-semibold text-gray-900">
                                            {{ number_format($item['precio_unitario'] * $item['cantidad'], 2, ',', '.') }} €
                                        </p>
                                        <form action="{{ route('carrito.eliminar', $id) }}" method="POST" class="mt-2">
                                            @csrf
                                            <button type="submit" class="text-xs sm:text-sm text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="px-6 py-4 border-t border-gray-200">
                             <form action="{{ route('carrito.vaciar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres vaciar el carrito?');" class="inline-block">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    Vaciar Carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-white shadow-md rounded-lg p-6 sticky top-8">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-4 mb-4">Resumen del Pedido</h2>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal ({{ count($carrito) }} productos):</span>
                                <span class="font-medium text-gray-800">{{ number_format($totalCarrito, 2, ',', '.') }} €</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Envío:</span>
                                <span class="font-medium text-gray-800">Gratis</span>
                            </div>
                             <div class="flex justify-between">
                                <span class="text-gray-600">Impuestos (IVA 21%):</span>
                                <span class="font-medium text-gray-800">{{ number_format($totalCarrito * 0.21, 2, ',', '.') }} €</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mt-4">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-semibold text-gray-800">Total del Pedido:</span>
                                <span class="text-xl font-bold text-gray-900">{{ number_format($totalCarrito * 1.21, 2, ',', '.') }} €</span>
                            </div>

                            <a href="{{ route('checkout.index') }}"
                               class="w-full block text-center bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-4 rounded text-lg shadow-sm transition duration-150 ease-in-out">
                                Proceder al Pago
                            </a>
                        </div>

                        <div class="mt-6 text-sm text-gray-500">
                            <p class="font-semibold">Opciones de pago aceptadas:</p>
                            <div class="flex space-x-2 mt-2 items-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/Visa_Logo.svg/1280px-Visa_Logo.svg.png" alt="Visa" class="h-6">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" class="h-6">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/1280px-PayPal.svg.png" alt="PayPal" class="h-6">
                            </div>
                            <p class="mt-2">Garantía de compra segura.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>