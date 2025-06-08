<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Crear Entrenamiento') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal de la página con fondo oscuro y padding --}}
    <div class="py-8 md:py-12 bg-gray-900 min-h-screen">
        <div class="max-w-xl md:max-w-4xl lg:max-w-6xl mx-auto sm:px-4 lg:px-6">
            {{-- Contenedor del formulario con estilo de tarjeta oscura y sombra pronunciada --}}
            <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 p-6 md:p-8" x-data="{ fases: [] }">
                <form method="POST" action="{{ route('admin-entrenador.entrenamientos.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Sección de Información General del Entrenamiento --}}
                    <h2 class="text-3xl font-extrabold text-white mb-8 border-b border-red-600 pb-4">
                        Detalles del Entrenamiento
                    </h2>

                    <div class="mb-4">
                        <x-label value="Título" class="text-gray-200" />
                        <x-input name="titulo" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3" required />
                    </div>

                    <div class="mb-4">
                        <x-label value="Descripción" class="text-gray-200" />
                        <textarea name="descripcion" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3"></textarea>
                    </div>

                    <div class="mb-4">
                        <x-label value="Zona Muscular (imagen)" class="text-gray-200" />
                        <input type="file" name="zona_muscular_imagen" accept="image/*"
                               class="w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg p-2
                                      file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                      file:bg-red-700 file:text-white hover:file:bg-red-600 transition-colors duration-200 cursor-pointer" />
                    </div>

                    <div class="mb-4">
                        <x-label value="Nivel" class="text-gray-200" />
                        <select name="nivel" class="w-full bg-gray-700 border-gray-600 text-white focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3">
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-label value="Equipamiento (imagen)" class="text-gray-200" />
                        <input type="file" name="equipamiento_imagen" accept="image/*"
                               class="w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg p-2
                                      file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                      file:bg-red-700 file:text-white hover:file:bg-red-600 transition-colors duration-200 cursor-pointer" />
                    </div>

                    <div class="mb-4">
                        <x-label value="Kcal totales estimadas del entrenamiento" class="text-gray-200" />
                        <x-input name="kcal_totales" type="number" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3" />
                    </div>

                    {{-- Separador visual --}}
                    <hr class="my-8 border-gray-700">
                    <h2 class="text-3xl font-extrabold text-white mb-6 border-b border-red-600 pb-4">
                        Fases del Entrenamiento (Días)
                    </h2>

                    <template x-for="(fase, i) in fases" :key="i">
                        <div class="p-6 mb-4 bg-gray-700 border border-gray-600 rounded-xl shadow-lg">
                            <h3 class="text-xl font-semibold mb-2 text-white">Día <span x-text="i + 1"></span></h3>

                            <x-label value="Nombre del ejercicio (fase)" class="text-gray-200" />
                            <input type="text" :name="'fases['+i+'][nombre]'" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required>

                            <x-label value="Duración (min)" class="text-gray-200" />
                            <input type="number" :name="'fases['+i+'][duracion_min]'" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required>

                            <x-label value="Kcal estimadas para esta fase" class="text-gray-200" />
                            <input type="number" :name="'fases['+i+'][kcal_estimadas]'" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required>

                            <x-label value="Imagen del ejercicio (fase)" class="text-gray-200" />
                            <input type="file" :name="'fases['+i+'][imagen]'" accept="image/*"
                                   class="w-full bg-gray-600 border-gray-500 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 p-2
                                          file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                          file:bg-gray-500 file:text-white hover:file:bg-gray-400 transition-colors duration-200 cursor-pointer" />

                            <div x-data="{ actividades: [] }">
                                <h4 class="text-xl font-bold text-white mb-4 mt-8 border-b border-gray-600 pb-2">Actividades de este Día</h4>
                                <template x-for="(act, j) in actividades" :key="j">
                                    <div class="mb-2 p-4 bg-gray-600 border border-gray-500 rounded-lg shadow-sm">
                                        <h5 class="text-lg font-semibold mb-3 text-white">Actividad <span x-text="j + 1"></span></h5>

                                        <x-label value="Nombre Actividad" class="text-gray-200" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][nombre]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3">

                                        <x-label value="Tipo (ej: cardio, fuerza...)" class="text-gray-200" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][tipo]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3">

                                        <x-label value="Series" class="text-gray-200" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][series]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3">

                                        <x-label value="Repeticiones (opcional)" class="text-gray-200" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][repeticiones]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3">

                                        <x-label value="URL Imagen (opcional)" class="text-gray-200" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][imagen]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3">
                                    </div>
                                </template>

                                <button type="button" @click="actividades.push({})"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow-md transition duration-300 ease-in-out">
                                    + Añadir actividad
                                </button>
                            </div>
                        </div>
                    </template>

                    <div class="mb-6 mt-8">
                        <button type="button" @click="fases.push({})"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
                            + Añadir Día (Fase)
                        </button>
                    </div>

                    <x-button class="bg-red-700 hover:bg-red-800 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">Guardar Entrenamiento</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>