<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pedidos') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-xl rounded-lg p-6 md:p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detalle de Compra #{{ $compra->id }}</h1>
                <p class="text-sm text-gray-500">Realizada el: {{ $compra->fecha_compra->format('d/m/Y \a \l\a\s H:i') }}</p>
            </div>
            <a href="{{ route('compras.index') }}" class="mt-4 md:mt-0 text-blue-600 hover:text-blue-800 font-semibold">
                ← Volver al listado
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Información del Cliente</h2>
                <div class="space-y-1 text-gray-600">
                    <p><strong>Nombre:</strong> {{ $compra->user->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $compra->user->email ?? 'N/A' }}</p>
                    {{-- Aquí podrías añadir más info del perfil del usuario si es relevante (dirección, etc.) --}}
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Resumen de la Compra</h2>
                <div class="space-y-1 text-gray-600">
                    <p><strong>Total Compra:</strong> <span class="font-bold text-lg">{{ number_format($compra->total_compra, 2, ',', '.') }} €</span></p>
                    <p><strong>Método de Pago:</strong> {{ ucfirst($compra->metodo_pago) ?? 'No especificado' }}</p>
                    <p><strong>Estado:</strong>
                        <span class="px-2 py-1 font-semibold leading-tight
                            @if($compra->estado == 'pagada') text-green-900 bg-green-200
                            @elseif($compra->estado == 'pendiente') text-yellow-900 bg-yellow-200
                            @elseif($compra->estado == 'cancelada') text-red-900 bg-red-200
                            @else text-gray-900 bg-gray-200
                            @endif
                            rounded-full">
                            {{ ucfirst($compra->estado) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-3">Productos Comprados</h2>
            @if($compra->itemsAlmacen->isEmpty())
                <p class="text-gray-600">No hay productos asociados a esta compra.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Precio Unit. (Compra)
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Subtotal
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compra->itemsAlmacen as $item)
                            <tr>
                                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                    {{ $item->nombre }}
                                    @if($item->sku) <br><small class="text-gray-500">SKU: {{ $item->sku }}</small> @endif
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                    {{ $item->pivot->cantidad }}
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                    {{ number_format($item->pivot->precio_unitario_compra, 2, ',', '.') }} €
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                    {{ number_format($item->pivot->subtotal, 2, ',', '.') }} €
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        @if($compra->factura)
        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-3">Información de la Factura</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1 text-gray-600">
                    <p><strong>Número de Factura:</strong> {{ $compra->factura->numero_factura }}</p>
                    <p><strong>Fecha Emisión:</strong> {{ $compra->factura->fecha_emision->format('d/m/Y H:i') }}</p>
                    @if($compra->factura->fecha_vencimiento)
                    <p><strong>Fecha Vencimiento:</strong> {{ $compra->factura->fecha_vencimiento->format('d/m/Y') }}</p>
                    @endif
                </div>
                <div class="space-y-1 text-gray-600">
                    <p><strong>Total Factura:</strong> <span class="font-bold">{{ number_format($compra->factura->total_factura, 2, ',', '.') }} €</span></p>
                    <p><strong>Estado del Pago:</strong>
                        <span class="px-2 py-1 font-semibold leading-tight
                            @if($compra->factura->estado_pago == 'pagada') text-green-900 bg-green-200
                            @elseif($compra->factura->estado_pago == 'pendiente') text-yellow-900 bg-yellow-200
                            @elseif($compra->factura->estado_pago == 'vencida') text-red-900 bg-red-200
                            @else text-gray-900 bg-gray-200
                            @endif
                            rounded-full">
                            {{ ucfirst($compra->factura->estado_pago) }}
                        </span>
                    </p>
                    @if($compra->factura->ruta_pdf)
                        <p><a href="{{ asset('storage/' . $compra->factura->ruta_pdf) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">Descargar PDF</a></p>
                    @endif
                </div>
            </div>
            @if($compra->factura->notas)
                <div class="mt-4">
                    <h3 class="text-md font-semibold text-gray-700">Notas Adicionales:</h3>
                    <p class="text-gray-600 whitespace-pre-line">{{ $compra->factura->notas }}</p>
                </div>
            @endif
        </div>
        @else
        <div class="border-t border-gray-200 pt-6">
            <p class="text-gray-600">No hay factura asociada a esta compra todavía.</p>
            {{-- Aquí podrías poner un botón para "Generar Factura" si es una acción manual --}}
        </div>
        @endif

    </div>
</div>
</x-app-layout>

