<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Panel del Cliente') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro --}}
    <div class="py-12 bg-gray-900 text-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            <div class="text-center mb-12 animate-fade-in-down">
                <h1 class="text-5xl font-extrabold text-white tracking-tight leading-tight">
                    👋 ¡Bienvenido de nuevo, <span class="text-blue-400">{{ Auth::user()->name }}</span>!
                </h1>
                <p class="mt-4 text-xl text-gray-300 font-light">
                    Explora tus clases y entrenamientos disponibles y lleva un seguimiento de tu progreso.
                </p>
            </div>

            {{-- Mensajes de estado (success/error) --}}
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-6 shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded-lg mb-6 shadow-md">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Sección de Clases Grupales --}}
            <div class="bg-gray-800 p-8 rounded-3xl shadow-2xl border border-gray-700 transition-all duration-500 transform hover:scale-[1.01] hover:shadow-glow">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-3xl font-extrabold text-red-400 flex items-center gap-4">
                        <i data-feather="users" class="w-8 h-8 text-red-300 animate-pulse"></i> Clases Grupales
                    </h3>
                    <a href="{{ route('cliente.clases.index') }}"
                        class="inline-flex items-center text-blue-400 hover:text-blue-300 font-semibold transition-all duration-300 group text-lg">
                        Ver todas <i data-feather="arrow-right" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                @if($clases->isEmpty())
                    <div class="bg-gray-700 p-8 rounded-xl text-center border border-gray-600 animate-pulse-slow">
                        <i data-feather="frown" class="w-16 h-16 text-gray-400 mx-auto mb-6"></i>
                        <p class="text-gray-400 text-xl font-medium">Parece que no hay clases grupales disponibles en este momento.</p>
                        <p class="text-gray-500 text-md mt-3">¡Vuelve pronto para ver las nuevas adiciones y emocionantes sesiones!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($clases as $clase)
                            <div class="bg-gray-700 p-6 rounded-2xl shadow-xl border border-gray-600 flex flex-col justify-between hover:bg-gray-600 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                                <div>
                                    <h4 class="text-2xl font-bold text-white mb-2">{{ $clase->nombre }}</h4>
                                    <p class="text-md text-gray-300 mb-4">{{ Str::limit($clase->descripcion, 100) }}</p>
                                    <p class="text-sm text-gray-400 mb-2 flex items-center gap-2">
                                        <i data-feather="calendar" class="w-4 h-4 text-gray-400"></i> Inicio: {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="text-sm text-gray-400 mb-4 flex items-center gap-2">
                                        <i data-feather="users" class="w-4 h-4 text-gray-400"></i> Cupos: {{ $clase->cupos_maximos }}
                                    </p>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    {{-- Etiqueta de estado de cupos --}}
                                    <span class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold
                                        @if ($clase->cupos_maximos > 5)
                                            bg-green-600 text-green-100
                                        @elseif ($clase->cupos_maximos > 0 && $clase->cupos_maximos <= 5)
                                            bg-yellow-600 text-yellow-100
                                        @else
                                            bg-red-600 text-red-100
                                        @endif
                                    ">
                                        @if ($clase->cupos_maximos > 5)
                                            Disponible
                                        @elseif ($clase->cupos_maximos > 0 && $clase->cupos_maximos <= 5)
                                            Pocos cupos
                                        @else
                                            Sin cupos
                                        @endif
                                    </span>
                                    
                                    {{-- Botón para unirse a la clase o mostrar estado --}}
                                    @if ($clase->expirada)
                                        <button class="bg-gray-600 text-gray-300 font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75" disabled>
                                            <i data-feather="calendar-off" class="w-4 h-4 inline-block mr-1"></i> Clase Expirada
                                        </button>
                                    @elseif ($clase->inscrito)
                                        <button class="bg-green-700 text-green-100 font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75" disabled>
                                            <i data-feather="check" class="w-4 h-4 inline-block mr-1"></i> Ya inscrito
                                        </button>
                                    @elseif ($clase->solicitud_pendiente)
                                        <button class="bg-blue-600 text-white font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75" disabled>
                                            <i data-feather="clock" class="w-4 h-4 inline-block mr-1"></i> Solicitud Pendiente
                                        </button>
                                    @elseif ($clase->revocado)
                                        <button class="bg-red-600 text-white font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75" disabled>
                                            <i data-feather="x-circle" class="w-4 h-4 inline-block mr-1"></i> Revocado
                                        </button>
                                    @elseif ($clase->cupos_maximos <= 0)
                                        <button class="bg-red-700 text-red-100 font-medium py-2 px-4 rounded-lg cursor-not-allowed text-sm opacity-75" disabled>
                                            <i data-feather="slash" class="w-4 h-4 inline-block mr-1"></i> Sin cupos
                                        </button>
                                    @else
                                        {{-- Botón real para unirse --}}
                                        <form action="{{ route('cliente.clases.unirse', $clase) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                                                <i data-feather="plus" class="w-4 h-4 inline-block mr-1"></i> Unirme
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Sección de Entrenamientos --}}
            <div class="bg-gray-800 p-8 rounded-3xl shadow-2xl border border-gray-700 transition-all duration-500 transform hover:scale-[1.01] hover:shadow-glow">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-3xl font-extrabold text-green-400 flex items-center gap-4">
                        <i data-feather="activity" class="w-8 h-8 text-green-300 animate-spin-slow"></i> Entrenamientos Personalizados
                    </h3>
                    <a href="{{ route('cliente.entrenamientos.index') }}"
                        class="inline-flex items-center text-blue-400 hover:text-blue-300 font-semibold transition-colors duration-200 group text-lg">
                        Ver todos <i data-feather="arrow-right" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                @if($entrenamientos->isEmpty())
                    <div class="bg-gray-700 p-8 rounded-xl text-center border border-gray-600 animate-pulse-slow">
                        <i data-feather="frown" class="w-16 h-16 text-gray-400 mx-auto mb-6"></i>
                        <p class="text-gray-400 text-xl font-medium">Actualmente no hay entrenamientos personalizados disponibles.</p>
                        <p class="text-gray-500 text-md mt-3">¡Explora nuevas rutinas y alcanza tus metas pronto!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($entrenamientos as $entrenamiento)
                            <div class="bg-gray-700 rounded-2xl shadow-xl border border-gray-600 flex flex-col hover:bg-gray-600 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl overflow-hidden">
                                <div class="p-6 flex flex-col flex-grow sm:flex-row sm:items-start sm:gap-6"> {{-- Añadido flex-row, items-start y gap --}}
                                    <div class="flex-grow"> {{-- Contenedor para el texto --}}
                                        <h4 class="text-2xl font-bold text-white mb-2">{{ $entrenamiento->nombre }}</h4>
                                        <p class="text-md text-gray-300 mb-3">Tipo: <span class="font-semibold text-gray-200">{{ $entrenamiento->tipo }}</span></p>
                                        <p class="text-sm text-gray-400 mb-2 flex items-center gap-2">
                                            <i data-feather="clock" class="w-4 h-4 text-gray-400"></i> Duración: <span class="font-medium text-gray-300">{{ $entrenamiento->duracion }} min</span>
                                        </p>
                                        <p class="text-sm text-gray-400 flex items-center gap-2 mb-4">
                                            <i data-feather="calendar" class="w-4 h-4 text-gray-400"></i> Fecha: <span class="font-medium text-gray-300">{{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y') }}</span>
                                        </p>
                                    </div>
                                    
                                    {{-- Imagen del Entrenamiento --}}
                                    <div class="flex-shrink-0 w-full sm:w-1/2 md:w-2/5 lg:w-1/3 h-32 sm:h-auto overflow-hidden rounded-lg mt-4 sm:mt-0"> {{-- Ajusta el ancho y la altura --}}
                                        <img src="{{ $entrenamiento->url_img ?? 'https://via.placeholder.com/400x250?text=Entrenamiento' }}" 
                                             alt="Imagen del Entrenamiento: {{ $entrenamiento->nombre }}" 
                                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                    </div>
                                </div>
                                <div class="px-6 pb-6 mt-auto"> {{-- Botón en la parte inferior, siempre --}}
                                    <a href="#"
                                       class="inline-flex items-center text-blue-400 hover:text-blue-300 font-medium transition-colors duration-200 text-sm group">
                                        Ver Detalles <i data-feather="chevron-right" class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
    <style>
        @keyframes fadeInDown {
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
            animation: fadeInDown 0.8s ease-out forwards;
        }

        @keyframes pulseSlow {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
            100% {
                opacity: 1;
            }
        }

        .animate-pulse-slow {
            animation: pulseSlow 3s infinite ease-in-out;
        }

        @keyframes pulseColor {
            0%, 100% {
                color: #f87171; /* red-400 */
            }
            50% {
                color: #fca5a5; /* red-300 */
            }
        }

        .animate-pulse {
            animation: pulseColor 2s infinite ease-in-out;
        }

        @keyframes spinSlow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spinSlow 5s linear infinite;
        }

        .hover\:shadow-glow:hover {
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.6), 0 0 30px rgba(59, 130, 246, 0.4); /* blue-500 glow */
        }
    </style>
</x-app-layout>