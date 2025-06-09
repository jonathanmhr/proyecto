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
                        <x-label value="Título" class="text-white" />
                        <x-input name="titulo" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3" required placeholder="Ej: Entrenamiento de Fuerza - Nivel Intermedio" />
                    </div>

                    <div class="mb-4">
                        <x-label value="Descripción" class="text-white" />
                        <textarea name="descripcion" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3" placeholder="Describe brevemente el objetivo y las características de este entrenamiento."></textarea>
                    </div>

                    <div class="mb-4">
                        <x-label value="Zona Muscular (imagen)" class="text-white" />
                        <input type="file" name="zona_muscular_imagen" accept="image/*"
                               class="w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg p-2
                                    file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                    file:bg-red-700 file:text-white hover:file:bg-red-600 transition-colors duration-200 cursor-pointer" />
                    </div>

                    <div class="mb-4">
                        <x-label value="Nivel" class="text-white" />
                        <select name="nivel" class="w-full bg-gray-700 border-gray-600 text-white focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3">
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-label value="Equipamiento (imagen)" class="text-white" />
                        <input type="file" name="equipamiento_imagen" accept="image/*"
                               class="w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg p-2
                                    file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                    file:bg-red-700 file:text-white hover:file:bg-red-600 transition-colors duration-200 cursor-pointer" />
                    </div>

                    <div class="mb-4">
                        <x-label value="Kcal totales estimadas del entrenamiento" class="text-white" />
                        <x-input name="kcal_totales" type="number" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3" placeholder="Ej: 500 kcal" />
                    </div>

                    {{-- Sección de Fases del Entrenamiento --}}
                    <h2 class="text-3xl font-extrabold text-white mb-6 border-b border-red-600 pb-4">
                        Fases del Entrenamiento (Días)
                    </h2>

                    <template x-for="(fase, i) in fases" :key="i">
                        <div class="p-6 mb-4 bg-gray-700 border border-gray-600 rounded-xl shadow-lg relative"> {{-- Added relative for absolute positioning of delete button --}}
                            <h3 class="text-xl font-semibold mb-2 text-white">Día <span x-text="i + 1"></span></h3>

                            {{-- Botón para eliminar esta fase --}}
                            <button type="button" @click="fases.splice(i, 1)"
                                class="absolute top-4 right-4 bg-red-600 hover:bg-red-700 text-white p-2 rounded-full shadow-md transition duration-300 ease-in-out"
                                title="Eliminar este día (fase)">
                                <i data-feather="trash-2" class="w-5 h-5"></i>
                            </button>

                            <x-label value="Nombre del ejercicio (fase)" class="text-white" />
                            <input type="text" :name="'fases['+i+'][nombre]'" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required placeholder="Ej: Calentamiento, Sesión de Pecho y Tríceps, Enfriamiento">

                            <x-label value="Duración (min)" class="text-white" />
                            <input type="number" :name="'fases['+i+'][duracion_min]'" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required placeholder="Ej: 30, 60, 90">

                            <x-label value="Kcal estimadas para esta fase" class="text-white" />
                            <input type="number" :name="'fases['+i+'][kcal_estimadas]'" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required placeholder="Ej: 150 kcal">

                            <x-label value="Imagen del ejercicio (fase)" class="text-white" />
                            <input type="file" :name="'fases['+i+'][imagen]'" accept="image/*"
                                   class="w-full bg-gray-600 border-gray-500 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 p-2
                                         file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                         file:bg-gray-500 file:text-white hover:file:bg-gray-400 transition-colors duration-200 cursor-pointer" />

                            <div x-data="{ actividades: [] }" :id="'actividades-container-' + i"> {{-- Added ID for easier debugging if needed --}}
                                <h4 class="text-xl font-bold text-white mb-4 mt-8 border-b border-gray-600 pb-2">Actividades de este Día</h4>
                                <template x-for="(act, j) in actividades" :key="j">
                                    <div class="mb-2 p-4 bg-gray-600 border border-gray-500 rounded-lg shadow-sm relative"> {{-- Added relative for delete button --}}
                                        <h5 class="text-lg font-semibold mb-3 text-white">Actividad <span x-text="j + 1"></span></h5>

                                        {{-- Botón para eliminar esta actividad --}}
                                        <button type="button" @click="actividades.splice(j, 1)"
                                            class="absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white p-1 rounded-full shadow-sm transition duration-300 ease-in-out"
                                            title="Eliminar esta actividad">
                                            <i data-feather="x" class="w-4 h-4"></i> {{-- Smaller icon for activity delete --}}
                                        </button>

                                        <x-label value="Nombre Actividad" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][nombre]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: Flexiones, Carrera en cinta">

                                        <x-label value="Tipo (ej: cardio, fuerza...)" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][tipo]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: Fuerza, Cardio, Resistencia">

                                        <x-label value="Series" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][series]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: 3 series">

                                        <x-label value="Repeticiones (opcional)" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][repeticiones]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: 10-12 repeticiones, 30 segundos">

                                        <x-label value="URL Imagen (opcional)" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][imagen]'" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: https://ejemplo.com/flexiones.jpg">
                                    </div>
                                </template>

                                <button type="button" @click="actividades.push({})"
                                        class="mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow-md transition duration-300 ease-in-out">
                                    + Añadir Actividad
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