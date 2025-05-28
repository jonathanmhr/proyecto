<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pago') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-red-600 mb-6">Finalizar Compra</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-1/3 bg-gray-50 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Resumen del Pedido</h2>
            @if(!empty($carrito))
                @foreach($carrito as $item)
                <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-b-0">
                    <div>
                        <p class="font-medium">{{ $item['nombre'] }} <span class="text-xs text-gray-500">(x{{ $item['cantidad'] }})</span></p>
                    </div>
                    <p class="text-gray-700">{{ number_format($item['precio_unitario'] * $item['cantidad'], 2, ',', '.') }} €</p>
                </div>
                @endforeach
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-300">
                    <p class="text-lg font-bold">Total:</p>
                    <p class="text-lg font-bold">{{ number_format($totalCarrito, 2, ',', '.') }} €</p>
                </div>
            @endif
        </div>

        <div class="md:w-2/3 bg-white p-6 rounded-lg shadow">
            <form action="{{ route('checkout.procesar') }}" method="POST">
                @csrf
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Información de Facturación</h2>

                <div class="mb-4">
                    <label for="nombre_facturacion" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                    <input type="text" name="nombre_facturacion" id="nombre_facturacion" value="{{ old('nombre_facturacion', Auth::user()->name) }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('nombre_facturacion') border-red-500 @enderror">
                    @error('nombre_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="email_facturacion" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input type="email" name="email_facturacion" id="email_facturacion" value="{{ old('email_facturacion', Auth::user()->email) }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email_facturacion') border-red-500 @enderror">
                    @error('email_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Aquí podrías añadir más campos: dirección, ciudad, código postal, etc. --}}
                {{-- Y también la selección del método de pago si tuvieras varios --}}
                <input type="hidden" name="metodo_pago" value="simulado_tarjeta">


                <div class="mt-6">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Pagar {{ number_format($totalCarrito, 2, ',', '.') }} € y Confirmar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>

