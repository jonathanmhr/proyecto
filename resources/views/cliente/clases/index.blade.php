<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Clases Grupales') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo azul muy oscuro, casi negro, como tu paleta --}}
    <div class="py-12 bg-gray-900 text-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Mensajes de estado (success/error) --}}
            @if (session('success'))
                <div class="bg-green-600 text-white p-4 rounded-lg shadow-md flex items-center space-x-3 animate-fade-in">
                    <i data-feather="check-circle" class="w-6 h-6"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-600 text-white p-4 rounded-lg shadow-md flex items-center space-x-3 animate-fade-in">
                    <i data-feather="x-circle" class="w-6 h-6"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="text-center mb-8 animate-fade-in-down">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-100 tracking-tight leading-tight">
                    <span class="text-red-600">Tus Clases Grupales</span>
                </h1>
                <p class="mt-3 text-lg text-gray-400 font-light max-w-2xl mx-auto">
                    Explora todas las clases disponibles, gestiona tus inscripciones y solicitudes.
                </p>
            </div>

            @if ($clases->isEmpty())
                <div class="bg-gray-800 p-8 rounded-xl text-center border border-gray-700 shadow-lg animate-pulse-slow">
                    <i data-feather="frown" class="w-16 h-16 text-gray-500 mx-auto mb-6"></i>
                    <p class="text-gray-400 text-xl font-medium">No hay clases grupales disponibles en este momento.</p>
                    <p class="text-gray-500 text-md mt-3">¡Vuelve pronto para ver las nuevas adiciones y emocionantes sesiones!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($clases as $clase)
                        <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 flex flex-col transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:border-red-600 overflow-hidden">
                            {{-- REMOVIDO: Borde de estado de color. El verde ya no aparecerá aquí. --}}

                            <div class="p-6 flex-grow flex flex-col">
                                <h2 class="text-2xl font-bold text-gray-100 mb-2">{{ $clase->nombre }}</h2>
                                <p class="text-sm text-gray-400 mb-4">{{ Str::limit($clase->descripcion, 120) }}</p>

                                <div class="space-y-2 text-gray-300 text-sm mb-5">
                                    <p class="flex items-center gap-2">
                                        <i data-feather="calendar" class="w-4 h-4 text-red-600"></i>
                                        Inicio: <span class="font-semibold">{{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y H:i') }}</span>
                                    </p>
                                    <p class="flex items-center gap-2">
                                        <i data-feather="users" class="w-4 h-4 text-red-600"></i>
                                        Cupos: <span class="font-semibold">{{ $clase->usuarios()->wherePivot('estado', 'aceptado')->count() }} / {{ $clase->cupos_maximos }}</span>
                                    </p>
                                    <p class="flex items-center gap-2">
                                        <i data-feather="monitor" class="w-4 h-4 text-red-600"></i>
                                        Entrenador: <span class="font-semibold">{{ $clase->entrenador->name ?? 'N/A' }}</span>
                                    </p>
                                </div>

                                <div class="mt-auto pt-4 border-t border-gray-700 flex justify-between items-center">
                                    {{-- Etiqueta de estado de cupos. Esta sí usa el verde para "Disponible" --}}
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        @if (($clase->cupos_maximos - $clase->usuarios()->wherePivot('estado', 'aceptado')->count()) > ($clase->cupos_maximos / 2))
                                            bg-green-700 text-green-100
                                        @elseif (($clase->cupos_maximos - $clase->usuarios()->wherePivot('estado', 'aceptado')->count()) > 0)
                                            bg-yellow-600 text-yellow-100
                                        @else
                                            bg-red-700 text-red-100
                                        @endif
                                    ">
                                        @if (($clase->cupos_maximos - $clase->usuarios()->wherePivot('estado', 'aceptado')->count()) > ($clase->cupos_maximos / 2))
                                            Disponible
                                        @elseif (($clase->cupos_maximos - $clase->usuarios()->wherePivot('estado', 'aceptado')->count()) > 0)
                                            Pocos cupos
                                        @else
                                            Cupo Lleno
                                        @endif
                                    </span>

                                    {{-- Botones de acción --}}
                                    <div class="text-right space-y-2">
                                        @if($clase->expirada)
                                            <span class="text-gray-500 italic flex items-center gap-1">
                                                <i data-feather="calendar-off" class="w-4 h-4"></i>
                                                Clase expirada
                                            </span>
                                        @elseif($clase->inscrito)
                                            <span class="text-green-500 font-semibold flex items-center gap-1">
                                                <i data-feather="check-circle" class="w-4 h-4"></i>
                                                Ya inscrito
                                            </span>
                                        @elseif($clase->solicitud_pendiente)
                                            <span class="text-yellow-500 font-semibold flex items-center gap-1">
                                                <i data-feather="clock" class="w-4 h-4"></i>
                                                Solicitud pendiente
                                            </span>
                                        @elseif($clase->revocado)
                                            <span class="text-red-500 font-semibold flex items-center gap-1">
                                                <i data-feather="x-circle" class="w-4 h-4"></i>
                                                Acceso revocado
                                            </span>
                                        @elseif(($clase->cupos_maximos - $clase->usuarios()->wherePivot('estado', 'aceptado')->count()) <= 0)
                                            <span class="text-red-500 font-semibold flex items-center gap-1">
                                                <i data-feather="slash" class="w-4 h-4"></i>
                                                Sin cupos
                                            </span>
                                        @else
                                            <form method="POST" action="{{ route('cliente.clases.unirse', $clase) }}">
                                                @csrf
                                                <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-semibold flex items-center gap-1">
                                                    <i data-feather="plus-circle" class="w-4 h-4"></i>
                                                    Unirme
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                <div class="mt-10">
                    {{ $clases->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    {{-- Estilos y scripts para animaciones e iconos --}}
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

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
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        .animate-pulse-slow {
            animation: pulseSlow 3s infinite ease-in-out;
        }
    </style>
</x-app-layout>