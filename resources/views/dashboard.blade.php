<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Usuario') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            👋 ¡Bienvenido de nuevo, {{ auth()->user()->name }}!
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Clases Inscritas -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow">
                <h2 class="text-xl font-semibold text-blue-800 mb-4 flex items-center gap-2">
                    <i data-feather="book-open" class="w-5 h-5"></i> Clases Inscritas
                </h2>
                @forelse ($clases as $clase)
                    <div class="border-b border-blue-200 pb-2 mb-2">
                        <div class="text-blue-900 font-medium">{{ $clase->nombre }}</div>
                        <div class="text-sm text-blue-700">{{ $clase->descripcion }}</div>
                    </div>
                @empty
                    <p class="text-blue-600">No estás inscrito en ninguna clase por ahora.</p>
                @endforelse
            </div>

            <!-- Entrenamientos -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow">
                <h2 class="text-xl font-semibold text-green-800 mb-4 flex items-center gap-2">
                    <i data-feather="activity" class="w-5 h-5"></i> Entrenamientos
                </h2>
                @forelse ($entrenamientos as $entrenamiento)
                    <div class="border-b border-green-200 pb-2 mb-2">
                        <div class="text-green-900 font-medium">{{ $entrenamiento->nombre }}</div>
                        <div class="text-sm text-green-700">{{ $entrenamiento->descripcion }}</div>
                    </div>
                @empty
                    <p class="text-green-600">No tienes entrenamientos asignados.</p>
                @endforelse
            </div>

            <!-- Suscripciones -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-2xl shadow">
                <h2 class="text-xl font-semibold text-purple-800 mb-4 flex items-center gap-2">
                    <i data-feather="calendar" class="w-5 h-5"></i> Suscripciones Activas
                </h2>
                @forelse ($suscripciones as $suscripcion)
                    @if ($suscripcion->clase)
                        <div class="border-b border-purple-200 pb-2 mb-2">
                            <div class="text-purple-900 font-medium">{{ $suscripcion->clase->nombre }}</div>
                            <div class="text-sm text-purple-700">
                                @if ($suscripcion->created_at)
                                    Suscrito el {{ $suscripcion->created_at->format('d/m/Y') }}
                                @else
                                    Suscripción sin fecha
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-sm text-red-500">❌ Clase eliminada de una suscripción anterior.</div>
                    @endif
                @empty
                    <p class="text-purple-600">Aún no tienes suscripciones.</p>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            feather.replace(); // Para íconos
        </script>
    @endpush
</x-app-layout>
