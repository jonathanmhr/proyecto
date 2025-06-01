<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Panel del Entrenador') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <h1 class="font-extrabold text-4xl text-white mb-8 animate-fade-in-down tracking-wide">
            👋 ¡Bienvenido de nuevo, <span class="text-red-500">{{ auth()->user()->name }}</span>!
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"> {{-- Increased gap for better spacing --}}
            <div class="bg-gradient-to-br from-blue-900 to-blue-700 p-8 rounded-3xl shadow-xl border border-blue-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-blue-200 mb-4 flex items-center gap-3">
                    <i data-feather="info" class="w-7 h-7 text-blue-300 group-hover:rotate-6 transition-transform"></i>
                    Resumen General
                </h2>
                <div class="text-base text-blue-100 space-y-2">
                    <p><strong>Total de Clases Activas:</strong> <span class="font-semibold">{{ $clases->count() }}</span></p>
                    <p><strong>Entrenamientos en Curso:</strong> <span class="font-semibold">{{ $entrenamientos->count() }}</span></p>
                    <p><strong>Suscripciones Activas:</strong> <span class="font-semibold">{{ $suscripciones->count() }}</span></p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-900 to-purple-700 p-8 rounded-3xl shadow-xl border border-purple-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-purple-200 mb-4 flex items-center gap-3">
                    <i data-feather="book-open" class="w-7 h-7 text-purple-300 group-hover:scale-110 transition-transform"></i>
                    Mis Clases
                </h2>
                @forelse ($clases as $clase)
                    <div class="border-b border-purple-600 pb-3 mb-3 last:border-b-0">
                        <div class="text-white font-semibold text-lg">{{ $clase->nombre }}</div>
                        <div class="text-sm text-purple-100 opacity-90">{{ $clase->descripcion }}</div>
                        <div class="text-sm text-purple-100 opacity-90">Fecha: {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($clase->fecha_fin)->format('d/m/Y') }}</div>
                        <p class="text-sm text-purple-100 mt-2">
                            @if ($clase->cambio_pendiente)
                                <span class="bg-yellow-600 text-yellow-100 font-bold rounded-full px-3 py-1 text-xs">Cambio Pendiente</span>
                            @else
                                <span class="bg-green-600 text-green-100 font-bold rounded-full px-3 py-1 text-xs">Clase Aceptada</span>
                            @endif
                        </p>
                        <a href="{{ route('admin-entrenador.clases.edit', $clase) }}" {{-- Changed to admin-entrenador route --}}
                            class="inline-flex items-center text-blue-400 hover:text-blue-500 font-medium mt-2 transition-colors duration-200 text-sm">
                            Editar clase <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-purple-100 opacity-80 mb-6 text-sm animate-pulse">No tienes clases programadas.</p>
                @endforelse
                <div class="mt-4">
                    <a href="{{ route('admin-entrenador.clases.index') }}" {{-- Changed to admin-entrenador route --}}
                        class="inline-flex items-center text-blue-400 hover:text-blue-500 font-medium transition-colors duration-200">
                        Ver todas mis clases <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-900 to-green-700 p-8 rounded-3xl shadow-xl border border-green-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-green-200 mb-4 flex items-center gap-3">
                    <i data-feather="activity" class="w-7 h-7 text-green-300 group-hover:animate-bounce-icon transition-transform"></i>
                    Mis Entrenamientos
                </h2>
                @forelse ($entrenamientos as $entrenamiento)
                    <div class="border-b border-green-600 pb-3 mb-3 last:border-b-0">
                        <div class="text-white font-semibold text-lg">{{ $entrenamiento->nombre }}</div>
                        <div class="text-sm text-green-100 opacity-90">Tipo: {{ $entrenamiento->tipo }}</div>
                        <div class="text-sm text-green-100 opacity-90">Duración: {{ $entrenamiento->duracion }} minutos</div>
                        <div class="text-sm text-green-100 opacity-90">Fecha: {{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y') }}</div>
                        <a href="{{ route('admin-entrenador.entrenamientos.edit', $entrenamiento->id_entrenamiento) }}" {{-- Changed to admin-entrenador route --}}
                            class="inline-flex items-center text-blue-400 hover:text-blue-500 font-medium mt-2 transition-colors duration-200 text-sm">
                            Editar entrenamiento <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-green-100 opacity-80 mb-6 text-sm animate-pulse">No tienes entrenamientos programados.</p>
                @endforelse
                <div class="mt-4">
                    <a href="{{ route('admin-entrenador.entrenamientos.index') }}" {{-- Changed to admin-entrenador route --}}
                        class="inline-flex items-center text-blue-400 hover:text-blue-500 font-medium transition-colors duration-200">
                        Ver todos mis entrenamientos <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-900 to-red-700 p-8 rounded-3xl shadow-xl border border-red-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-red-200 mb-4 flex items-center gap-3">
                    <i data-feather="bell" class="w-7 h-7 text-red-300 group-hover:animate-shake transition-transform"></i>
                    Solicitudes Pendientes
                </h2>
                @if ($solicitudesPendientes->count() > 0)
                    <p class="text-red-100 mb-4 text-base">
                        Tienes <span class="font-bold text-red-500">{{ $solicitudesPendientes->count() }}</span> solicitud(es) de clase pendiente(s) de aprobación.
                    </p>
                    <a href="{{ route('admin-entrenador.solicitudes.index') }}"
                        class="inline-flex items-center bg-red-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-red-700 transition-all duration-300 shadow-md text-sm">
                        Gestionar Solicitudes <i data-feather="arrow-right" class="inline-block ml-2 w-5 h-5"></i>
                    </a>
                @else
                    <p class="text-red-100 opacity-80 mb-6 text-sm animate-pulse">
                        No tienes solicitudes de clase pendientes.
                    </p>
                @endif
            </div>

            {{-- Mis Reservas y Estado de Solicitudes (Bloque original, movido y estilizado) --}}
            {{-- Este bloque parece ser más para el lado del cliente, no del entrenador.
                 Si el entrenador necesita ver sus propias reservas (ej. a clases de otros entrenadores),
                 entonces se mantendría. Si son reservas de usuarios a sus clases,
                 el bloque de "Solicitudes Pendientes" es más adecuado.
                 Lo he movido y estilizado por si es relevante para el entrenador. --}}
            <div class="bg-gradient-to-br from-yellow-900 to-yellow-700 p-8 rounded-3xl shadow-xl border border-yellow-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-yellow-200 mb-4 flex items-center gap-3">
                    <i data-feather="calendar" class="w-7 h-7 text-yellow-300 group-hover:rotate-3 transition-transform"></i>
                    Mis Reservas
                </h2>
                @forelse ($reservas as $reserva)
                    <div class="border-b border-yellow-600 pb-3 mb-3 last:border-b-0">
                        <div class="text-white font-semibold text-lg">{{ $reserva->clase->nombre }}</div>
                        <div class="text-sm text-yellow-100 opacity-90">
                            Reservado por: {{ $reserva->usuario->name }}
                        </div>
                        <div class="text-sm text-yellow-100 mt-1">
                            Estado:
                            @if ($reserva->estado == 'pendiente')
                                <span class="bg-yellow-500 text-white rounded-full px-2 py-0.5 text-xs font-bold">Pendiente</span>
                            @elseif($reserva->estado == 'aceptada')
                                <span class="bg-green-500 text-white rounded-full px-2 py-0.5 text-xs font-bold">Aceptada</span>
                            @else
                                <span class="bg-red-500 text-white rounded-full px-2 py-0.5 text-xs font-bold">Rechazada</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-yellow-100 opacity-80 mb-6 text-sm animate-pulse">No tienes reservas de usuarios para tus clases.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
