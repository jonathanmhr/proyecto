<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Clases') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Lista de Clases</h1>

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

                    <a href="{{ route('entrenador.clases.edit', $clase->id_clase) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Editar Clase</a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
