<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Almacén') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Gestión de Productos de Almacén</h1>

                <!-- Barra de búsqueda y acciones -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                    <!-- Formulario de búsqueda -->
                    <form action="{{ route('admin.almacen.index') }}" method="GET" class="w-full sm:w-1/2 lg:w-1/3">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Buscar por nombre o SKU..."
                                   class="w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                   value="{{ $searchTerm ?? '' }}">
                            <button type="submit" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-blue-600" title="Buscar">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Botón de añadir producto -->
                    <a href="{{ route('admin.almacen.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Añadir Nuevo Producto
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
                <!-- Mensaje para limpiar búsqueda -->
                @if ($searchTerm)
                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        Mostrando resultados para: <strong class="font-semibold">"{{ $searchTerm }}"</strong>.
                        <a href="{{ route('admin.almacen.index') }}" class="ml-2 text-blue-500 hover:underline">Limpiar búsqueda</a>
                    </div>
                @endif

                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Imagen</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">SKU</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cantidad</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Precio</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($productos as $producto)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($producto->imagen)
                                            {{-- Corregido: asset() necesita la ruta completa desde 'public' --}}
                                            <img src="{{ asset('images/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded text-xs text-gray-500">Sin imagen</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $producto->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $producto->sku }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $producto->tipo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">{{ $producto->cantidad_disponible }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ number_format($producto->precio_unitario, 2) }} €</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.almacen.edit', $producto) }}" title="Editar producto" 
                                               class="p-2 rounded-full transform hover:scale-110 transition-all duration-200 ease-in-out 
                                                      text-indigo-600 hover:bg-indigo-100 dark:text-indigo-400 
                                                      dark:hover:bg-gray-700 dark:hover:text-indigo-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.almacen.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Eliminar producto" 
                                                        class="p-2 rounded-full transform hover:scale-110 transition-all duration-200 ease-in-out 
                                                               text-red-600 hover:bg-red-100 dark:text-red-400 
                                                               dark:hover:bg-gray-700 dark:hover:text-red-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        @if ($searchTerm)
                                            No se encontraron productos que coincidan con tu búsqueda.
                                        @else
                                            No hay productos en el almacén.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{-- Los links de paginación ya funcionarán con el filtro --}}
                    {{ $productos->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>