<!-- resources/views/entrenador/clases/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Clases') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Lista de Clases</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($clases as $clase)
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow">
                    <h3 class="text-xl font-semibold text-blue-800">{{ $clase->nombre }}</h3>
                    <p class="text-sm text-blue-700">{{ $clase->descripcion }}</p>
                    <p class="text-sm text-blue-700"><strong>Fecha:</strong> {{ $clase->fecha_inicio }} - {{ $clase->fecha_fin }}</p>
                    <p class="text-sm text-blue-700"><strong>Ubicación:</strong> {{ $clase->ubicacion }}</p>
                    <p class="text-sm text-blue-700"><strong>Cupos disponibles:</strong> {{ $clase->cupos_maximos }}</p>
                    <p class="text-sm text-blue-700"><strong>Duración estimada:</strong> {{ $clase->duracion }} minutos</p>

                    <!-- Botón de acción para editar clase -->
                    <a href="{{ route('entrenador.clase.edit', $clase->id_clase) }}" class="text-blue-500 hover:underline">Editar Clase</a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
