<x-app-layout>
    <div class="container mx-auto p-6 lg:p-12 bg-gray-900 min-h-screen text-white font-sans">

        {{-- Contenedor para el título y el botón "Volver" --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10">
            <h1 class="text-4xl font-extrabold text-green-400 text-center sm:text-left leading-tight mb-4 sm:mb-0">
                Planificar tu Entrenamiento: <span class="block sm:inline-block mt-2 sm:mt-0 text-white">{{ $entrenamiento->titulo }}</span>
            </h1>

            {{-- Botón de Volver a Entrenamientos a la derecha --}}
            <a href="{{ route('cliente.entrenamientos.index') }}"
               class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-full font-bold text-white text-base tracking-wider hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.01] shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                </svg>
                Volver a Mis Entrenamientos
            </a>
        </div>

        <p class="text-gray-400 text-lg mb-8 max-w-2xl mx-auto sm:mx-0">
            Aquí puedes añadir nuevas fases a tu plan de entrenamiento y visualizar las que ya tienes programadas.
        </p>

        {{-- Mensaje si el entrenamiento no tiene fases --}}
        @if ($entrenamiento->fases->isEmpty())
            <div class="bg-gray-800 p-10 rounded-2xl shadow-xl text-center border border-gray-700 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-500 mx-auto mb-8 animate-bounce-slow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-300 text-3xl font-bold mb-4">
                    ¡Ups! Este entrenamiento no tiene fases.
                </p>
                <p class="text-gray-400 text-lg mb-8">
                    Necesitas que tu entrenador añada fases a este plan para poder planificarlas.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-12">

                {{-- Formulario para planificar una nueva fase --}}
                <div class="bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-700 transition-all duration-300 transform hover:scale-[1.01] hover:shadow-2xl animate-slide-in-left">
                    <h3 class="text-3xl font-extrabold text-green-400 mb-6 flex items-center gap-3 border-b border-gray-700 pb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Añadir nueva fase
                    </h3>

                    <form method="POST" action="{{ route('cliente.entrenamientos.fases-dias.store', $entrenamiento) }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="fase_entrenamiento_id" class="block text-gray-300 text-base font-medium mb-2">
                                Selecciona la fase de entrenamiento:
                            </label>
                            <select name="fase_entrenamiento_id" id="fase_entrenamiento_id" required
                                class="mt-1 block w-full px-5 py-3 bg-gray-900 border border-gray-600 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 text-white text-base appearance-none transition duration-200">
                                <option value="" disabled selected>Elige una fase...</option>
                                @foreach ($entrenamiento->fases as $fase)
                                    <option value="{{ $fase->id }}">{{ $fase->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="fecha" class="block text-gray-300 text-base font-medium mb-2">
                                Elige la fecha para esta fase:
                            </label>
                            <input type="date" name="fecha" id="fecha" required
                                min="{{ $fechaMin->format('Y-m-d') }}" max="{{ $fechaMax->format('Y-m-d') }}" {{-- ¡Aquí se usan las variables del controlador! --}}
                                class="mt-1 block w-full px-5 py-3 bg-gray-900 border border-gray-600 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 text-white text-base transition duration-200" />
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-3 bg-red-600 border border-transparent rounded-full font-bold text-white text-lg tracking-wide hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-200 transform hover:scale-105 shadow-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Guardar Planificación
                        </button>
                    </form>
                </div>

                {{-- Fases planificadas actualmente --}}
                <div class="bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-700 animate-slide-in-right">
                    <h4 class="text-3xl font-extrabold text-green-400 mb-6 flex items-center gap-3 border-b border-gray-700 pb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Mis fases planificadas
                    </h4>
                    @if ($entrenamiento->diasPlanificados->isEmpty())
                        <div class="text-center py-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-600 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h10a2 2 0 012 2v4a2 2 0 002 2h4a2 2 0 002-2V7a2 2 0 00-2-2h-2.586a1 1 0 01-.707-.293l-1.121-1.121A1 1 0 009.121 3H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-4a2 2 0 00-2-2h-4a2 2 0 00-2 2v4a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-400 text-lg">Aún no has planificado ninguna fase para este entrenamiento.</p>
                            <p class="text-gray-500 text-md mt-2">Usa el formulario de la izquierda para empezar.</p>
                        </div>
                    @else
                        <ul class="space-y-4">
                            @foreach ($entrenamiento->diasPlanificados->sortBy('fecha') as $faseDia)
                                <li class="bg-gray-700 p-4 rounded-lg shadow-md flex flex-col sm:flex-row items-start sm:items-center justify-between border border-gray-600 transition-all duration-200 transform hover:scale-[1.005]">
                                    <div class="flex items-center gap-4 mb-3 sm:mb-0">
                                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                            {{ \Carbon\Carbon::parse($faseDia->fecha)->format('d') }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-xl text-white block">{{ $faseDia->fase->nombre }}</span>
                                            <p class="text-gray-400 text-sm">Fecha: <span class="font-medium text-white">{{ \Carbon\Carbon::parse($faseDia->fecha)->locale('es')->isoFormat('dddd, DD MMMM YYYY') }}</span></p> {{-- Asegurando que el año también se muestre --}}
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 w-full sm:w-auto justify-end sm:justify-start">
                                        <span class="px-4 py-1 rounded-full text-sm font-semibold {{ $faseDia->estado === 'completado' ? 'bg-green-500 text-white' : ($faseDia->estado === 'pendiente' ? 'bg-yellow-500 text-black' : 'bg-gray-500 text-white') }} flex-shrink-0">
                                            {{ ucfirst($faseDia->estado) }}
                                        </span>
                                        <div class="flex gap-2 flex-shrink-0">
                                            <form action="{{ route('cliente.entrenamientos.fases-dias.toggle-estado', $faseDia->id) }}" method="POST" onsubmit="return confirm('¿Quieres cambiar el estado de esta fase?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-green-400 hover:text-green-500 transition-colors duration-200 p-2 rounded-full hover:bg-gray-600" title="{{ $faseDia->estado === 'completado' ? 'Marcar como pendiente' : 'Marcar como completado' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $faseDia->estado === 'completado' ? 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('cliente.entrenamientos.fases-dias.destroy', $faseDia->id) }}" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta fase planificada? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-500 transition-colors duration-200 p-2 rounded-full hover:bg-gray-600" title="Eliminar fase">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            feather.replace();
        </script>
    @endpush

    <style>
        /* Custom Tailwind animations for a smoother UX */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out forwards;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out forwards;
        }

        @keyframes bounceSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-bounce-slow {
            animation: bounceSlow 2s infinite ease-in-out;
        }

        /* Style for date input icon (optional, depends on browser) */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1); /* Makes the calendar icon white */
            cursor: pointer;
        }
        input[type="date"]::-moz-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }
    </style>
</x-app-layout>