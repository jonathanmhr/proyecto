<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Clases') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Mis Clases</h1>
            <a href="{{ route('entrenador.dashboard') }}" 
                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <div class="space-y-6">
            @foreach ($clases as $clase)
                <div class="bg-white border border-gray-300 rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-2">{{ $clase->nombre }}</h3>
                    <p class="text-sm text-gray-700 mb-2">{{ $clase->descripcion }}</p>
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Fecha:</strong> {{ $clase->fecha_inicio }} - {{ $clase->fecha_fin }}
                    </div>
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Ubicación:</strong> {{ $clase->ubicacion }}
                    </div>
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Cupos disponibles:</strong> {{ $clase->cupos_maximos }}
                    </div>
                    <div class="text-sm text-gray-600 mb-4">
                        <strong>Duración estimada:</strong> {{ $clase->duracion }} minutos
                    </div>

                    @if ($clase->cambio_pendiente)
                        <div class="text-yellow-500 text-sm mb-4">
                            <strong>Estado:</strong> Cambios pendientes de aprobación
                        </div>
                    @endif

                    <a href="{{ route('entrenador.clases.edit', $clase->id_clase) }}"
                        class="text-blue-600 hover:text-blue-800 font-semibold">Editar Clase</a>

                    <!-- Enlace para gestionar alumnos -->
                    <div class="mt-4">
                        <a href="{{ route('entrenador.clases.alumnos', $clase->id_clase) }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold">Gestionar Alumnos</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
