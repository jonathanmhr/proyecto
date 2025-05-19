<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Panel de Usuario') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-black mb-6">
            👋 ¡Bienvenido de nuevo, {{ auth()->user()->name }}!
        </h1>

        @if (session('incomplete_profile'))
            <div class="alert alert-warning bg-yellow-200 text-yellow-800 p-4 rounded-lg mb-4">
                {{ session('incomplete_profile') }}
            </div>
        @endif

        <!-- Modal para completar el perfil -->
        @if ($incompleteProfile)
            <div id="profile-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50"
                style="display: flex;">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">¡Tu perfil está incompleto!</h2>
                    <p class="text-gray-700 mb-4">Por favor, completa tus datos para acceder a las clases y
                        entrenamientos personalizados.</p>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('perfil.completar') }}"
                            class="bg-teal-500 text-white px-4 py-2 rounded-lg">Completar Perfil</a>
                        <button class="bg-gray-500 text-white px-4 py-2 rounded-lg"
                            onclick="closeModal()">Cerrar</button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Mostrar notificación de éxito -->
        @if (session('status') && session('status_type') == 'success')
            <div class="flex items-center bg-green-200 text-green-800 p-4 rounded-lg mb-4">
                <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Mostrar notificación de error -->
        @if (session('status') && session('status_type') == 'error')
            <div class="flex items-center bg-red-200 text-red-800 p-4 rounded-lg mb-4">
                <i data-feather="alert-triangle" class="w-5 h-5 mr-2"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($datosCompletos)
            <div class="bg-gradient-to-r from-cyan-700 to-cyan-500 p-6 rounded-2xl shadow mb-6">
                <h2 class="text-xl font-semibold text-cyan-200 mb-4 flex items-center gap-2">
                    <i data-feather="user" class="w-5 h-5"></i> Mi Perfil
                </h2>
                <ul class="text-white space-y-2">
                    <li><strong>Fecha de Nacimiento:</strong>
                        {{ \Carbon\Carbon::parse($perfil->fecha_nacimiento)->format('d/m/Y') }}</li>
                    <li><strong>Peso:</strong> {{ $perfil->peso }} kg</li>
                    <li><strong>Altura:</strong> {{ $perfil->altura }} cm</li>
                    <li><strong>Objetivo:</strong> {{ $perfil->objetivo }}</li>
                    <li><strong>Nivel:</strong>
                        @switch($perfil->id_nivel)
                            @case(1)
                                Principiante
                            @break

                            @case(2)
                                Intermedio
                            @break

                            @case(3)
                                Avanzado
                            @break
                        @endswitch
                    </li>
                </ul>
                <div class="mt-4">
                    <a href="{{ route('perfil.editar') }}" class="bg-teal-600 text-white px-4 py-2 rounded-lg">Editar
                        perfil</a>
                </div>
            </div>
        @endif


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Clases Inscritas -->
            <div class="bg-gradient-to-r from-green-700 to-green-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500 group">
                <h2 class="text-xl font-semibold text-lime-100 mb-4 flex items-center gap-2">
                    <i data-feather="book-open" class="w-5 h-5"></i> Clases Inscritas
                </h2>

                @if ($clases->isEmpty())
                    <p class="text-white animate-fade-in">No estás inscrito en ninguna clase por ahora.</p>
                @else
                    <div class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100">
                        @foreach ($clases as $clase)
                            <div class="border-b border-teal-200 pb-2 mb-2">
                                <div class="text-white font-medium">{{ $clase->nombre }}</div>
                                <div class="text-sm text-white">{{ $clase->descripcion }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Entrenamientos -->
            <div class="group bg-gradient-to-r from-purple-700 to-purple-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500">
                <h2 class="text-xl font-semibold text-purple-200 mb-4 flex items-center gap-2">
                    <i data-feather="activity" class="w-5 h-5"></i> Entrenamientos
                </h2>

                @if ($entrenamientos->isEmpty())
                    <p class="text-white animate-fade-in">No tienes entrenamientos asignados.</p>
                @else
                    <div class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100">
                        @foreach ($entrenamientos as $entrenamiento)
                            <div class="border-b border-purple-200 pb-2 mb-2">
                                <div class="text-white font-medium">{{ $entrenamiento->nombre }}</div>
                                <div class="text-sm text-white">{{ $entrenamiento->descripcion }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Suscripciones -->
            <div class="group bg-gradient-to-r from-pink-700 to-pink-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500">
                <h2 class="text-xl font-semibold text-pink-200 mb-4 flex items-center gap-2">
                    <i data-feather="calendar" class="w-5 h-5"></i> Suscripciones Activas
                </h2>

                @if ($suscripciones->isEmpty())
                    <p class="text-white animate-fade-in">Aún no tienes suscripciones.</p>
                @else
                    <div class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100">
                        @foreach ($suscripciones as $suscripcion)
                            @if ($suscripcion->clase)
                                <div class="border-b border-pink-200 pb-2 mb-2">
                                    <div class="text-white font-medium">{{ $suscripcion->clase->nombre }}</div>
                                    <div class="text-sm text-white">
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
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            feather.replace();

            function closeModal() {
                document.getElementById('profile-modal').style.display = 'none';
            }
        </script>
    @endpush
</x-app-layout>
