<x-app-layout>
    {{-- La sección x-slot name="header" se manejará directamente en el div principal para un control de estilo más fino --}}

    {{-- Contenedor principal con fondo oscuro y altura mínima --}}
    <div class="py-12 bg-gray-900 text-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            {{-- Sección de Bienvenida --}}
            <div class="text-center mb-12 animate-fade-in-down">
                <h1 class="text-5xl md:text-6xl font-extrabold text-white tracking-tight leading-tight drop-shadow-lg">
                    👋 ¡Bienvenido de nuevo, <span class="text-blue-400">{{ Auth::user()->name }}</span>!
                </h1>
                <p class="mt-4 text-xl md:text-2xl text-gray-300 font-light max-w-2xl mx-auto">
                    Explora tus clases y entrenamientos disponibles y lleva un seguimiento de tu progreso.
                </p>
            </div>

            {{-- Mensajes de estado (success/error) --}}
            @if (session('success'))
                <div class="bg-green-700 border-l-4 border-green-500 text-green-100 p-4 rounded-lg shadow-md flex items-center mb-6 animate-fade-in" role="alert"
                    x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <i data-feather="check-circle" class="w-6 h-6 mr-3"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-700 border-l-4 border-red-500 text-red-100 p-4 rounded-lg shadow-md flex items-center mb-6 animate-fade-in" role="alert"
                    x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <i data-feather="alert-triangle" class="w-6 h-6 mr-3"></i>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Sección de Clases --}}
            <section
                class="bg-gray-800 p-6 sm:p-8 rounded-3xl shadow-2xl border border-gray-700 transition-all duration-500 transform hover:scale-[1.01] hover:shadow-glow">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-gray-700 pb-4">
                    <h3 class="text-3xl font-extrabold text-red-400 flex items-center gap-4 mb-3 sm:mb-0">
                        <i data-feather="users" class="w-8 h-8 text-red-300 animate-pulse"></i> Clases Grupales
                    </h3>
                    <a href="{{ route('cliente.clases.index') }}"
                        class="inline-flex items-center text-blue-400 hover:text-blue-300 font-semibold transition-all duration-300 group text-lg">
                        Ver todas las clases <i data-feather="arrow-right"
                            class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                @if ($clases->isEmpty())
                    <div class="bg-gray-700 p-8 rounded-xl text-center border border-gray-600 animate-pulse-slow">
                        <i data-feather="frown" class="w-16 h-16 text-gray-400 mx-auto mb-6"></i>
                        <p class="text-gray-400 text-xl font-medium">Parece que no hay clases grupales disponibles en
                            este momento.</p>
                        <p class="text-gray-500 text-md mt-3">¡Vuelve pronto para ver las nuevas adiciones y
                            emocionantes sesiones!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($clases as $clase)
                            @php
                                $cuposRestantes = $clase->cupos_restantes;

                                if ($cuposRestantes > 5) {
                                    $colorBg = 'bg-green-600';
                                    $colorText = 'text-green-100';
                                    $textoCupos = 'Disponible';
                                } elseif ($cuposRestantes > 0) {
                                    $colorBg = 'bg-yellow-600';
                                    $colorText = 'text-yellow-100';
                                    $textoCupos = 'Pocos cupos';
                                } else {
                                    $colorBg = 'bg-red-600';
                                    $colorText = 'text-red-100';
                                    $textoCupos = 'Sin cupos';
                                }
                            @endphp

                            <div
                                class="bg-gray-700 p-6 rounded-2xl shadow-xl border border-gray-600 flex flex-col justify-between hover:bg-gray-600 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                                <div>
                                    <h4 class="text-2xl font-bold text-white mb-2">{{ $clase->nombre }}</h4>
                                    <p class="text-md text-gray-300 mb-4">{{ Str::limit($clase->descripcion, 100) }}</p>
                                    <p class="text-sm text-gray-400 mb-2 flex items-center gap-2">
                                        <i data-feather="calendar" class="w-4 h-4 text-gray-400"></i>
                                        Inicio:
                                        {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="text-sm text-gray-400 mb-4 flex items-center gap-2">
                                        <i data-feather="users" class="w-4 h-4 text-gray-400"></i> Cupos:
                                        {{ $clase->cupos_maximos }} | Restantes: {{ $cuposRestantes }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between mt-4">
                                    {{-- Etiqueta de estado de cupos --}}
                                    <span
                                        class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold {{ $colorBg }} {{ $colorText }}">
                                        {{ $textoCupos }}
                                    </span>

                                    {{-- Botón para unirse a la clase o mostrar estado --}}
                                    @if ($clase->expirada)
                                        <button
                                            class="bg-gray-600 text-gray-300 font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75"
                                            disabled>
                                            <i data-feather="calendar-off" class="w-4 h-4 inline-block mr-1"></i> Clase
                                            Expirada
                                        </button>
                                    @elseif ($clase->inscrito)
                                        <button
                                            class="bg-green-700 text-green-100 font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75"
                                            disabled>
                                            <i data-feather="check" class="w-4 h-4 inline-block mr-1"></i> Ya inscrito
                                        </button>
                                    @elseif ($clase->solicitud_pendiente)
                                        <button
                                            class="bg-blue-600 text-white font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75"
                                            disabled>
                                            <i data-feather="clock" class="w-4 h-4 inline-block mr-1"></i> Solicitud
                                            Pendiente
                                        </button>
                                    @elseif ($clase->revocado)
                                        <button
                                            class="bg-red-600 text-white font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75"
                                            disabled>
                                            <i data-feather="x-circle" class="w-4 h-4 inline-block mr-1"></i> Revocado
                                        </button>
                                    @elseif ($clase->cupos_restantes <= 0)
                                        <button
                                            class="bg-red-700 text-red-100 font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75"
                                            disabled>
                                            <i data-feather="slash" class="w-4 h-4 inline-block mr-1"></i> Sin cupos
                                        </button>
                                    @else
                                        {{-- Botón real para unirse --}}
                                        <form action="{{ route('cliente.clases.unirse', $clase) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                                                <i data-feather="plus" class="w-4 h-4 inline-block mr-1"></i> Unirme
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>


           {{-- Sección de Entrenamientos --}}
<section
    class="bg-gray-800 p-6 sm:p-8 rounded-3xl shadow-2xl border border-gray-700 transition-all duration-500 transform hover:scale-[1.01] hover:shadow-glow section-trainings"> {{-- Añadido 'section-trainings' para posible personalización de hover-glow --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-gray-700 pb-4">
        <h3 class="text-3xl font-extrabold text-green-400 flex items-center gap-4 mb-3 sm:mb-0">
            <i data-feather="zap" class="w-8 h-8 text-green-300 animate-pulse"></i> Entrenamientos
        </h3>
    </div>

    @if ($entrenamientos->isEmpty())
        <div class="bg-gray-700 p-8 rounded-xl text-center border border-gray-600 animate-pulse-slow">
            <i data-feather="activity" class="w-16 h-16 text-gray-400 mx-auto mb-6"></i>
            <p class="text-gray-400 text-xl font-medium">No hay entrenamientos disponibles en este momento.</p>
            <p class="text-gray-500 text-md mt-3">¡Mantente atento a nuevas rutinas personalizadas y desafíos!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($entrenamientos as $entrenamiento)
                <div class="bg-gray-700 rounded-2xl shadow-xl border border-gray-600 flex flex-col cursor-pointer hover:bg-gray-600 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl overflow-hidden"
                    x-data="{ open: false }">
                    <div @click="open = true" class="flex flex-col flex-grow">
                        {{-- Imagen --}}
                        <div class="w-full h-40 overflow-hidden rounded-t-2xl">
                            <img src="{{ $entrenamiento->zona_muscular ? asset('storage/' . $entrenamiento->zona_muscular) : 'https://via.placeholder.com/400x250?text=Entrenamiento' }}"
                                alt="Imagen de {{ $entrenamiento->nombre }}"
                                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        </div>

                        {{-- Info básica --}}
                        <div class="p-4 flex flex-col gap-2">
                            <h4 class="text-2xl font-bold text-white">{{ $entrenamiento->nombre }}</h4>
                            <p class="text-gray-300 font-semibold">Nivel: {{ $entrenamiento->nivel }}</p>
                            <p class="text-gray-400 flex items-center gap-1">
                                <i data-feather="calendar" class="w-4 h-4"></i>
                                Duración: {{ $entrenamiento->duracion_dias ?? 'N/A' }} días
                            </p>
                        </div>
                    </div>

                    {{-- Modal con detalles completos --}}
                    <div x-show="open"
                        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4"
                        x-transition.opacity @click.away="open = false" style="display: none;">
                        <div class="bg-gray-800 rounded-xl max-w-4xl w-full max-h-[90vh] overflow-auto p-6 relative shadow-2xl"
                            @keydown.window.escape="open = false">
                            <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-200 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500"
                                @click="open = false" aria-label="Cerrar modal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            {{-- Contenido del modal --}}
                            <h2 class="text-3xl font-extrabold text-green-400 mb-4">{{ $entrenamiento->nombre }}
                            </h2>
                            <p class="text-gray-300 mb-4 text-lg">{{ $entrenamiento->descripcion }}</p>

                            <div class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-400 text-lg font-medium">
                                <p class="flex items-center gap-2"><i data-feather="bar-chart-2" class="w-5 h-5 text-green-300"></i><strong>Nivel:</strong> {{ $entrenamiento->nivel }}</p>
                                <p class="flex items-center gap-2"><i data-feather="clock" class="w-5 h-5 text-green-300"></i><strong>Duración total:</strong> {{ $entrenamiento->duracion }} min</p>
                                <p class="flex items-center gap-2"><i data-feather="calendar" class="w-5 h-5 text-green-300"></i><strong>Días:</strong> {{ $entrenamiento->duracion_dias ?? 'N/A' }}</p>
                            </div>

                            {{-- Imagen general --}}
                            <img src="{{ $entrenamiento->zona_muscular ? asset('storage/' . $entrenamiento->zona_muscular) : 'https://via.placeholder.com/600x400?text=Entrenamiento' }}"
                                alt="Imagen de {{ $entrenamiento->nombre }}"
                                class="rounded-lg mb-6 w-full object-cover max-h-80 shadow-lg">

                            {{-- Fases y ejercicios --}}
                            <div>
                                <h3 class="text-2xl font-bold mb-4 text-white border-b border-gray-700 pb-2 flex items-center gap-2">
                                    <i data-feather="list" class="w-6 h-6 text-green-400"></i> Fases y Ejercicios
                                </h3>
                                @forelse ($entrenamiento->fases as $fase)
                                    <div class="mb-6 p-4 bg-gray-700 rounded-lg shadow-inner border border-gray-600">
                                        <h4 class="text-xl font-bold text-green-400 mb-2 flex items-center gap-2">
                                            <i data-feather="chevrons-right" class="w-5 h-5 text-green-300"></i> {{ $fase->nombre }}
                                        </h4>
                                        @if($fase->descripcion)<p class="text-gray-300 mb-3">{{ $fase->descripcion }}</p>@endif

                                        @if($fase->actividades->isEmpty())
                                            <p class="text-gray-500 italic">No hay actividades para esta fase.</p>
                                        @else
                                            <ul class="space-y-4 pt-2">
                                                @foreach ($fase->actividades as $actividad)
                                                    <li class="flex items-center gap-4 bg-gray-600 p-3 rounded-lg shadow-sm">
                                                        <img src="{{ $actividad->imagen ?? 'https://via.placeholder.com/80x60?text=Actividad' }}"
                                                            alt="Actividad {{ $actividad->nombre }}"
                                                            class="w-24 h-20 object-cover rounded flex-shrink-0 border border-gray-500">
                                                        <div>
                                                            <p class="font-semibold text-white text-lg">{{ $actividad->nombre }}</p>
                                                            @if($actividad->descripcion)<p class="text-sm text-gray-300">{{ Str::limit($actividad->descripcion, 80) }}</p>@endif
                                                            <p class="text-xs text-gray-400 flex items-center gap-1 mt-1">
                                                                <i data-feather="clock" class="w-3 h-3"></i> Duración:
                                                                {{ $actividad->duracion_minutos ?? ($actividad->duracion_min ?? 'N/A') }}
                                                                min
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-gray-500 italic">Este entrenamiento no tiene fases definidas.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

        </div>
    </div>
        <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down { animation: fadeInDown 0.8s ease-out forwards; }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }

        @keyframes pulseSlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-pulse-slow { animation: pulseSlow 4s infinite ease-in-out; }

        /* Efecto de brillo en hover específico para esta sección */
        .section-trainings:hover {
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.5), 0 0 30px rgba(16, 185, 129, 0.3); /* green-500 */
        }

        /* Ajustes para scrollbar en modales */
        .max-h-[90vh]::-webkit-scrollbar {
            width: 8px;
        }

        .max-h-[90vh]::-webkit-scrollbar-track {
            background: #374151; /* gray-700 */
            border-radius: 10px;
        }

        .max-h-[90vh]::-webkit-scrollbar-thumb {
            background-color: #6b7280; /* gray-500 */
            border-radius: 10px;
            border: 2px solid #374151; /* gray-700 */
        }
        </style>
</x-app-layout>