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
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-2xl shadow">
                <h2 class="text-xl font-semibold text-indigo-800 mb-4">Resumen General</h2>
                <div class="text-sm text-indigo-600">
                    <p><strong>Total de Clases Activas:</strong> {{ $clases->count() }}</p>
                    <p><strong>Entrenamientos en Curso:</strong> {{ $entrenamientos->count() }}</p>
                    <p><strong>Suscripciones Activas:</strong> {{ $suscripciones->count() }}</p>
                </div>
            </div>

            <!-- Mis Clases -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow">
                <h2 class="text-xl font-semibold text-blue-800 mb-4">Mis Clases</h2>
                @forelse ($clases as $clase)
                    <div class="border-b border-blue-200 pb-2 mb-2">
                        <div class="text-blue-900 font-medium">{{ $clase->nombre }}</div>
                        <div class="text-sm text-blue-700">{{ $clase->descripcion }}</div>
                        <div class="text-sm text-blue-700">Fecha: {{ $clase->fecha_inicio }} - {{ $clase->fecha_fin }}
                        </div>
                        <!-- Botón de acción para editar clase -->
                        <a href="{{ route('entrenador.dashboard') }}" class="text-blue-500 hover:underline">Editar
                            Clase</a>
                    </div>
                @empty
                    <p class="text-blue-600">No tienes clases programadas.</p>
                @endforelse
            </div>

            <!-- Mis Entrenamientos -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow">
                <h2 class="text-xl font-semibold text-green-800 mb-4">Mis Entrenamientos</h2>
                @forelse ($entrenamientos as $entrenamiento)
                    <div class="border-b border-green-200 pb-2 mb-2">
                        <div class="text-green-900 font-medium">{{ $entrenamiento->nombre }}</div>
                        <div class="text-sm text-green-700">{{ $entrenamiento->descripcion }}</div>
                        <div class="text-sm text-green-700">Fecha: {{ $entrenamiento->fecha->format('d/m/Y') }}</div>
                        <!-- Botón de acción para ver detalles del entrenamiento -->
                        <a href="{{ route('entrenador.dashboard') }}" class="text-green-500 hover:underline">Ver
                            Detalles</a>
                    </div>
                @empty
                    <p class="text-green-600">No tienes entrenamientos asignados.</p>
                @endforelse
            </div>

            <!-- Suscripciones -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-2xl shadow">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">Suscripciones Activas</h2>
                @forelse ($suscripciones as $suscripcion)
                    <div class="border-b border-purple-200 pb-2 mb-2">
                        <div class="text-purple-900 font-medium">{{ $suscripcion->clase->nombre }}</div>
                        <div class="text-sm text-purple-700">
                            Suscrito el
                            @if ($suscripcion->created_at)
                                {{ $suscripcion->created_at->format('d/m/Y') }}
                            @else
                                <span class="text-red-500">Fecha no disponible</span>
                            @endif
                        </div>
                        <!-- Mostrar estado de la suscripción -->
                        <div class="text-sm text-purple-700">
                            Estado:
                            @if ($suscripcion->estaActiva())
                                <span class="text-green-500">Activa</span>
                            @else
                                <span class="text-red-500">Inactiva</span>
                            @endif
                        </div>
                        <!-- Botón para ver detalles de suscripción -->
                        <a href="{{ route('entrenador.dashboard') }}" class="text-purple-500 hover:underline">Ver
                            detalles</a>
                    </div>
                @empty
                    <p class="text-purple-600">No tienes suscripciones activas.</p>
                @endforelse
            </div>

        <!-- Calendario de Clases y Entrenamientos -->
        <div class="bg-white mt-8 p-6 rounded-2xl shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Calendario de Actividades</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Implementa tu calendario aquí -->
                <!-- Ejemplo básico con eventos próximos -->
                <div class="bg-gray-100 p-4 rounded-xl">
                    <h3 class="text-lg font-medium">Próximos Eventos</h3>
                    @foreach ($clases as $clase)
                        <div class="mt-2">
                            <strong>{{ $clase->nombre }}</strong><br>
                            Fecha: {{ $clase->fecha_inicio }} - {{ $clase->fecha_fin }}
                        </div>
                    @endforeach
                </div>
                <div class="bg-gray-100 p-4 rounded-xl">
                    <h3 class="text-lg font-medium">Próximos Entrenamientos</h3>
                    @foreach ($entrenamientos as $entrenamiento)
                        <div class="mt-2">
                            <strong>{{ $entrenamiento->nombre }}</strong><br>
                            Fecha: {{ $entrenamiento->fecha->format('d/m/Y') }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
