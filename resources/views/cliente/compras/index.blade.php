<x-app-layout>

    @push('styles')
    <style>
        .pagination a,
        .pagination span {
            background-color: #1f2937; /* bg-gray-800 */
            color: #d1d5db; /* text-gray-300 */
            border-color: #374151; /* border-gray-700 */
        }
        .pagination a:hover {
            background-color: #374151; /* bg-gray-700 */
        }
        .pagination .active span {
            background-color: #dc2626; /* bg-red-600 */
            border-color: #b91c1c; /* border-red-700 */
            color: #ffffff; /* text-white */
        }
        .pagination .disabled span {
            color: #4b5563; /* text-gray-600 */
            background-color: #1f2937; /* bg-gray-800 */
        }
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Mis Compras') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-lg border border-gray-700">
            @if(session('success'))
                <div class="bg-green-700/80 border border-green-600 text-white px-4 py-3 rounded-lg relative mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-700/80 border border-red-600 text-white px-4 py-3 rounded-lg relative mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Formulario de Filtro por Fechas Rediseñado --}}
            <form method="GET" action="{{ route('compras.index') }}" class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-x-6 gap-y-6 items-end">
                    <div class="lg:col-span-2">
                        <label for="fecha_desde" class="block text-sm font-semibold text-gray-400 mb-2">Desde Fecha:</label>
                        <input type="date" name="fecha_desde" id="fecha_desde"
                               value="{{ $fecha_desde ?? '' }}"
                               class="[color-scheme:dark] w-full px-4 py-2.5 bg-gray-700 text-gray-200 border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                    </div>
                    <div class="lg:col-span-2">
                        <label for="fecha_hasta" class="block text-sm font-semibold text-gray-400 mb-2">Hasta Fecha:</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta"
                               value="{{ $fecha_hasta ?? '' }}"
                               class="[color-scheme:dark] w-full px-4 py-2.5 bg-gray-700 text-gray-200 border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                    </div>
                    <div class="lg:col-span-1 flex flex-col sm:flex-row lg:flex-col gap-3">
                        <button type="submit" class="w-full px-5 py-2.5 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 ease-in-out">
                            Filtrar
                        </button>
                        @if(request()->has('fecha_desde') || request()->has('fecha_hasta'))
                            <a href="{{ route('compras.index') }}" class="w-full text-center px-4 py-2.5 bg-transparent text-sm text-gray-400 font-semibold border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-gray-500 transition-all">Limpiar</a>
                        @endif
                    </div>
                </div>
            </form>

            @if($compras->isEmpty())
                <div class="text-center py-16">
                    <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.344 1.087-.835l1.858-6.443a.75.75 0 00-.7-1.022H5.21z" />
                    </svg>
                    <h3 class="mt-2 text-xl font-semibold text-gray-200">
                        @if(request()->has('fecha_desde') || request()->has('fecha_hasta'))
                            No se encontraron compras
                        @else
                            Aún no tienes compras
                        @endif
                    </h3>
                    <p class="mt-1 text-base text-gray-400">
                        @if(request()->has('fecha_desde') || request()->has('fecha_hasta'))
                            No hay compras registradas en el rango de fechas seleccionado.
                        @else
                            Parece que todavía no has explorado nuestros productos. ¡Anímate!
                        @endif
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('tienda.index') }}" class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 ease-in-out">
                            Ir a la Tienda
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-md border border-gray-700">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Serial</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Factura</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($compras as $compra)
                                <tr class="hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200">#{{ $compra->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $compra->fecha_compra->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-200">{{ number_format($compra->total_compra, 2, ',', '.') }} €</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @switch($compra->estado)
                                                @case('pagada')
                                                    bg-green-500/20 text-green-400 border border-green-500/30
                                                    @break
                                                @case('pendiente')
                                                    bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                                    @break
                                                @default
                                                    bg-red-500/20 text-red-400 border border-red-500/30
                                            @endswitch
                                        ">
                                            {{ ucfirst(str_replace('_', ' ', $compra->estado)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                        @if($compra->factura && $compra->factura->numero_factura)
                                            {{ $compra->factura->numero_factura }}
                                        @else
                                            <span class="text-gray-500">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('compras.show', $compra->id) }}" class="text-red-500 hover:text-red-400 transition-colors duration-150 font-semibold">Ver Detalles</a>
                                            @if($compra->factura && $compra->factura->ruta_pdf)
                                                <a href="{{ route('factura.pdf.generar', $compra->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-150 font-semibold">Descargar PDF</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $compras->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>