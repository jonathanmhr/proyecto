<x-app-layout>

    {{-- Estilos personalizados para que la paginación se vea bien en tema oscuro --}}
    @push('styles')
    <style>
        /* === INICIO: CORRECCIÓN PARA LA PAGINACIÓN EN MODO OSCURO === */
        .pagination {
            /* Contenedor principal de los enlaces */
        }
        .pagination a,
        .pagination span {
            /* Estilo base para todos los elementos de paginación */
            background-color: #1f2937; /* bg-gray-800 */
            color: #d1d5db; /* text-gray-300 */
            border-color: #374151; /* border-gray-700 */
        }
        .pagination a:hover {
            /* Estilo al pasar el ratón por un enlace */
            background-color: #374151; /* bg-gray-700 */
        }
        .pagination .active span {
            /* Estilo para la página activa */
            background-color: #dc2626; /* bg-red-600 */
            border-color: #b91c1c; /* border-red-700 */
            color: #ffffff; /* text-white */
        }
        .pagination .disabled span {
            /* Estilo para los botones deshabilitados (primera/última página) */
            color: #4b5563; /* text-gray-600 */
            background-color: #1f2937; /* bg-gray-800 */
        }
        /* === FIN: CORRECCIÓN PARA LA PAGINACIÓN === */
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Gestión de Compras') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-700">
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

            {{-- Formulario de Búsqueda Rediseñado --}}
            <div class="mb-8">
                <form method="GET" action="{{ route('admin.compras.index') }}">
                    <div class="flex flex-col sm:flex-row items-end gap-4">
                        {{-- Input de búsqueda --}}
                        <div class="flex-grow w-full sm:w-auto">
                            <label for="search" class="block text-sm font-semibold text-gray-400 mb-2">Buscar Compra</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    id="search"
                                    placeholder="Buscar por ID Compra o Nº Factura..."
                                    value="{{ $searchTerm ?? '' }}"
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-500"
                                >
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="flex items-center gap-3 w-full sm:w-auto flex-shrink-0">
                            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 ease-in-out">
                                Buscar
                            </button>
                            @if(isset($searchTerm) && $searchTerm)
                                <a href="{{ route('admin.compras.index') }}" class="w-full sm:w-auto text-center px-4 py-2.5 bg-transparent text-sm text-gray-400 font-semibold border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-gray-500 transition-all">Limpiar</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            @if($compras->isEmpty())
                <div class="text-center py-16">
                    <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-xl font-semibold text-gray-200">
                        @if(isset($searchTerm) && $searchTerm)
                            Sin resultados
                        @else
                            No hay compras registradas
                        @endif
                    </h3>
                    <p class="mt-1 text-base text-gray-400">
                        @if(isset($searchTerm) && $searchTerm)
                            No se encontraron compras que coincidan con "<strong>{{ $searchTerm }}</strong>".
                        @else
                            Parece que aún no se ha registrado ninguna compra.
                        @endif
    
                    </p>
                </div>
            @else
                <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-md border border-gray-700">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Serial</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cliente</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Factura Nº</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($compras as $compra)
                                <tr class="hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200">{{ $compra->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        {{ $compra->user->name ?? 'Usuario no encontrado' }} <br>
                                        <small class="text-gray-400">{{ $compra->user->email ?? '' }}</small>
                                    </td>
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
                                            <a href="{{ route('admin.compras.show', $compra->id) }}" class="text-red-500 hover:text-red-400 transition-colors duration-150 font-semibold">Ver Detalles</a>
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