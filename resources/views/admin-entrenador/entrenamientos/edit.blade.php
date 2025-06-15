<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Editar Entrenamiento') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal de la página con fondo oscuro y padding --}}
    <div class="py-8 md:py-12 bg-gray-900 min-h-screen">
        <div class="max-w-xl md:max-w-4xl lg:max-w-6xl mx-auto sm:px-4 lg:px-6">
            {{-- Botón Volver --}}
            <div class="mb-6">
                <a href="{{ route('entrenador.entrenamientos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver a Entrenamientos
                </a>
            </div>

            {{-- Contenedor del formulario con estilo de tarjeta oscura y sombra pronunciada --}}
            <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 p-6 md:p-8"
                 x-data="{
                     fases: @js($entrenamiento->fases->map(function ($fase) {
                         return [
                             'id' => $fase->id, // Para identificar la fase al guardar si ya existe
                             'nombre' => $fase->nombre,
                             'duracion_min' => $fase->duracion_min,
                             'kcal_estimadas' => $fase->kcal_estimadas,
                             'imagen' => $fase->imagen, // Para mostrar la imagen actual
                             'actividades' => $fase->actividades->map(function ($actividad) {
                                 return [
                                     'id' => $actividad->id, // Para identificar la actividad al guardar si ya existe
                                     'nombre' => $actividad->nombre,
                                     'tipo' => $actividad->tipo,
                                     'series' => $actividad->series,
                                     'repeticiones' => $actividad->repeticiones,
                                     'imagen' => $actividad->imagen, // Para mostrar la imagen actual
                                 ];
                             })->toArray(),
                             // Añadir una propiedad para las actividades eliminadas, si necesitas gestionar eliminaciones a nivel de DB
                             'deleted_actividades' => [],
                         ];
                     })->toArray()),
                     deleted_fases: [], // Para almacenar IDs de fases eliminadas para la DB
                 }">
                <form method="POST" action="{{ route('admin-entrenador.entrenamientos.update', $entrenamiento->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Mensajes de error de validación --}}
                    @if ($errors->any())
                        <div class="bg-red-700 border border-red-800 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Sección de Información General del Entrenamiento --}}
                    <h2 class="text-3xl font-extrabold text-white mb-8 border-b border-red-600 pb-4">
                        Editar Detalles del Entrenamiento
                    </h2>

                    <div class="mb-4">
                        <x-label value="Título" class="text-white" />
                        <x-input name="titulo" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3"
                                 value="{{ old('titulo', $entrenamiento->titulo) }}" required placeholder="Ej: Entrenamiento de Fuerza - Nivel Intermedio" />
                    </div>

                    <div class="mb-4">
                        <x-label value="Descripción" class="text-white" />
                        <textarea name="descripcion" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3"
                                  placeholder="Describe brevemente el objetivo y las características de este entrenamiento.">{{ old('descripcion', $entrenamiento->descripcion) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-label value="Zona Muscular (imagen actual)" class="text-white mb-2" />
                        @if ($entrenamiento->zona_muscular_imagen)
                            <img src="{{ Storage::url($entrenamiento->zona_muscular_imagen) }}" alt="Zona Muscular Actual" class="mb-3 rounded-lg max-w-xs h-auto shadow-md">
                        @endif
                        <input type="file" name="zona_muscular_imagen" accept="image/*"
                               class="w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg p-2
                                    file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                    file:bg-red-700 file:text-white hover:file:bg-red-600 transition-colors duration-200 cursor-pointer" />
                        <p class="text-xs text-gray-400 mt-1">Sube una nueva imagen para reemplazar la actual.</p>
                    </div>

                    <div class="mb-4">
                        <x-label value="Nivel" class="text-white" />
                        <select name="nivel" class="w-full bg-gray-700 border-gray-600 text-white focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3">
                            <option value="bajo" {{ old('nivel', $entrenamiento->nivel) == 'bajo' ? 'selected' : '' }}>Bajo</option>
                            <option value="medio" {{ old('nivel', $entrenamiento->nivel) == 'medio' ? 'selected' : '' }}>Medio</option>
                            <option value="alto" {{ old('nivel', $entrenamiento->nivel) == 'alto' ? 'selected' : '' }}>Alto</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-label value="Equipamiento (imagen actual)" class="text-white mb-2" />
                        @if ($entrenamiento->equipamiento_imagen)
                            <img src="{{ Storage::url($entrenamiento->equipamiento_imagen) }}" alt="Equipamiento Actual" class="mb-3 rounded-lg max-w-xs h-auto shadow-md">
                        @endif
                        <input type="file" name="equipamiento_imagen" accept="image/*"
                               class="w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg p-2
                                    file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                    file:bg-red-700 file:text-white hover:file:bg-red-600 transition-colors duration-200 cursor-pointer" />
                        <p class="text-xs text-gray-400 mt-1">Sube una nueva imagen para reemplazar la actual.</p>
                    </div>

                    <div class="mb-4">
                        <x-label value="Kcal totales estimadas del entrenamiento" class="text-white" />
                        <x-input name="kcal_totales" type="number" class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg py-2 px-3"
                                 value="{{ old('kcal_totales', $entrenamiento->kcal_totales) }}" placeholder="Ej: 500 kcal" />
                    </div>

                    {{-- Sección de Fases del Entrenamiento --}}
                    <h2 class="text-3xl font-extrabold text-white mb-6 border-b border-red-600 pb-4">
                        Fases del Entrenamiento (Días)
                    </h2>

                    <template x-for="(fase, i) in fases" :key="fase.id || i">
                        <div class="p-6 mb-4 bg-gray-700 border border-gray-600 rounded-xl shadow-lg relative">
                            <h3 class="text-xl font-semibold mb-2 text-white">Día <span x-text="i + 1"></span></h3>

                            {{-- Hidden input for existing fase ID --}}
                            <input type="hidden" :name="'fases['+i+'][id]'" x-model="fase.id">

                            {{-- Botón para eliminar esta fase --}}
                            <button type="button" @click="if(fase.id) deleted_fases.push(fase.id); fases.splice(i, 1);"
                                class="absolute top-4 right-4 bg-red-600 hover:bg-red-700 text-white p-2 rounded-full shadow-md transition duration-300 ease-in-out"
                                title="Eliminar este día (fase)">
                                <i data-feather="trash-2" class="w-5 h-5"></i>
                            </button>

                            <x-label value="Nombre del ejercicio (fase)" class="text-white" />
                            <input type="text" :name="'fases['+i+'][nombre]'" x-model="fase.nombre" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required placeholder="Ej: Calentamiento, Sesión de Pecho y Tríceps, Enfriamiento">

                            <x-label value="Duración (min)" class="text-white" />
                            <input type="number" :name="'fases['+i+'][duracion_min]'" x-model="fase.duracion_min" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required placeholder="Ej: 30, 60, 90">

                            <x-label value="Kcal estimadas para esta fase" class="text-white" />
                            <input type="number" :name="'fases['+i+'][kcal_estimadas]'" x-model="fase.kcal_estimadas" class="w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 py-2 px-3" required placeholder="Ej: 150 kcal">

                            <x-label value="Imagen del ejercicio (fase)" class="text-white" />
                            <template x-if="fase.imagen && !fase.new_imagen_file">
                                <div class="mb-3">
                                    <img :src="'/storage/' + fase.imagen" alt="Imagen actual de la fase" class="rounded-lg max-w-xs h-auto shadow-md">
                                    <p class="text-xs text-gray-400 mt-1">Imagen actual. Sube una nueva para reemplazarla.</p>
                                </div>
                            </template>
                            <input type="file" :name="'fases['+i+'][new_imagen_file]'" accept="image/*"
                                @change="fase.new_imagen_file = $event.target.files[0]"
                                class="w-full bg-gray-600 border-gray-500 text-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-2 p-2
                                      file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                      file:bg-gray-500 file:text-white hover:file:bg-gray-400 transition-colors duration-200 cursor-pointer" />


                            <div x-data="{ actividades: fase.actividades }" :id="'actividades-container-' + i">
                                <h4 class="text-xl font-bold text-white mb-4 mt-8 border-b border-gray-600 pb-2">Actividades de este Día</h4>
                                <template x-for="(act, j) in actividades" :key="act.id || j">
                                    <div class="mb-2 p-4 bg-gray-600 border border-gray-500 rounded-lg shadow-sm relative">
                                        <h5 class="text-lg font-semibold mb-3 text-white">Actividad <span x-text="j + 1"></span></h5>

                                        {{-- Hidden input for existing actividad ID --}}
                                        <input type="hidden" :name="'fases['+i+'][actividades]['+j+'][id]'" x-model="act.id">

                                        {{-- Botón para eliminar esta actividad --}}
                                        <button type="button" @click="if(act.id) fase.deleted_actividades.push(act.id); actividades.splice(j, 1);"
                                            class="absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white p-1 rounded-full shadow-sm transition duration-300 ease-in-out"
                                            title="Eliminar esta actividad">
                                            <i data-feather="x" class="w-4 h-4"></i>
                                        </button>

                                        <x-label value="Nombre Actividad" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][nombre]'" x-model="act.nombre" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: Flexiones, Carrera en cinta">

                                        <x-label value="Tipo (ej: cardio, fuerza...)" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][tipo]'" x-model="act.tipo" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: Fuerza, Cardio, Resistencia">

                                        <x-label value="Series" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][series]'" x-model="act.series" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: 3 series">

                                        <x-label value="Repeticiones (opcional)" class="text-white" />
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][repeticiones]'" x-model="act.repeticiones" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: 10-12 repeticiones, 30 segundos">

                                        <x-label value="URL Imagen (opcional)" class="text-white" />
                                        <template x-if="act.imagen">
                                            <div class="mb-3">
                                                <img :src="act.imagen.startsWith('http') ? act.imagen : '/storage/' + act.imagen" alt="Imagen actual de la actividad" class="rounded-lg max-w-xs h-auto shadow-md">
                                                <p class="text-xs text-gray-400 mt-1">Imagen actual.</p>
                                            </div>
                                        </template>
                                        {{-- Nota: Para imágenes de actividades, asumo que son URLs externas. Si son subidas, necesitarás una lógica similar a la de las fases. --}}
                                        <input type="text" :name="'fases['+i+'][actividades]['+j+'][imagen]'" x-model="act.imagen" class="w-full bg-gray-500 border-gray-400 text-white placeholder-gray-300 focus:border-red-600 focus:ring-red-600 rounded-lg mb-1 py-2 px-3" placeholder="Ej: https://ejemplo.com/flexiones.jpg">
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

                    {{-- Hidden inputs para fases y actividades eliminadas --}}
                    <template x-for="id in deleted_fases">
                        <input type="hidden" name="deleted_fases[]" :value="id">
                    </template>
                    <template x-for="(fase, i) in fases">
                        <template x-for="id in fase.deleted_actividades">
                            <input type="hidden" :name="'fases['+i+'][deleted_actividades][]'" :value="id">
                        </template>
                    </template>


                    <x-button class="bg-red-700 hover:bg-red-800 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">Guardar Cambios</x-button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Funciones para gestionar las fechas, si aún son necesarias (aunque ya están en el input HTML5)
            document.addEventListener("DOMContentLoaded", function() {
                const fechaInput = document.getElementById('fecha');
                if (fechaInput) { // Check if the element exists, as 'fecha' might not be needed for general entrenamientos
                    const hoy = new Date();
                    const maxFecha = new Date();
                    maxFecha.setMonth(hoy.getMonth() + 6);

                    const formatDate = (date) => {
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    };

                    fechaInput.min = fechaInput.min || formatDate(hoy);
                    fechaInput.max = fechaInput.max || formatDate(maxFecha);
                }
            });
        </script>
    @endpush
</x-app-layout>