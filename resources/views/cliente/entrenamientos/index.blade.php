<x-app-layout>
    <div class="container mx-auto px-6 py-10 sm:px-8 lg:px-12 bg-gray-900 min-h-screen text-gray-200">
        @if (session('success'))
            <div class="bg-green-600 text-white font-semibold p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-600 text-white font-semibold p-4 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Contenedor del Título y el Botón de Volver --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12 animate-fade-in-down">
            <h1
                class="text-4xl lg:text-5xl font-extrabold text-green-400 text-center sm:text-left leading-tight mb-4 sm:mb-0">
                Mis Entrenamientos Guardados <span class="block text-gray-400 text-xl font-medium mt-2">Gestiona tus
                    rutinas de fitness personalizadas</span>
            </h1>
            <a href="{{ route('cliente.dashboard') }}"
                class="inline-flex items-center px-6 py-2 bg-gray-700 border border-gray-600 rounded-full font-semibold text-white text-base tracking-wider hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al Dashboard
            </a>
        </div>

        @if ($entrenamientos->isEmpty())
            {{-- Mensaje cuando no hay entrenamientos guardados --}}
            <div class="bg-gray-800 p-10 rounded-2xl shadow-xl text-center border border-gray-700 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-600 mx-auto mb-8 animate-bounce-slow"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                <p class="text-gray-300 text-3xl font-bold mb-4">
                    ¡Todavía no tienes entrenamientos guardados!
                </p>
                <p class="text-gray-400 text-lg mb-8 max-w-2xl mx-auto">
                    Explora nuestra biblioteca para encontrar la rutina perfecta para ti y empieza a planificar tu
                    progreso.
                </p>
                <a href="{{ route('cliente.entrenamientos.index') }}"
                    class="inline-flex items-center px-8 py-3 bg-red-600 border border-transparent rounded-full font-bold text-white text-lg tracking-wider hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-200 transform hover:scale-105 shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Descubrir Entrenamientos
                </a>
            </div>
        @else
            {{-- Cuadrícula de tarjetas con animación hacia la derecha --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 xl:gap-10">
                @foreach ($entrenamientos as $index => $entrenamiento)
                    <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 p-6 flex flex-col justify-between
                                transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl hover:border-green-500
                                animate-fade-in-right"
                        style="animation-delay: {{ $index * 0.1 }}s;"> {{-- Retardo para efecto cascada --}}
                        <div>
                            {{-- Imagen del entrenamiento --}}
                            @if ($entrenamiento->zona_muscular)
                                <img src="{{ asset('storage/' . $entrenamiento->zona_muscular) }}"
                                    alt="Imagen de {{ $entrenamiento->titulo }}"
                                    class="w-full h-48 object-cover rounded-lg mb-5 shadow-md border border-gray-700">
                            @else
                                <img src="https://via.placeholder.com/400x250?text=Entrenamiento"
                                    alt="Imagen de Entrenamiento"
                                    class="w-full h-48 object-cover rounded-lg mb-5 shadow-md border border-gray-700">
                            @endif

                            <h2 class="text-3xl font-bold text-green-400 mb-3 leading-snug">{{ $entrenamiento->titulo }}
                            </h2>
                            <p class="text-gray-300 text-base leading-relaxed mb-4 line-clamp-3">
                                {{ $entrenamiento->descripcion }}</p>

                            {{-- Información adicional (Nivel, Duración) con iconos --}}
                            <div class="mb-5 text-gray-400 text-lg font-medium space-y-2">
                                <p class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Nivel: <span class="font-semibold text-white">{{ $entrenamiento->nivel }}</span>
                                </p>
                                <p class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Días: <span
                                        class="font-semibold text-white">{{ $entrenamiento->duracion_dias ?? 'N/A' }}</span>
                                </p>
                            </div>

                            {{-- Resumen de Fases (limitado en la tarjeta principal) --}}
                            @if ($entrenamiento->fases->isNotEmpty())
                                <div class="mb-4">
                                    <h3
                                        class="text-xl font-bold text-white mb-3 border-b border-gray-700 pb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                        Fases:
                                    </h3>
                                    <ul class="space-y-3">
                                        @foreach ($entrenamiento->fases->take(2) as $fase)
                                            {{-- Mostrar solo las primeras 2 fases --}}
                                            <li class="bg-gray-700 p-3 rounded-lg shadow-inner border border-gray-600">
                                                <h4
                                                    class="text-lg font-bold text-green-300 mb-1 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-green-200" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 5l7 7-7 7" />
                                                    </svg>
                                                    {{ $fase->nombre }}
                                                </h4>
                                                @if ($fase->actividades->isNotEmpty())
                                                    <ul
                                                        class="list-disc list-inside text-gray-400 text-sm mt-2 ml-4 space-y-1">
                                                        @foreach ($fase->actividades->take(2) as $actividad)
                                                            {{-- Mostrar solo 2 actividades por fase --}}
                                                            <li>
                                                                <span
                                                                    class="font-medium text-white">{{ $actividad->nombre }}</span>
                                                                @if ($actividad->series)
                                                                    - Series: {{ $actividad->series }}
                                                                @endif
                                                                @if ($actividad->repeticiones)
                                                                    - Reps: {{ $actividad->repeticiones }}
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                        @if ($fase->actividades->count() > 2)
                                                            <li class="italic text-gray-500">...y
                                                                {{ $fase->actividades->count() - 2 }} actividades más.
                                                            </li>
                                                        @endif
                                                    </ul>
                                                @else
                                                    <p class="text-sm text-gray-400 italic">No hay actividades.</p>
                                                @endif
                                            </li>
                                        @endforeach
                                        @if ($entrenamiento->fases->count() > 2)
                                            <p class="text-gray-500 italic mt-2 text-sm text-center">Ver todas las fases
                                                en el detalle (requiere otra página/ruta).</p>
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <p class="text-gray-500 italic mb-4">Este entrenamiento no tiene fases definidas aún.
                                </p>
                            @endif
                        </div>

                        {{-- Botones de acción ORIGINALES --}}
                        <div
                            class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('cliente.entrenamientos.planificar', $entrenamiento) }}"
                                class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-2 bg-red-600 border border-transparent rounded-full font-semibold text-white text-sm uppercase tracking-wider hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.03] shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Planificar
                            </a>

                            <form action="{{ route('cliente.entrenamientos.quitar', $entrenamiento->id) }}"
                                method="POST" class="w-full sm:w-auto"
                                onsubmit="return confirm('¿Estás seguro de que quieres quitar este entrenamiento de tus guardados? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-2 text-gray-500 border border-gray-600 rounded-full font-semibold text-sm uppercase tracking-wider hover:text-red-400 hover:border-red-400 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.03]"
                                    aria-label="Quitar entrenamiento">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Quitar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    @push('styles')
        <style>
            /* Custom Tailwind animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-out forwards;
            }

            @keyframes fadeIndown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-down {
                animation: fadeIndown 0.7s ease-out forwards;
            }

            /* Animación para aparecer desde la izquierda hacia la derecha */
            @keyframes fadeInRight {
                from {
                    opacity: 0;
                    transform: translateX(-40px);
                }

                /* Empieza más a la izquierda */
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .animate-fade-in-right {
                animation: fadeInRight 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
                /* Curva de aceleración */
            }

            @keyframes bounceSlow {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-8px);
                }
            }

            .animate-bounce-slow {
                animation: bounceSlow 2s infinite ease-in-out;
            }

            /* Para limitar las líneas de descripción */
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
                -webkit-line-clamp: 3;
            }
        </style>
    @endpush
</x-app-layout>
