<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Crear Nueva Dieta Nutricional
        </h2>
    </x-slot>

    {{-- Contenedor principal con el fondo gris oscuro global de tu diseño --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">

        <h1 class="text-4xl font-extrabold mb-8 text-white text-center md:text-left">Crear Nueva Dieta</h1>

        {{-- Contenedor del formulario, con el mismo estilo de tarjeta (bg-gray-800) --}}
        <div class="bg-gray-800 shadow-xl rounded-xl p-8">
            <form action="{{ route('admin-entrenador.dietas.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                {{-- Sección de Detalles Básicos --}}
                <div class="border-b border-gray-700 pb-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Información General</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block font-medium text-sm text-gray-300 mb-2">Nombre de la Dieta</label>
                            <input type="text" name="nombre" id="nombre"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-100 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('nombre') }}" placeholder="Ej: Dieta Keto para deportistas" required>
                            @error('nombre')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="calorias_diarias" class="block font-medium text-sm text-gray-300 mb-2">Calorías Diarias (kcal)</label>
                            <input type="number" name="calorias_diarias" id="calorias_diarias"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-100 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('calorias_diarias') }}" placeholder="Ej: 2200" required>
                            @error('calorias_diarias')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="descripcion" class="block font-medium text-sm text-gray-300 mb-2">Descripción de la Dieta</label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                            class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-100 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                            placeholder="Proporciona una descripción detallada de esta dieta, sus principios y beneficios.">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Sección de Macros --}}
                <div class="border-b border-gray-700 pb-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Distribución de Macronutrientes (en gramos)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="proteinas_g" class="block font-medium text-sm text-gray-300 mb-2">Proteínas (g)</label>
                            <input type="number" step="0.1" name="proteinas_g" id="proteinas_g"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-100 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('proteinas_g') }}" placeholder="Ej: 180.5" required>
                            @error('proteinas_g')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="carbohidratos_g" class="block font-medium text-sm text-gray-300 mb-2">Carbohidratos (g)</label>
                            <input type="number" step="0.1" name="carbohidratos_g" id="carbohidratos_g"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-100 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('carbohidratos_g') }}" placeholder="Ej: 200.0" required>
                            @error('carbohidratos_g')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="grasas_g" class="block font-medium text-sm text-gray-300 mb-2">Grasas (g)</label>
                            <input type="number" step="0.1" name="grasas_g" id="grasas_g"
                                class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-100 focus:border-red-500 focus:ring-red-500 placeholder-gray-500"
                                value="{{ old('grasas_g') }}" placeholder="Ej: 60.0" required>
                            @error('grasas_g')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección de Asignación de Usuarios --}}
                <div class="border-b border-gray-700 pb-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Asignar a Usuarios (Opcional)</h2>
                    <div>
                        <label for="usuarios" class="block font-medium text-sm text-gray-300 mb-2">Selecciona usuarios para esta dieta:</label>
                        <select name="usuarios[]" id="usuarios" multiple
                            class="block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-gray-100
                                focus:border-red-500 focus:ring-red-500
                                h-48 overflow-y-auto custom-select-multiple"
                            >
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    class="py-2 px-3 hover:bg-gray-600 text-gray-100"
                                    {{ in_array($usuario->id, old('usuarios', [])) ? 'selected' : '' }}>
                                    {{ $usuario->name }} ({{ $usuario->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-2">Mantén 'Ctrl' (Windows/Linux) o 'Cmd' (Mac) para seleccionar múltiples usuarios.</p>
                        @error('usuarios')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Sección de Subida de Imagen --}}
                <div>
                    <h2 class="text-xl font-semibold text-white mb-4">Imagen de la Dieta (Opcional)</h2>
                    <label for="imagen" class="block font-medium text-sm text-gray-300 mb-2">Sube una imagen para la dieta:</label>
                    <input type="file" name="imagen" id="imagen"
                        class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-red-500 hover:file:bg-gray-600 hover:file:text-red-500 file:transition file:ease-in-out file:duration-150"
                        accept="image/jpeg, image/png, image/jpg"> {{-- AÑADIDO: Atributo accept --}}
                    <p class="text-xs text-gray-400 mt-1">Formatos permitidos: JPG, JPEG, PNG.</p> {{-- AÑADIDO: Indicación al usuario --}}
                    @error('imagen')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end space-x-4 pt-6">
                    {{-- Botón Cancelar con estilo de botón secundario --}}
                    <a href="{{ route('admin-entrenador.dietas.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-gray-700 border border-gray-600 rounded-xl font-semibold text-sm text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-600 disabled:opacity-25 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75">
                        <i data-feather="x" class="w-5 h-5 mr-2"></i>
                        Cancelar
                    </a>
                    {{-- Botón Crear Dieta con tu color de acento --}}
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-red-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-800 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-500 disabled:opacity-25 transition duration-300 transform hover:scale-105 shadow-lg">
                        <i data-feather="check" class="w-5 h-5 mr-2"></i>
                        Crear Dieta
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>