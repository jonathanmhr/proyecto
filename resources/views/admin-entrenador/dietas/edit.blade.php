<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Editar Dieta: {{ $dieta->nombre }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con el fondo gris oscuro global de tu diseño --}}
    <div class="container mx-auto px-4 py-6 space-y-10 bg-gray-900 text-gray-200 min-h-screen rounded-xl shadow-lg mt-4">

        <h1 class="text-3xl font-bold mb-6 text-white">Editar Dieta Nutricional</h1>

        {{-- Contenedor del formulario, con el mismo estilo de tarjeta (bg-gray-800) --}}
        <div class="bg-gray-800 shadow rounded-xl p-8"> {{-- Aumentado el padding para un poco más de aire --}}
            <form action="{{ route('admin-entrenador.dietas.update', $dieta) }}" method="POST"
                enctype="multipart/form-data" class="space-y-8"> {{-- Aumentado el espacio entre secciones --}}
                @csrf
                @method('PUT')

                {{-- Sección de Detalles Básicos --}}
                <div class="border-b border-gray-700 pb-6"> {{-- Separador visual --}}
                    <h2 class="text-xl font-semibold text-white mb-4">Información General</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Usamos 2 columnas para más equilibrio --}}
                        <div class="md:col-span-1">
                            <label for="nombre" class="block font-medium text-sm text-gray-300 mb-2">Nombre de la Dieta</label>
                            <input type="text" name="nombre" id="nombre"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-200 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('nombre', $dieta->nombre) }}" placeholder="Ej: Dieta Mediterránea" required>
                            @error('nombre')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="calorias_diarias" class="block font-medium text-sm text-gray-300 mb-2">Calorías Diarias (kcal)</label>
                            <input type="number" name="calorias_diarias" id="calorias_diarias"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-200 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('calorias_diarias', $dieta->calorias_diarias) }}" placeholder="Ej: 2000" required>
                            @error('calorias_diarias')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="descripcion" class="block font-medium text-sm text-gray-300 mb-2">Descripción de la Dieta</label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                            class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-200 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                            placeholder="Describe brevemente esta dieta...">{{ old('descripcion', $dieta->descripcion) }}</textarea>
                        @error('descripcion')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Sección de Macros --}}
                <div class="border-b border-gray-700 pb-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Distribución de Macronutrientes</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="proteinas_g" class="block font-medium text-sm text-gray-300 mb-2">Proteínas (g)</label>
                            <input type="number" step="0.1" name="proteinas_g" id="proteinas_g"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-200 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('proteinas_g', $dieta->proteinas_g) }}" placeholder="Ej: 150.5" required>
                            @error('proteinas_g')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="carbohidratos_g" class="block font-medium text-sm text-gray-300 mb-2">Carbohidratos (g)</label>
                            <input type="number" step="0.1" name="carbohidratos_g" id="carbohidratos_g"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-200 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('carbohidratos_g', $dieta->carbohidratos_g) }}" placeholder="Ej: 250.0" required>
                            @error('carbohidratos_g')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="grasas_g" class="block font-medium text-sm text-gray-300 mb-2">Grasas (g)</label>
                            <input type="number" step="0.1" name="grasas_g" id="grasas_g"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-200 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('grasas_g', $dieta->grasas_g) }}" placeholder="Ej: 70.0" required>
                            @error('grasas_g')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección de Asignación de Usuarios (mejorado estéticamente) --}}
                <div class="border-b border-gray-700 pb-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Usuarios Asignados</h2>
                    <div>
                        <label for="usuarios" class="block font-medium text-sm text-gray-300 mb-2">Selecciona uno o más usuarios:</label>
                        <select name="users[]" id="usuarios" multiple
                            class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-200
                                focus:border-red-500 focus:ring-red-500
                                h-48 overflow-y-auto custom-select-multiple" {{-- Clase personalizada para altura y scroll --}}
                            >
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    class="py-2 px-3 hover:bg-gray-600 text-gray-200" {{-- Estilos para las opciones --}}
                                    {{ in_array($usuario->id, old('users', $dieta->users->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $usuario->name }} ({{ $usuario->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('usuarios')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-gray-400 mt-2">Mantén 'Ctrl' (Windows/Linux) o 'Cmd' (Mac) para seleccionar múltiples usuarios.</p>
                    </div>
                </div>


                {{-- Sección de Subida de Imagen --}}
                <div>
                    <h2 class="text-xl font-semibold text-white mb-4">Imagen de la Dieta</h2>
                    <label for="imagen" class="block font-medium text-sm text-gray-300 mb-2">Cambiar Imagen (Opcional)</label>
                    <input type="file" name="imagen" id="imagen"
                        class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-red-500 hover:file:bg-gray-600 hover:file:text-red-500 file:transition file:ease-in-out file:duration-150">
                    @error('imagen')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror

                    @if ($dieta->image_url)
                        <div class="mt-4 p-4 bg-gray-700 rounded-md shadow-sm flex items-center space-x-4">
                            <span class="block text-sm font-medium text-gray-300">Imagen actual:</span>
                            <img src="{{ Storage::url($dieta->image_url) }}"
                                alt="Imagen actual de {{ $dieta->nombre }}"
                                class="rounded-md h-24 w-auto object-cover border border-gray-600">
                        </div>
                    @else
                        <div class="mt-4 p-4 bg-gray-700 rounded-md shadow-sm text-gray-400 text-sm">
                            No hay imagen actualmente para esta dieta.
                        </div>
                    @endif
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('admin-entrenador.dietas.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-gray-700 border border-gray-600 rounded-md font-semibold text-sm text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-600 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-red-500 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar Dieta
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>