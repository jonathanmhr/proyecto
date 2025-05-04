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

        @if (session('incomplete_profile'))
            <div class="alert alert-warning">
                {{ session('incomplete_profile') }}
            </div>
        @endif

        <!-- Modal para completar el perfil -->
        @if ($incompleteProfile)
            <div id="profile-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">¡Tu perfil está incompleto!</h2>
                    <p class="text-gray-700 mb-4">Por favor, completa tus datos para acceder a las clases y
                        entrenamientos personalizados.</p>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('perfil.completar') }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg">Completar Perfil</a>
                        <button class="bg-gray-500 text-white px-4 py-2 rounded-lg"
                            onclick="closeModal()">Cerrar</button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Mostrar notificación de éxito -->
        @if (session('status') && session('status_type') == 'success')
            <div class="flex items-center bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Mostrar notificación de error -->
        @if (session('status') && session('status_type') == 'error')
            <div class="flex items-center bg-red-100 text-red-800 p-4 rounded-lg mb-4">
                <i data-feather="alert-triangle" class="w-5 h-5 mr-2"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif
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

            // Función para cerrar el modal
            function closeModal() {
                document.getElementById('profile-modal').style.display = 'none';
            }
        </script>
    @endpush
</x-app-layout>
