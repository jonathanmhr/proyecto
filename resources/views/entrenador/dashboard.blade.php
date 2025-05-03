<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel del Entrenador') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            👋 ¡Bienvenido de nuevo, {{ auth()->user()->name }}!
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Resumen General -->
            <div class="bg-gradient-to-br from-indigo-200 to-indigo-400 p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold text-indigo-800 mb-4">Resumen General</h2>
                <div class="text-sm text-indigo-700">
                    <p><strong>Total de Clases Activas:</strong> {{ $clases->count() }}</p>
                    <p><strong>Entrenamientos en Curso:</strong> {{ $entrenamientos->count() }}</p>
                    <p><strong>Suscripciones Activas:</strong> {{ $suscripciones->count() }}</p>
                </div>
            </div>

            <!-- Mis Clases -->
            <div class="bg-gradient-to-br from-blue-200 to-blue-400 p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold text-blue-800 mb-4">Mis Clases</h2>
                @forelse ($clases as $clase)
                    <div class="border-b border-blue-300 pb-2 mb-2">
                        <div class="text-blue-900 font-medium">{{ $clase->nombre }}</div>
                        <div class="text-sm text-blue-700">{{ $clase->descripcion }}</div>
                        <div class="text-sm text-blue-700">Fecha: {{ $clase->fecha_inicio }} - {{ $clase->fecha_fin }}</div>
                        <p class="text-sm text-blue-700">
                            @if ($clase->cambio_pendiente)
                                <span class="text-yellow-600 font-bold">Cambio Pendiente de Aprobación</span>
                            @else
                                <span class="text-green-600 font-bold">Clase Aceptada</span>
                            @endif
                        </p>
                        <a href="{{ route('entrenador.clases.index') }}" class="text-blue-500 hover:underline">Editar clase</a>
                    </div>
                @empty
                    <p class="text-blue-600">No tienes clases programadas.</p>
                @endforelse
                <div class="mt-4">
                    <a href="{{ route('entrenador.clases.index') }}" class="text-blue-500 hover:underline">Ver todas mis clases</a>
                </div>
            </div>

            <!-- Mis Entrenamientos -->
            <div class="bg-gradient-to-br from-green-200 to-green-400 p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold text-green-800 mb-4">Mis Entrenamientos</h2>
                @forelse ($entrenamientos as $entrenamiento)
                    <div class="border-b border-green-300 pb-2 mb-2">
                        <div class="text-green-900 font-medium">{{ $entrenamiento->nombre }}</div>
                        <div class="text-sm text-green-700">Tipo: {{ $entrenamiento->tipo }}</div>
                        <div class="text-sm text-green-700">Duración: {{ $entrenamiento->duracion }} minutos</div>
                        <div class="text-sm text-green-700">Fecha: {{ $entrenamiento->fecha }}</div>
                    </div>
                @empty
                    <p class="text-green-600">No tienes entrenamientos programados.</p>
                @endforelse
            </div>

            <!-- Mis Reservas y Estado de Solicitudes -->
            <div class="bg-gradient-to-br from-yellow-200 to-yellow-400 p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold text-yellow-800 mb-4">Mis Reservas y Estado de Solicitudes</h2>
                @forelse ($reservas as $reserva)
                    <div class="border-b border-yellow-300 pb-2 mb-2">
                        <div class="text-yellow-900 font-medium">{{ $reserva->clase->nombre }} (Reserva para: {{ $reserva->usuario->name }})</div>
                        <div class="text-sm text-yellow-700">
                            Estado de la Reserva:
                            @if ($reserva->estado == 'pendiente')
                                <span class="text-yellow-600">Pendiente</span>
                            @elseif($reserva->estado == 'aceptada')
                                <span class="text-green-600">Aceptada</span>
                            @else
                                <span class="text-red-600">Rechazada</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-yellow-600">No tienes reservas para clases.</p>
                @endforelse
            </div>

            <!-- Solicitudes Pendientes -->
            <div class="bg-gradient-to-br from-teal-200 to-teal-400 p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold text-teal-800 mb-4">Solicitudes Pendientes</h2>
                @if ($solicitudesPendientes->count() > 0)
                    <p class="text-sm text-teal-600">
                        Tienes {{ $solicitudesPendientes->count() }} solicitud(es) pendiente(s).
                    </p>
                    <a href="{{ route('solicitudes.index') }}" class="text-teal-500 hover:underline">Ver Solicitudes Pendientes</a>
                @else
                    <p class="text-sm text-teal-600">
                        No tienes solicitudes pendientes.
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
