<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Panel del Entrenador') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con el color de fondo exacto #111828 --}}
    <div class="container mx-auto px-4 py-12 bg-[#111828] text-gray-100 min-h-screen">
        <h1 class="font-extrabold text-5xl md:text-6xl text-white mb-12 text-center md:text-left tracking-tight leading-tight animate-fade-in-down">
            👋 ¡Bienvenido de nuevo, <span class="text-red-500 block md:inline-block mt-2 md:mt-0">{{ auth()->user()->name }}</span>!
        </h1>

        

        {{-- Sección de Acciones Rápidas (Ahora dentro de un bloque con el nuevo fondo grisáceo) --}}
        <div class="mb-14 p-8 rounded-2xl shadow-xl bg-[#1A2234] border border-[#2A344D]">
            <h2 class="text-3xl font-extrabold text-[#F3F4F6] mb-8 flex items-center gap-4">
                <i data-feather="zap" class="w-8 h-8 text-yellow-400 animate-flash"></i>
                Acciones Rápidas
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                {{-- Botón Crear Nueva Clase (Rojo como en la imagen) --}}
                <a href="{{ route('entrenador.clases-individuales.create') }}"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-red-600 to-red-800 rounded-xl shadow-lg border border-red-700 hover:shadow-red-500/50 hover:-translate-y-1 transition-all duration-300 transform group">
                    <i data-feather="plus-circle" class="w-10 h-10 text-white mb-3 group-hover:scale-110 transition-transform"></i>
                    <span class="text-lg font-bold text-white text-center">Crear Nueva Clase</span>
                </a>
                {{-- Botón Crear Entrenamiento (Azul como en la imagen) --}}
                <a href="{{ route('entrenador.entrenamientos.create') }}"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl shadow-lg border border-blue-700 hover:shadow-blue-500/50 hover:-translate-y-1 transition-all duration-300 transform group">
                    <i data-feather="plus-circle" class="w-10 h-10 text-white mb-3 group-hover:scale-110 transition-transform"></i>
                    <span class="text-lg font-bold text-white text-center">Crear Entrenamiento</span>
                </a>
                {{-- Botón Gestionar Solicitudes (Púrpura como en la imagen) --}}
                <a href="{{ route('entrenador.solicitudes.index') }}"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl shadow-lg border border-purple-700 hover:shadow-purple-500/50 hover:-translate-y-1 transition-all duration-300 transform group">
                    <i data-feather="bell" class="w-10 h-10 text-white mb-3 group-hover:animate-shake-quick transition-transform"></i>
                    <span class="text-lg font-bold text-white text-center">Gestionar Solicitudes</span>
                </a>
                {{-- Botón Ver Reservas (Amarillo/Naranja como en la imagen) --}}
                <a href="{{ route('entrenador.solicitudes.index') }}"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-xl shadow-lg border border-yellow-700 hover:shadow-yellow-500/50 hover:-translate-y-1 transition-all duration-300 transform group">
                    <i data-feather="calendar" class="w-10 h-10 text-white mb-3 group-hover:rotate-6 transition-transform"></i>
                    <span class="text-lg font-bold text-white text-center">Ver Reservas</span>
                </a>
                {{-- Botón Mi Perfil (Gris/Azul oscuro como en la imagen) --}}
                <a href="{{ route('profile.show') }}"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl shadow-lg border border-gray-800 hover:shadow-gray-500/50 hover:-translate-y-1 transition-all duration-300 transform group">
                    <i data-feather="user" class="w-10 h-10 text-white mb-3 group-hover:scale-110 transition-transform"></i>
                    <span class="text-lg font-bold text-white text-center">Mi Perfil</span>
                </a>
            </div>
        </div>

        

        {{-- Grid principal de Tarjetas (Resto de la información) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-8 rounded-2xl shadow-xl bg-[#1A2234] border border-[#2A344D]">
            {{-- Tarjeta 1: Resumen General (Azul como en la imagen) --}}
            <div class="bg-gradient-to-br from-blue-800 to-blue-600 p-8 rounded-2xl shadow-2xl border border-blue-700 hover:shadow-blue-500/50 transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-3xl font-extrabold text-[#F3F4F6] mb-6 flex items-center gap-4">
                    <i data-feather="info" class="w-8 h-8 text-blue-300 group-hover:rotate-6 transition-transform"></i>
                    Resumen General
                </h2>
                <div class="text-lg text-blue-100 space-y-4">
                    <p class="flex justify-between items-center">
                        <span class="opacity-90">Total de Clases Activas:</span>
                        <span class="font-bold text-3xl text-blue-300">{{ $clases->count() }}</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span class="opacity-90">Entrenamientos en Curso:</span>
                        <span class="font-bold text-3xl text-blue-300">{{ $entrenamientos->count() }}</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span class="opacity-90">Suscripciones Activas:</span>
                        <span class="font-bold text-3xl text-blue-300">{{ $suscripciones->count() }}</span>
                    </p>
                </div>
            </div>

            {{-- Tarjeta 2: Mis Clases (Púrpura como en la imagen, con solo fecha de inicio) --}}
            <div class="bg-gradient-to-br from-purple-800 to-purple-600 p-8 rounded-2xl shadow-2xl border border-purple-700 hover:shadow-purple-500/50 transition-all duration-500 transform hover:-translate-y-2 group col-span-1 md:col-span-2 lg:col-span-1">
                <h2 class="text-3xl font-extrabold text-[#F3F4F6] mb-6 flex items-center gap-4">
                    <i data-feather="book-open" class="w-8 h-8 text-purple-300 group-hover:scale-110 transition-transform"></i>
                    Mis Clases
                </h2>
                <div class="space-y-6">
                    {{-- Mostrar solo las primeras 2 clases --}}
                    @forelse ($clases->take(2) as $clase)
                        <div class="border-b border-purple-700 pb-6 last:border-b-0">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $clase->nombre }}</h3>
                            <p class="text-sm text-purple-100 opacity-90">
                                <span class="font-semibold">Inicia:</span>
                                {{Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }}
                            </p>
                            <a href="{{ route('entrenador.clases-individuales.edit', $clase->id_clase) }}"
                                class="inline-flex items-center text-blue-300 hover:text-blue-200 font-medium mt-4 transition-colors duration-200 text-sm group">
                                Editar clase
                                <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-purple-100 opacity-80 text-base italic">Aún no tienes clases programadas. ¡Es hora de crear la primera!</p>
                    @endforelse

                    {{-- Mostrar mensaje si hay más de 2 clases --}}
                    @if ($clases->count() > 2)
                        <p class="text-purple-200 text-sm mt-4 italic">
                            Tienes **{{ $clases->count() - 2 }}** clase(s) más.
                        </p>
                    @endif

                    <a href="{{ route('entrenador.clases-individuales.create') }}" class="mt-8 inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-purple-700 transition-all duration-300 shadow-md text-base">
                        <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                        Crear Nueva Clase
                    </a>
                </div>
                <div class="mt-6">
                    <a href="{{ route('entrenador.clases.index') }}"
                        class="inline-flex items-center text-blue-300 hover:text-blue-200 font-medium transition-colors duration-200 group">
                        Ver todas mis clases
                        <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            {{-- Tarjeta 3: Mis Entrenamientos (Verde como en la imagen) --}}
            <div class="bg-gradient-to-br from-green-800 to-green-600 p-8 rounded-2xl shadow-2xl border border-green-700 hover:shadow-green-500/50 transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-3xl font-extrabold text-[#F3F4F6] mb-6 flex items-center gap-4">
                    <i data-feather="activity" class="w-8 h-8 text-green-300 group-hover:animate-bounce-icon transition-transform"></i>
                    Mis Entrenamientos
                </h2>
                <div class="space-y-6">
                    {{-- Mostrar solo los primeros 3 entrenamientos --}}
                    @forelse ($entrenamientos->take(3) as $entrenamiento)
                        <div class="border-b border-green-700 pb-6 last:border-b-0">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $entrenamiento->nombre }}</h3>
                            <p class="text-sm text-green-100 opacity-90">Tipo: <span class="font-medium">{{ $entrenamiento->tipo }}</span></p>
                            <p class="text-sm text-green-100 opacity-90">Duración: <span class="font-medium">{{ $entrenamiento->duracion }}</span> minutos</p>
                            <p class="text-xs text-green-200 mt-2">Fecha: {{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y') }}</p>
                            <a href="{{ route('entrenador.entrenamientos.edit', $entrenamiento->id_entrenamiento) }}"
                                class="inline-flex items-center text-blue-300 hover:text-blue-200 font-medium mt-4 transition-colors duration-200 text-sm group">
                                Editar entrenamiento
                                <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-green-100 opacity-80 text-base italic">Aún no has creado ningún entrenamiento. ¡Inspírate y crea el primero!</p>
                    @endforelse

                    {{-- Mostrar mensaje si hay más de 3 entrenamientos --}}
                    @if ($entrenamientos->count() > 3)
                        <p class="text-green-200 text-sm mt-4 italic">
                            Tienes **{{ $entrenamientos->count() - 3 }}** entrenamiento(s) más.
                        </p>
                    @endif

                    <a href="{{ route('entrenador.entrenamientos.create') }}" class="mt-8 inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-700 transition-all duration-300 shadow-md text-base">
                        <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                        Crear Nuevo Entrenamiento
                    </a>
                </div>
                <div class="mt-6">
                    <a href="{{ route('entrenador.entrenamientos.index') }}"
                        class="inline-flex items-center text-blue-300 hover:text-blue-200 font-medium transition-colors duration-200 group">
                        Ver todos mis entrenamientos
                        <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            {{-- Tarjeta 4: Solicitudes Pendientes (Rojo como en la imagen) --}}
            <div class="bg-gradient-to-br from-red-800 to-red-600 p-8 rounded-2xl shadow-2xl border border-red-700 hover:shadow-red-500/50 transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-3xl font-extrabold text-[#F3F4F6] mb-6 flex items-center gap-4">
                    <i data-feather="bell" class="w-8 h-8 text-red-300 group-hover:animate-shake transition-transform"></i>
                    Solicitudes Pendientes
                </h2>
                @if ($solicitudesPendientes->count() > 0)
                    <p class="text-red-100 mb-6 text-base leading-relaxed">
                        ¡Atención! Tienes <span class="font-bold text-red-300">{{ $solicitudesPendientes->count() }}</span>
                        solicitud(es) de clase pendiente(s) de tu aprobación. No dejes a tus alumnos esperando.
                    </p>
                    <a href="{{ route('entrenador.solicitudes.index') }}"
                        class="inline-flex items-center bg-red-600 text-white px-7 py-3 rounded-full font-bold hover:bg-red-700 transition-all duration-300 shadow-md text-base group">
                        Gestionar Solicitudes
                        <i data-feather="arrow-right" class="inline-block ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                @else
                    <p class="text-red-100 opacity-80 text-base italic">
                        ¡Excelente! No tienes solicitudes de clase pendientes.
                    </p>
                    <p class="text-red-200 text-sm mt-3">Mantente al tanto, el éxito es constante.</p>
                @endif
            </div>

            {{-- Tarjeta 5: Mis Reservas (Amarillo/Naranja como en la imagen) --}}
            <div class="bg-gradient-to-br from-yellow-800 to-yellow-600 p-8 rounded-2xl shadow-2xl border border-yellow-700 hover:shadow-yellow-500/50 transition-all duration-500 transform hover:-translate-y-2 group col-span-1 md:col-span-2 lg:col-span-1">
                <h2 class="text-3xl font-extrabold text-[#F3F4F6] mb-6 flex items-center gap-4">
                    <i data-feather="calendar" class="w-8 h-8 text-yellow-300 group-hover:rotate-3 transition-transform"></i>
                    Mis Reservas
                </h2>
                <div class="space-y-6">
                    {{-- Mostrar solo las primeras 3 reservas --}}
                    @forelse ($reservas->take(3) as $reserva)
                        <div class="border-b border-yellow-700 pb-6 last:border-b-0">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $reserva->clase->nombre }}</h3>
                            <p class="text-sm text-yellow-100 opacity-90">
                                Reservado por: <span class="font-medium">{{ $reserva->usuario->name }}</span>
                            </p>
                            <p class="text-xs text-yellow-200 mt-2">
                                Fecha y Hora: {{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y H:i') }}
                            </p>
                            <div class="mt-4">
                                @if ($reserva->estado == 'pendiente')
                                    <span class="bg-yellow-500 text-white rounded-full px-3 py-1 text-xs font-bold shadow-md">Pendiente</span>
                                @elseif($reserva->estado == 'aceptada')
                                    <span class="bg-green-500 text-white rounded-full px-3 py-1 text-xs font-bold shadow-md">Aceptada</span>
                                @else
                                    <span class="bg-red-500 text-white rounded-full px-3 py-1 text-xs font-bold shadow-md">Rechazada</span>
                                @endif
                            </div>
                            <a href="{{ route('entrenador.reservas.show', $reserva->id) }}"
                                class="inline-flex items-center text-blue-300 hover:text-blue-200 font-medium mt-4 transition-colors duration-200 text-sm group">
                                Ver Detalles <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-yellow-100 opacity-80 text-base italic">No tienes reservas de usuarios para tus clases aún.</p>
                    @endforelse

                    {{-- Mostrar mensaje si hay más de 3 reservas --}}
                    @if ($reservas->count() > 3)
                        <p class="text-yellow-200 text-sm mt-4 italic">
                            Tienes **{{ $reservas->count() - 3 }}** reserva(s) más.
                        </p>
                    @endif

                    <p class="text-yellow-200 text-sm mt-3">¡Sigue creando clases increíbles para atraer más reservas!</p>
                </div>
                <div class="mt-6">
                    <a href="{{ route('entrenador.solicitudes.index') }}"
                        class="inline-flex items-center text-blue-300 hover:text-blue-200 font-medium transition-colors duration-200 group">
                        Ver todas las reservas
                        <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            {{-- NUEVA Tarjeta: Estado de Clases (similar al verde de la imagen adjunta) --}}
            <div class="bg-gradient-to-br from-emerald-800 to-emerald-600 p-8 rounded-2xl shadow-2xl border border-emerald-700 hover:shadow-emerald-500/50 transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-3xl font-extrabold text-[#F3F4F6] mb-6 flex items-center gap-4">
                    <i data-feather="check-circle" class="w-8 h-8 text-emerald-300 group-hover:rotate-12 transition-transform"></i>
                    Estado de Clases
                </h2>
                <div class="text-lg text-emerald-100 space-y-4">
                    <p class="flex justify-between items-center">
                        <span class="opacity-90">Clases Aceptadas:</span>
                        <span id="clases-aceptadas-count" class="font-bold text-3xl text-emerald-300">Cargando...</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span class="opacity-90">Clases Pendientes:</span>
                        <span id="clases-pendientes-count" class="font-bold text-3xl text-yellow-300">Cargando...</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span class="opacity-90">Clases Rechazadas:</span>
                        <span id="clases-rechazadas-count" class="font-bold text-3xl text-red-300">Cargando...</span>
                    </p>
                </div>
                <div class="mt-6">
                    <a href="{{ route('entrenador.clases.index') }}"
                        class="inline-flex items-center text-blue-300 hover:text-blue-200 font-medium transition-colors duration-200 group">
                        Ver detalles de estados
                        <i data-feather="arrow-right" class="inline-block ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
    {{-- Estilos personalizados para animaciones (se mantienen) --}}
    <style>
        .animate-fade-in-down {
            animation: fadeInDown 1s ease-out forwards;
            opacity: 0;
            transform: translateY(-20px);
        }

        @keyframes fadeInDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }

        .animate-bounce-icon {
            animation: bounceIcon 1s infinite;
        }

        @keyframes bounceIcon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .animate-shake {
            animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            perspective: 1000px;
        }
        /* Una versión más rápida del shake para los iconos de acciones rápidas */
        .animate-shake-quick {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            perspective: 1000px;
        }


        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        .animate-flash {
            animation: flash 1.5s infinite;
        }

        @keyframes flash {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>

    {{-- Script para cargar Feather Icons y la llamada AJAX --}}
    @push('scripts')
    <script>
        // Función para cargar los estados de las clases
        function fetchClassStates() {
            // ¡ESTA ES LA LÍNEA CRÍTICA A CAMBIAR!
            fetch('{{ route('entrenador.dashboard.clases_estados') }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('clases-aceptadas-count').textContent = data.aceptadas;
                    document.getElementById('clases-pendientes-count').textContent = data.pendientes;
                    document.getElementById('clases-rechazadas-count').textContent = data.rechazadas;
                })
                .catch(error => {
                    console.error('Error al obtener estados de clases:', error);
                    document.getElementById('clases-aceptadas-count').textContent = 'Error';
                    document.getElementById('clases-pendientes-count').textContent = 'Error';
                    document.getElementById('clases-rechazadas-count').textContent = 'Error';
                });
        }

        document.addEventListener('DOMContentLoaded', fetchClassStates);
    </script>
    @endpush
</x-app-layout>