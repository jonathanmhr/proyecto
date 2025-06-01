<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Panel del Cliente') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro --}}
    <div class="py-12 bg-gray-900 text-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            <div class="text-center mb-10 animate-fade-in-down">
                <h1 class="text-4xl font-extrabold text-white tracking-tight leading-tight">
                    👋 ¡Bienvenido de nuevo, <span class="text-blue-500">{{ Auth::user()->name }}</span>!
                </h1>
                <p class="mt-3 text-lg text-gray-400">
                    Explora tus clases y entrenamientos disponibles.
                </p>
            </div>

            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-700 transition-all duration-300 transform hover:scale-[1.005]">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-2xl font-bold text-red-400 flex items-center gap-3">
                        <i data-feather="users" class="w-7 h-7 text-red-300"></i> Clases Grupales
                    </h3>
                    <a href="{{ route('cliente.clases.index') }}"
                        class="inline-flex items-center text-blue-400 hover:text-blue-500 font-medium transition-colors duration-200 group">
                        Ver todas <i data-feather="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                @if($clases->isEmpty())
                    <div class="bg-gray-700 p-6 rounded-lg text-center border border-gray-600 animate-pulse-slow">
                        <i data-feather="frown" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-400 text-lg">Parece que no hay clases grupales disponibles en este momento.</p>
                        <p class="text-gray-500 text-sm mt-2">¡Vuelve pronto para ver las nuevas adiciones!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($clases as $clase)
                            <div class="bg-gray-700 p-5 rounded-xl shadow-md border border-gray-600 flex flex-col justify-between hover:bg-gray-600 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                <div>
                                    <h4 class="text-xl font-bold text-white mb-2">{{ $clase->nombre }}</h4>
                                    <p class="text-sm text-gray-300 mb-3">{{ Str::limit($clase->descripcion, 120) }}</p>
                                    <p class="text-sm text-gray-400 mb-1 flex items-center gap-2">
                                        <i data-feather="calendar" class="w-4 h-4"></i> Inicio: {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-sm text-gray-400 mb-3 flex items-center gap-2">
                                        <i data-feather="users" class="w-4 h-4"></i> Cupos: {{ $clase->cupos_maximos }}
                                    </p>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
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
                                    <a href="#"
                                       class="inline-flex items-center text-blue-400 hover:text-blue-500 font-medium transition-colors duration-200">
                                        Ver Detalles <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-700 transition-all duration-300 transform hover:scale-[1.005]">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-2xl font-bold text-green-400 flex items-center gap-3">
                        <i data-feather="activity" class="w-7 h-7 text-green-300"></i> Entrenamientos
                    </h3>
                    <a href="{{ route('cliente.entrenamientos.index') }}"
                        class="inline-flex items-center text-blue-400 hover:text-blue-500 font-medium transition-colors duration-200 group">
                        Ver todos <i data-feather="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                @if($entrenamientos->isEmpty())
                    <div class="bg-gray-700 p-6 rounded-lg text-center border border-gray-600 animate-pulse-slow">
                        <i data-feather="frown" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-400 text-lg">Actualmente no hay entrenamientos disponibles.</p>
                        <p class="text-gray-500 text-sm mt-2">¡Explora nuevas rutinas pronto!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($entrenamientos as $entrenamiento)
                            <div class="bg-gray-700 p-5 rounded-xl shadow-md border border-gray-600 flex flex-col justify-between hover:bg-gray-600 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                <div>
                                    <h4 class="text-xl font-bold text-white mb-2">{{ $entrenamiento->nombre }}</h4>
                                    <p class="text-sm text-gray-300 mb-3">Tipo: {{ $entrenamiento->tipo }}</p>
                                    <p class="text-sm text-gray-400 mb-1 flex items-center gap-2">
                                        <i data-feather="clock" class="w-4 h-4"></i> Duración: {{ $entrenamiento->duracion }} min
                                    </p>
                                    <p class="text-sm text-gray-400 flex items-center gap-2">
                                        <i data-feather="calendar" class="w-4 h-4"></i> Fecha: {{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <a href="#"
                                       class="inline-flex items-center text-blue-400 hover:text-blue-500 font-medium transition-colors duration-200">
                                        Ver Detalles <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
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
        </style>
</x-app-layout>