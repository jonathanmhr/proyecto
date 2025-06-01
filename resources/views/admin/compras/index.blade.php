<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
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

                {{-- Formulario de Búsqueda --}}
                <div class="mb-6">
                    <form method="GET" action="{{ route('admin.compras.index') }}">
                        <div class="flex items-center">
                            <input
                                type="text"
                                name="search"
                                placeholder="Buscar por ID Compra o Nº Factura..."
                                value="{{ $searchTerm ?? '' }}"
                                class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full md:w-1/2 lg:w-1/3"
                            >
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-md"
                            >
                                Buscar
                            </button>
                            @if(isset($searchTerm) && $searchTerm)
                                <a href="{{ route('admin.compras.index') }}" class="ml-3 text-sm text-gray-600 hover:text-gray-800 underline">Limpiar Filtro</a>
                            @endif
                        </div>
                    </form>
                </div>

                @if($compras->isEmpty())
                    @if(isset($searchTerm) && $searchTerm)
                        <p class="text-gray-600">No se encontraron compras que coincidan con "<strong>{{ $searchTerm }}</strong>".</p>
                    @else
                        <p class="text-gray-600">No hay compras registradas.</p>
                    @endif
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factura Nº</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($compras as $compra)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $compra->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $compra->user->name ?? 'Usuario no encontrado' }} <br>
                                            <small class="text-gray-500">{{ $compra->user->email ?? '' }}</small>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $compra->fecha_compra->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($compra->total_compra, 2, ',', '.') }} €</td> {{-- Ajustado a formato euros --}}
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
                                            <a href="{{ route('admin.compras.show', $compra->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver Detalles</a>
                                            @if($compra->factura && $compra->factura->ruta_pdf)
                                                {{-- Asumiendo que tienes una ruta para descargar la factura --}}
                                                <a href="{{ route('compras.factura.download', $compra->id) }}" class="text-blue-600 hover:text-blue-900">Descargar PDF</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $compras->links() }} {{-- La paginación ya incluye el 'search' por el appends en el controller --}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>