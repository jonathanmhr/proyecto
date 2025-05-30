<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pago') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-red-600 dark:text-red-400 mb-6">Finalizar Compra</h1>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Ups! Hubo algunos problemas con tu información:</strong>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/3 bg-gray-50 dark:bg-gray-800 p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Resumen del Pedido</h2>
                @if(!empty($carrito))
                    @foreach($carrito as $item)
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-200">{{ $item['nombre'] }} <span class="text-xs text-gray-500 dark:text-gray-400">(x{{ $item['cantidad'] }})</span></p>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">{{ number_format($item['precio_unitario'] * $item['cantidad'], 2, ',', '.') }} €</p>
                    </div>
                    @endforeach
                    <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-300 dark:border-gray-600">
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-100">Total:</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalCarrito, 2, ',', '.') }} €</p>
                    </div>
                @else
                    <p class="text-gray-600 dark:text-gray-400">Tu carrito está vacío.</p>
                @endif
            </div>

            <div class="md:w-2/3 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <form action="{{ route('checkout.procesar') }}" method="POST">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-6">Información de Facturación</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="nombre_facturacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre Completo</label>
                            <input type="text" name="nombre_facturacion" id="nombre_facturacion" value="{{ old('nombre_facturacion', Auth::user()->name ?? '') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('nombre_facturacion') border-red-500 @enderror">
                            @error('nombre_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email_facturacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo Electrónico</label>
                            <input type="email" name="email_facturacion" id="email_facturacion" value="{{ old('email_facturacion', Auth::user()->email ?? '') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email_facturacion') border-red-500 @enderror">
                            @error('email_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="direccion_facturacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dirección</label>
                        <input type="text" name="direccion_facturacion" id="direccion_facturacion" value="{{ old('direccion_facturacion') }}" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('direccion_facturacion') border-red-500 @enderror">
                        @error('direccion_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="ciudad_facturacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ciudad</label>
                            <input type="text" name="ciudad_facturacion" id="ciudad_facturacion" value="{{ old('ciudad_facturacion') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('ciudad_facturacion') border-red-500 @enderror">
                            @error('ciudad_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="codigo_postal_facturacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código Postal</label>
                            <input type="text" name="codigo_postal_facturacion" id="codigo_postal_facturacion" value="{{ old('codigo_postal_facturacion') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('codigo_postal_facturacion') border-red-500 @enderror">
                            @error('codigo_postal_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="pais_facturacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">País</label>
                            <input type="text" name="pais_facturacion" id="pais_facturacion" value="{{ old('pais_facturacion') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('pais_facturacion') border-red-500 @enderror">
                            @error('pais_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="telefono_facturacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
                            <input type="tel" name="telefono_facturacion" id="telefono_facturacion" value="{{ old('telefono_facturacion') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('telefono_facturacion') border-red-500 @enderror">
                            @error('telefono_facturacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mt-8 mb-4">Información de Envío y Pago</h2>

                     <div class="mb-4">
                        <label for="metodo_envio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Método de Envío</label>
                        <select name="metodo_envio" id="metodo_envio" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('metodo_envio') border-red-500 @enderror">
                            <option value="">Seleccione un método</option>
                            <option value="estandar" {{ old('metodo_envio') == 'estandar' ? 'selected' : '' }}>Envío Estándar (3-5 días)</option>
                            <option value="express" {{ old('metodo_envio') == 'express' ? 'selected' : '' }}>Envío Express (1-2 días)</option>
                        </select>
                        @error('metodo_envio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="metodo_pago" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Método de Pago</label>
                        <select name="metodo_pago" id="metodo_pago" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('metodo_pago') border-red-500 @enderror">
                            <option value="simulado_tarjeta" {{ old('metodo_pago', 'simulado_tarjeta') == 'simulado_tarjeta' ? 'selected' : '' }}>Tarjeta de Crédito/Débito (Simulado)</option>
                            {{-- <option value="paypal" {{ old('metodo_pago') == 'paypal' ? 'selected' : '' }}>PayPal (Simulado)</option> --}}
                        </select>
                        @error('metodo_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div id="tarjeta_info_simulada" class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-md bg-gray-50 dark:bg-gray-700/50" style="{{ old('metodo_pago', 'simulado_tarjeta') !== 'simulado_tarjeta' ? 'display:none;' : '' }}">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Introduce los datos de tu tarjeta (simulación, no se almacenarán datos reales):</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="card_number_simulado" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Número de Tarjeta</label>
                                <input type="text" name="card_number_simulado" id="card_number_simulado" value="{{ old('card_number_simulado') }}" placeholder="**** **** **** ****"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm sm:text-sm @error('card_number_simulado') border-red-500 @enderror">
                                @error('card_number_simulado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="card_expiry_simulado" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Fecha de Caducidad (MM/AA)</label>
                                <input type="text" name="card_expiry_simulado" id="card_expiry_simulado" value="{{ old('card_expiry_simulado') }}" placeholder="MM/AA"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm sm:text-sm @error('card_expiry_simulado') border-red-500 @enderror">
                                @error('card_expiry_simulado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="card_cvc_simulado" class="block text-xs font-medium text-gray-700 dark:text-gray-300">CVC/CVV</label>
                                <input type="text" name="card_cvc_simulado" id="card_cvc_simulado" value="{{ old('card_cvc_simulado') }}" placeholder="***"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm sm:text-sm @error('card_cvc_simulado') border-red-500 @enderror">
                                @error('card_cvc_simulado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50">
                            Pagar {{ number_format($totalCarrito, 2, ',', '.') }} € y Confirmar Pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const metodoPagoSelect = document.getElementById('metodo_pago');
            const tarjetaInfoDiv = document.getElementById('tarjeta_info_simulada');

            function toggleTarjetaInfo() {
                if (metodoPagoSelect.value === 'simulado_tarjeta') {
                    tarjetaInfoDiv.style.display = 'block';
                } else {
                    tarjetaInfoDiv.style.display = 'none';
                }
            }

            metodoPagoSelect.addEventListener('change', toggleTarjetaInfo);
            toggleTarjetaInfo();
        });
    </script>
</x-app-layout>