<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Mis Clases') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white">Mis Clases</h1>
            <a href="{{ route('admin-entrenador.dashboard') }}" {{-- Assuming this is the correct route for the trainer's dashboard --}}
                class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <div class="space-y-6">
            @forelse ($clases as $clase)
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:shadow-xl hover:bg-gray-700 transition-all duration-300 transform hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-red-400 mb-2">{{ $clase->nombre }}</h3>
                    <p class="text-sm text-gray-300 mb-2">{{ $clase->descripcion }}</p>
                    <div class="text-sm text-gray-400 mb-2">
                        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($clase->fecha_fin)->format('d/m/Y') }}
                    </div>
                    <div class="text-sm text-gray-400 mb-2">
                        <strong>Ubicación:</strong> {{ $clase->ubicacion }}
                    </div>
                    <div class="text-sm text-gray-400 mb-2">
                        <strong>Cupos disponibles:</strong> {{ $clase->cupos_maximos }}
                    </div>
                    <div class="text-sm text-gray-400 mb-4">
                        <strong>Duración estimada:</strong> {{ $clase->duracion }} minutos
                    </div>

                    @if ($clase->cambio_pendiente)
                        <div class="text-yellow-100 bg-yellow-600 rounded-full px-3 py-1 text-xs font-bold inline-block mb-4">
                            <strong>Estado:</strong> Cambios pendientes de aprobación
                        </div>
                    @else
                        <div class="text-green-100 bg-green-600 rounded-full px-3 py-1 text-xs font-bold inline-block mb-4">
                            <strong>Estado:</strong> Clase Aceptada
                        </div>
                    @endif

                    <div class="flex flex-wrap gap-3 mt-4"> {{-- Use flex-wrap and gap for buttons --}}
                        <a href="{{ route('admin-entrenador.clases.edit', $clase->id_clase) }}" {{-- Changed to admin-entrenador route --}}
                            class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                            Editar Clase
                        </a>

                        <a href="{{ route('admin-entrenador.clases.alumnos', $clase->id_clase) }}" {{-- Changed to admin-entrenador route --}}
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                            Gestionar Alumnos
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-8">No tienes clases programadas en este momento.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
