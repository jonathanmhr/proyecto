<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 md:p-8">

                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Añadir Nuevo Producto al Almacén</h1>

                {{-- Muestra errores de validación si existen --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                        <strong class="font-bold">¡Vaya!</strong>
                        <span class="block sm:inline">Parece que hay algunos errores.</span>
                        <ul class="mt-3 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.almacen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Fila para Nombre y SKU --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nombre del Producto</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="sku" class="block font-medium text-sm text-gray-700 dark:text-gray-300">SKU</label>
                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="descripcion" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                    </div>

                    {{-- Fila para Tipo, Cantidad, Precio y Valoración --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label for="tipo" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipo</label>
                            <select id="tipo" name="tipo" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Seleccione uno</option>
                                @foreach($tiposDisponibles as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>{{ ucfirst(strtolower($tipo)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="cantidad_disponible" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Cantidad</label>
                            <input type="number" id="cantidad_disponible" name="cantidad_disponible" value="{{ old('cantidad_disponible') }}" required min="0"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="precio_unitario" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Precio (€)</label>
                            <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario') }}" required min="0"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="valoracion" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Valoración</label>
                            <select id="valoracion" name="valoracion"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Sin valorar</option>
                                @foreach($valoracionesDisponibles as $valor)
                                    <option value="{{ $valor }}" {{ old('valoracion') == $valor ? 'selected' : '' }}>
                                        {{ $valor }} {{ $valor == 1 ? 'estrella' : 'estrellas' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     {{-- Proveedor --}}
                     <div>
                        <label for="proveedor" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Proveedor (Opcional)</label>
                        <input type="text" id="proveedor" name="proveedor" value="{{ old('proveedor') }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>

                    {{-- Imagen --}}
                    <div>
                        <label for="imagen" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Imagen del Producto</label>
                        <input type="file" id="imagen" name="imagen"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.almacen.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancelar
                        </a>
                        <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Guardar Producto
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>