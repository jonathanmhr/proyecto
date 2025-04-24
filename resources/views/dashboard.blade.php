<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">
            ¡Bienvenido de nuevo, {{ auth()->user()->name }}!
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Clases Inscritas -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Clases Inscritas</h2>
                <ul class="space-y-4">
                    @foreach ($clases as $clase)
                        <li class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <span class="text-gray-700">{{ $clase->nombre }}</span>
                            <span class="text-sm text-gray-500">{{ $clase->descripcion }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Entrenamientos -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Entrenamientos</h2>
                <ul class="space-y-4">
                    @foreach ($entrenamientos as $entrenamiento)
                        <li class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <span class="text-gray-700">{{ $entrenamiento->nombre }}</span>
                            <span class="text-sm text-gray-500">{{ $entrenamiento->descripcion }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Suscripciones -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Suscripciones</h2>
                <ul class="space-y-4">
                    @foreach ($suscripciones as $suscripcion)
                        <li class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <span class="text-gray-700">{{ $suscripcion->clase->nombre }}</span>
                            <span class="text-sm text-gray-500">{{ $suscripcion->created_at->format('d/m/Y') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
