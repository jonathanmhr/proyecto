<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Formulario de Filtro por Fechas --}}
                <form method="GET" action="{{ route('compras.index') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="fecha_desde" class="block text-sm font-medium text-gray-100">Desde Fecha:</label>
                            <input type="date" name="fecha_desde" id="fecha_desde"
                                   value="{{ $fecha_desde ?? '' }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="fecha_hasta" class="block text-sm font-medium text-gray-100">Hasta Fecha:</label>
                            <input type="date" name="fecha_hasta" id="fecha_hasta"
                                   value="{{ $fecha_hasta ?? '' }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                    class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Filtrar
                            </button>
                            @if(request()->has('fecha_desde') || request()->has('fecha_hasta'))
                                <a href="{{ route('compras.index') }}"
                                   class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </div>
                </form>


                @if($compras->isEmpty())
                    @if(request()->has('fecha_desde') || request()->has('fecha_hasta'))
                        <p>No se encontraron compras para el rango de fechas seleccionado.</p>
                    @else
                        <p>No has realizado ninguna compra aún.</p>
                    @endif
                    <a href="{{ route('tienda.index') }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-900">Ir a la tienda</a>
                @else
                    <div class="overflow-x-auto rounded">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factura</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($compras as $compra)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $compra->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $compra->fecha_compra->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($compra->total_compra, 2, ',', '.') }} €</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $compra->estado === 'pagada' ? 'bg-green-100 text-green-800' : ($compra->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst(str_replace('_', ' ', $compra->estado)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($compra->factura && $compra->factura->numero_factura)
                                                {{ $compra->factura->numero_factura }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('compras.show', $compra->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver Detalles</a>
                                            @if($compra->factura && $compra->factura->ruta_pdf)
                                                <a href="{{ route('factura.pdf.generar', $compra->id) }}" class="text-blue-600 hover:text-blue-900">Descargar PDF</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{-- La paginación ya incluye los filtros de fecha por el appends en el controller --}}
                        {{ $compras->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>