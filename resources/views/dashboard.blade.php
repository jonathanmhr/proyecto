<!-- Panel de Usuario -->

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

    <!-- Modal perfil incompleto -->
    @if ($incompleteProfile)
        <div id="profile-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">¡Tu perfil está incompleto!</h2>
                <p class="text-gray-700 mb-4">Por favor, completa tus datos para acceder a las clases y entrenamientos personalizados.</p>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('perfil.completar') }}" class="bg-teal-500 text-white px-4 py-2 rounded-lg">Completar Perfil</a>
                    <button class="bg-gray-500 text-white px-4 py-2 rounded-lg" onclick="closeModal()">Cerrar</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Mensajes de estado -->
    @if (session('status') && session('status_type') == 'success')
        <div class="flex items-center bg-green-200 text-green-800 p-4 rounded-lg mb-4">
            <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if (session('status') && session('status_type') == 'error')
        <div class="flex items-center bg-red-200 text-red-800 p-4 rounded-lg mb-4">
            <i data-feather="alert-triangle" class="w-5 h-5 mr-2"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <!-- Perfil Completo -->
    @if ($datosCompletos)
        <div class="bg-gradient-to-r from-cyan-700 to-cyan-500 p-6 rounded-2xl shadow mb-6">
            <h2 class="text-xl font-semibold text-cyan-200 mb-4 flex items-center gap-2">
                <i data-feather="user" class="w-5 h-5"></i> Mi Perfil
            </h2>
            <ul class="text-white space-y-2">
                <li><strong>Fecha de Nacimiento:</strong> {{ \Carbon\Carbon::parse($perfil->fecha_nacimiento)->format('d/m/Y') }}</li>
                <li><strong>Peso:</strong> {{ $perfil->peso }} kg</li>
                <li><strong>Altura:</strong> {{ $perfil->altura }} cm</li>
                <li><strong>Objetivo:</strong> {{ $perfil->objetivo }}</li>
                <li><strong>Nivel:</strong>
                    @switch($perfil->id_nivel)
                        @case(1) Principiante @break
                        @case(2) Intermedio @break
                        @case(3) Avanzado @break
                    @endswitch
                </li>
            </ul>
            <div class="mt-4">
                <a href="{{ route('perfil.editar') }}" class="bg-teal-600 text-white px-4 py-2 rounded-lg">Editar perfil</a>
            </div>
        </div>
    @endif

    <!-- Grilla Principal para Clases, Entrenamientos, Suscripciones -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <!-- Clases Inscritas -->
        <div class="lg:col-span-4 bg-gradient-to-r from-green-700 to-green-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500 group">
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
        <div class="lg:col-span-4 bg-gradient-to-r from-purple-700 to-purple-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500 group">
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
        <div class="lg:col-span-4 bg-gradient-to-r from-pink-700 to-pink-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500 group">
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
                                    Suscrito el {{ $suscripcion->created_at?->format('d/m/Y') ?? 'Sin fecha' }}
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

    <!-- Grilla para Notificaciones/Tienda (Izquierda) y Calendario (Derecha) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">
        <!-- Columna Izquierda: Notificaciones y Tienda -->
        <div class="lg:col-span-4 flex flex-col space-y-6">
            <!-- Notificaciones -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="bell" class="w-6 h-6 text-blue-600"></i> Notificaciones
                    </h2>
                    @if ($notificaciones->whereNull('read_at')->count() > 0)
                        <form action="{{ route('perfil.notificaciones.marcarTodasLeidas') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Marcar todas como leídas
                            </button>
                        </form>
                    @endif
                </div>

                @if ($notificaciones->isEmpty())
                    <p class="text-gray-600">No tienes notificaciones recientes.</p>
                @elseif ($notificaciones->whereNull('read_at')->count() === 0)
                    <p class="text-green-700 bg-green-100 p-4 rounded-lg flex items-center gap-2">
                        <i data-feather="check-circle" class="w-5 h-5"></i>
                        No tienes notificaciones pendientes.
                    </p>
                @else
                    <ul class="space-y-4">
                        @foreach ($notificaciones as $notificacion)
                            <li class="flex items-start justify-between gap-4 p-4 rounded-lg border {{ !$notificacion->read_at ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <i data-feather="mail" class="w-5 h-5 {{ !$notificacion->read_at ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                        <span class="font-medium text-gray-800">{{ $notificacion->data['mensaje'] ?? 'Sin mensaje' }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500">{{ $notificacion->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    @if (!$notificacion->read_at)
                                        <form action="{{ route('perfil.notificaciones.marcarLeida', $notificacion->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm text-blue-600 hover:underline hover:text-blue-800">Marcar como leída</button>
                                        </form>
                                    @else
                                        <span class="inline-block text-xs bg-gray-300 text-white px-2 py-1 rounded">Leída</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Tienda -->
            <div>
                <a href="{{ route('tienda.index') }}" class="block group">
                    <div class="bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl hover:bg-red-600 transition-all duration-200 ease-in-out transform hover:-translate-y-1 p-6 cursor-pointer">
                        <div class="flex flex-col items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-red-600 mb-4 group-hover:text-white transition-colors duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h1 class="text-3xl font-semibold text-red-600 group-hover:text-white transition-colors duration-150">Tienda</h1>
                            <p class="text-sm text-gray-400 mt-1 group-hover:text-gray-100 transition-colors duration-150">Explorar productos</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Columna Derecha: Calendario de Clases -->
        <div class="lg:col-span-8">
            @if ($datosCompletos)
                <div class="bg-gray-800 p-6 rounded-2xl shadow-lg">
                    <h2 class="text-xl font-semibold text-red-400 mb-4 flex items-center gap-2">
                        <i data-feather="calendar" class="w-5 h-5"></i> Calendario de Clases
                    </h2>
                    <div id="calendar" class="bg-gray-100 rounded-lg p-4 text-gray-800"></div>
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

    <script id="eventos-clases-data" type="application/json">
        {!! json_encode($clases->map(function($clase) {
            return [
                'title' => $clase->nombre,
                'start' => optional($clase->fecha_inicio)->toDateString(),
                'tipo' => 'Clase Grupal',
                'description' => $clase->descripcion,
            ];
        })) !!}
    </script>

    <script>
        try {
            window.eventosClases = JSON.parse(document.getElementById('eventos-clases-data').textContent);
        } catch (e) {
            window.eventosClases = [];
            console.error('Error parseando eventos clases JSON:', e);
        }
    </script>
@endpush
</x-app-layout>
