<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Compra #{{ $compra->id }} - Cliente: {{ $compra->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                         @if(session('factura_pdf_url') || $facturaPdfUrl)
                            <a href="{{ route('factura.pdf.generar', $compra->id) }}" target="_blank" class="font-bold underline ml-2">Ver Factura PDF</a>
                        @endif
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Información de la Compra</h3>
                        <p><strong>ID Compra:</strong> #{{ $compra->id }}</p>
                        <p><strong>Cliente:</strong> {{ $compra->user->name }} ({{ $compra->user->email }})</p>
                        <p><strong>Fecha:</strong> {{ $compra->fecha_compra->format('d/m/Y H:i') }}</p>
                        <p><strong>Total:</strong> ${{ number_format($compra->total_compra, 2) }}</p>
                        <p><strong>Estado:</strong> {{ ucfirst($compra->estado) }}</p>
                        <p><strong>Método de Pago:</strong> {{ ucfirst(str_replace('_', ' ',$compra->metodo_pago)) }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Información de Facturación</h3>
                        @if ($compra->factura)
                            <p><strong>Número de Factura:</strong> {{ $compra->factura->numero_factura }}</p>
                            <p><strong>Fecha Emisión Factura:</strong> {{ $compra->factura->fecha_emision->format('d/m/Y') }}</p>
                            <p><strong>Estado Pago Factura:</strong> {{ ucfirst($compra->factura->estado_pago) }}</p>
                            @if (!empty($datosCheckout))
                                <h4 class="text-md font-medium text-gray-800 mt-2">Datos de Checkout:</h4>
                                 @if(isset($datosCheckout['nombre_facturacion']))
                                    <p><strong>Nombre:</strong> {{ $datosCheckout['nombre_facturacion'] }}</p>
                                @endif
                                @if(isset($datosCheckout['email_facturacion']))
                                     <p><strong>Email:</strong> {{ $datosCheckout['email_facturacion'] }}</p>
                                @endif
                                @if(isset($datosCheckout['info_general']))
                                     <p><strong>Notas:</strong> {{ $datosCheckout['info_general'] }}</p>
                                @endif
                            @else
                                <p>No hay datos de checkout detallados disponibles para esta factura.</p>
                            @endif
                            
                            <a href="{{ route('factura.pdf.generar', $compra->id) }}" class="btn btn-primary" target="_blank">
                                Descargar Factura PDF
                            </a>
                        @else
                            <p>Factura aún no generada.</p>
                        @endif
                    </div>
                </div>

                <h3 class="text-lg font-medium text-gray-900 mb-3">Artículos Comprados</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($compra->itemsAlmacen as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                     <div class="flex items-center">
                                        @if($item->imagen)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('images/' . $item->imagen) }}" alt="{{ $item->nombre }}">
                                        </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->nombre }}</div>
                                            @if($item->sku)<div class="text-sm text-gray-500">SKU: {{ $item->sku }}</div>@endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->pivot->cantidad }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->pivot->precio_unitario_compra, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($item->pivot->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.compras.index') }}" class="text-indigo-600 hover:text-indigo-900">Volver al Listado de Compras</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>