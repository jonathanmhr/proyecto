<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Detalle de Compra <span class="text-red-500">#{{ $compra->id }}</span>
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-lg border border-gray-700">

            @if(session('success'))
                <div class="bg-green-700/80 border border-green-600 text-white px-4 py-3 rounded-lg relative mb-8 flex items-center justify-between" role="alert">
                    <span>{{ session('success') }}</span>
                    @if(session('factura_pdf_url') || ($compra->factura && $compra->factura->ruta_pdf))
                        <a href="{{ route('factura.pdf.generar', $compra->id) }}" target="_blank" class="font-bold underline ml-4 hover:text-green-200 transition-colors">Ver Factura PDF</a>
                    @endif
                </div>
            @endif

            {{-- Bloques de información principales --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                {{-- Información de la Compra --}}
                <div class="bg-gray-900/50 p-6 rounded-lg border border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-200 border-b border-gray-600 pb-3 mb-4">Información de la Compra</h3>
                    <div class="space-y-3 text-sm">
                        <p class="text-gray-400"><strong>ID Compra:</strong> <span class="text-gray-200 font-medium ml-2">#{{ $compra->id }}</span></p>
                        <p class="text-gray-400"><strong>Fecha:</strong> <span class="text-gray-200 font-medium ml-2">{{ $compra->fecha_compra->format('d/m/Y H:i') }}</span></p>
                        <p class="text-gray-400"><strong>Total:</strong> <span class="text-red-500 font-bold ml-2">{{ number_format($compra->total_compra, 2, ',', '.') }} €</span></p>
                        <p class="text-gray-400"><strong>Estado:</strong> <span class="text-gray-200 font-medium ml-2">{{ ucfirst($compra->estado) }}</span></p>
                        <p class="text-gray-400"><strong>Método de Pago:</strong> <span class="text-gray-200 font-medium ml-2">{{ ucfirst(str_replace('_', ' ',$compra->metodo_pago)) }}</span></p>
                    </div>
                </div>

                {{-- Información de Facturación --}}
                <div class="bg-gray-900/50 p-6 rounded-lg border border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-200 border-b border-gray-600 pb-3 mb-4">Información de Facturación</h3>
                    @if ($compra->factura)
                        <div class="space-y-3 text-sm">
                            <p class="text-gray-400"><strong>Número de Factura:</strong> <span class="text-gray-200 font-medium ml-2">{{ $compra->factura->numero_factura }}</span></p>
                            <p class="text-gray-400"><strong>Fecha Emisión:</strong> <span class="text-gray-200 font-medium ml-2">{{ $compra->factura->fecha_emision->format('d/m/Y') }}</span></p>
                            <p class="text-gray-400"><strong>Estado Pago:</strong> <span class="text-gray-200 font-medium ml-2">{{ ucfirst($compra->factura->estado_pago) }}</span></p>
                            
                            @if (!empty($datosCheckout))
                                <div class="pt-2">
                                    <h4 class="text-md font-semibold text-gray-300 mb-2">Datos Adicionales:</h4>
                                    @if(isset($datosCheckout['nombre_facturacion']))
                                        <p class="text-gray-400"><strong>Nombre:</strong> <span class="text-gray-200 font-medium ml-2">{{ $datosCheckout['nombre_facturacion'] }}</span></p>
                                    @endif
                                    @if(isset($datosCheckout['email_facturacion']))
                                         <p class="text-gray-400"><strong>Email:</strong> <span class="text-gray-200 font-medium ml-2">{{ $datosCheckout['email_facturacion'] }}</span></p>
                                    @endif
                                    @if(isset($datosCheckout['info_general']))
                                         <p class="text-gray-400"><strong>Notas:</strong> <span class="text-gray-200 font-medium ml-2">{{ $datosCheckout['info_general'] }}</span></p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('factura.pdf.generar', $compra->id) }}" class="inline-flex items-center mt-6 px-4 py-2 bg-blue-600 text-white font-bold text-xs rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500 transition-all" target="_blank">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                            Descargar Factura PDF
                        </a>     
                    @else
                        <p class="text-gray-500 italic">Factura aún no generada.</p>
                    @endif
                </div>
            </div>

            <h3 class="text-xl font-semibold text-gray-200 mb-4">Artículos Comprados</h3>
            <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-md border border-gray-700">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Producto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cantidad</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Precio Unitario</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($compra->itemsAlmacen as $item)
                        <tr class="hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($item->imagen)
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('images/' . $item->imagen) }}" alt="{{ $item->nombre }}">
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-200">{{ $item->nombre }}</div>
                                        @if($item->sku)<div class="text-xs text-gray-500">SKU: {{ $item->sku }}</div>@endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $item->pivot->cantidad }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ number_format($item->pivot->precio_unitario_compra, 2, ',', '.') }} €</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-200">{{ number_format($item->pivot->subtotal, 2, ',', '.') }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('compras.index') }}" class="inline-flex items-center px-6 py-3 bg-transparent text-sm text-gray-400 font-semibold border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-gray-500 transition-all">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                    Volver a Mis Compras
                </a>
            </div>

        </div>
    </div>
</x-app-layout>