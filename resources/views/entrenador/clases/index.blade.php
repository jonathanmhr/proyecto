<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Mis Clases') }}
        </h2>
    </x-slot>

    <main class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold text-red-400 tracking-tight mb-4 sm:mb-0">Mis Clases</h1>
            <a href="{{ route('entrenador.dashboard') }}"
               class="inline-flex items-center px-5 py-2 bg-blue-700 hover:bg-blue-800 rounded-lg shadow-md transition-colors duration-200 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Volver
            </a>
        </div>

        <section class="space-y-8">
            @forelse ($clases as $clase)
                <article
                    class="bg-gray-800 border border-gray-700 rounded-2xl p-6 hover:shadow-xl hover:bg-gray-700 transition-transform duration-300 transform hover:-translate-y-1">
                    <header>
                        <h3 class="text-2xl font-bold text-red-400 mb-2">{{ $clase->nombre }}</h3>
                    </header>

                    <p class="text-gray-300 mb-4 leading-relaxed">{{ $clase->descripcion }}</p>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-400 mb-6">
                        <div>
                            <dt class="font-semibold text-gray-200">Fecha</dt>
                            <dd>
                                {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }} - 
                                {{ \Carbon\Carbon::parse($clase->fecha_fin)->format('d/m/Y') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-200">Ubicación</dt>
                            <dd>{{ $clase->ubicacion }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-200">Cupos disponibles</dt>
                            <dd>{{ $clase->cupos_maximos }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-200">Duración estimada</dt>
                            <dd>{{ $clase->duracion }} minutos</dd>
                        </div>
                    </dl>

                    <div>
                        @if ($clase->cambio_pendiente)
                            <span
                                class="inline-block bg-yellow-600 text-yellow-100 px-3 py-1 rounded-full text-xs font-bold mb-4">
                                Cambios pendientes de aprobación
                            </span>
                        @else
                            <span
                                class="inline-block bg-green-600 text-green-100 px-3 py-1 rounded-full text-xs font-bold mb-4">
                                Clase Aceptada
                            </span>
                        @endif
                    </div>

                    <footer class="flex flex-wrap gap-4 mt-4">
                        <a href="{{ route('entrenador.clases.edit', $clase->id_clase) }}"
                           class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M15.232 5.232l3.536 3.536M9 11l3 3L21 5l-3-3L9 11z" />
                            </svg>
                            Editar Clase
                        </a>

                        <a href="{{ route('entrenador.clases.alumnos', $clase->id_clase) }}"
                           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20h6M4 20h5v-2a4 4 0 0 0-3-3.87M12 7a4 4 0 1 0 0 8 4 4 0 0 0 0-8z" />
                            </svg>
                            Gestionar Alumnos
                        </a>
                    </footer>
                </article>
            @empty
                <p class="text-center text-gray-400 text-lg py-16">
                    No tienes clases programadas en este momento.
                </p>
            @endforelse
        </section>
    </main>
</x-app-layout>
