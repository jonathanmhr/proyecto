<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel del Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            <!-- Clases Grupales -->
            <div class="bg-white p-6 rounded-2xl shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">Clases Grupales</h3>
                    <a href="{{ route('cliente.clases.index') }}"
                       class="text-blue-600 hover:underline">Ver todas</a>
                </div>

                @if($clases->isEmpty())
                    <p class="text-gray-500">No hay clases disponibles actualmente.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($clases as $clase)
                            <div class="bg-gray-100 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold text-gray-700">{{ $clase->nombre }}</h4>
                                <p class="text-sm text-gray-600">{{ Str::limit($clase->descripcion, 100) }}</p>
                                <p class="text-sm text-gray-500 mt-2">Inicio: {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-500">Cupos: {{ $clase->cupos_maximos }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Entrenamientos -->
            <div class="bg-white p-6 rounded-2xl shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">Entrenamientos</h3>
                    <a href="{{ route('cliente.entrenamientos.index') }}"
                       class="text-blue-600 hover:underline">Ver todos</a>
                </div>

                @if($entrenamientos->isEmpty())
                    <p class="text-gray-500">No hay entrenamientos disponibles actualmente.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($entrenamientos as $entrenamiento)
                            <div class="bg-gray-100 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold text-gray-700">{{ $entrenamiento->nombre }}</h4>
                                <p class="text-sm text-gray-600">Tipo: {{ $entrenamiento->tipo }}</p>
                                <p class="text-sm text-gray-500 mt-2">Duración: {{ $entrenamiento->duracion }} min</p>
                                <p class="text-sm text-gray-500">Fecha: {{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y') }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
