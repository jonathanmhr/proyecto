<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Mis Clases') }}
        </h2>
    </x-slot>

    <main class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold text-red-400 tracking-tight mb-4 sm:mb-0">
                Tus Clases Programadas
            </h1>
            <a href="{{ route('entrenador.dashboard') }}"
                class="inline-flex items-center px-6 py-3 bg-blue-700 hover:bg-blue-800 rounded-lg shadow-md transition-colors duration-200 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                aria-label="Volver al Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img"
                    aria-hidden="true">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Volver al Dashboard
            </a>
        </div>

        <section class="space-y-8">
            @forelse ($clases as $clase)
                @php
                    // Determinamos si es una clase individual o grupal
                    $isIndividual = class_basename($clase) === 'ClaseIndividual';
                    $tipoClase = $isIndividual ? 'Clase Individual' : 'Clase Grupal';
                    $bgBadge = $isIndividual ? 'bg-indigo-600 text-indigo-100' : 'bg-purple-600 text-purple-100';
                @endphp

                <article
                    class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-lg hover:shadow-xl hover:bg-gray-700 transition-transform duration-300 transform hover:-translate-y-1">

                    <header class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-3">
                        <h3 class="text-2xl font-bold text-red-400 flex items-center gap-2">
                            @if ($isIndividual)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $clase->titulo }}
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20h6M4 20h5v-2a4 4 0 00-3-3.87M12 10a5 5 0 110-10 5 5 0 010 10z" />
                                </svg>
                                {{ $clase->nombre }}
                            @endif
                        </h3>
                        <span class="text-sm px-3 py-1 rounded-full {{ $bgBadge }} font-semibold select-none"
                            aria-label="Tipo de clase">
                            {{ $tipoClase }}
                        </span>
                    </header>

                    <p class="text-gray-300 mb-5 leading-relaxed border-b border-gray-700 pb-4">
                        {{ $clase->descripcion }}
                    </p>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm text-gray-400 mb-6">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <dt class="font-semibold text-gray-200">Fecha</dt>
                                <dd>
                                    @if ($isIndividual)
                                        @if ($clase->frecuencia === 'unica')
                                            <time datetime="{{ $clase->fecha_hora }}">
                                                <span class="font-medium text-white">
                                                    {{ \Carbon\Carbon::parse($clase->fecha_hora)->format('d/m/Y H:i') }}
                                                </span>
                                            </time>
                                        @else
                                            <time datetime="{{ $clase->fecha_inicio }}">
                                                <span class="font-medium text-white">
                                                    {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }}
                                                </span>
                                            </time>
                                            -
                                            <time datetime="{{ $clase->fecha_fin }}">
                                                <span class="font-medium text-white">
                                                    {{ \Carbon\Carbon::parse($clase->fecha_fin)->format('d/m/Y') }}
                                                </span>
                                            </time>
                                            <span class="text-gray-500">(Recurrente)</span>
                                        @endif
                                    @else
                                        <time datetime="{{ $clase->fecha_inicio }}">
                                            <span class="font-medium text-white">
                                                {{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }}
                                            </span>
                                        </time>
                                        -
                                        <time datetime="{{ $clase->fecha_fin }}">
                                            <span class="font-medium text-white">
                                                {{ \Carbon\Carbon::parse($clase->fecha_fin)->format('d/m/Y') }}
                                            </span>
                                        </time>
                                    @endif
                                </dd>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <dt class="font-semibold text-gray-200">Ubicación</dt>
                                <dd class="font-medium text-white">
                                    {{ $isIndividual ? $clase->lugar ?? 'N/A' : $clase->ubicacion ?? 'N/A' }}
                                </dd>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.692V15a1 1 0 11-2 0v-5.954a4 4 0 112 0v5.954a1 1 0 11-2 0V4.354z" />
                            </svg>
                            <div>
                                <dt class="font-semibold text-gray-200">Duración estimada</dt>
                                <dd class="font-medium text-white">
                                    {{ $clase->duracion ? $clase->duracion . ' minutos' : 'No disponible' }}
                                </dd>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <dt class="font-semibold text-gray-200">Instructor</dt>
                                <dd class="font-medium text-white">
                                    {{ $clase->entrenador->name ?? 'No asignado' }}
                                </dd>
                            </div>
                        </div>

                        {{-- Agregado: Cupos disponibles solo para clases grupales, si es que esta información existe --}}
                        @if (!$isIndividual && isset($clase->cupos_maximos))
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <dt class="font-semibold text-gray-200">Cupos máximos</dt>
                                    <dd class="font-medium text-white">
                                        {{ $clase->cupos_maximos }}
                                    </dd>
                                </div>
                            </div>
                        @endif
                    </dl>

                    {{-- Agregado: Indicador de estado de la clase (Pendiente/Aceptada), si esta información existe --}}
                    @if (isset($clase->cambio_pendiente))
                        <div class="mt-4">
                            @if ($clase->cambio_pendiente)
                                <span
                                    class="inline-flex items-center gap-1 bg-yellow-600 text-yellow-100 px-3 py-1 rounded-full text-xs font-bold"
                                    aria-label="Cambios pendientes de aprobación">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Cambios pendientes de aprobación
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 bg-green-600 text-green-100 px-3 py-1 rounded-full text-xs font-bold"
                                    aria-label="Clase aceptada">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" role="img" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Clase Aceptada
                                </span>
                            @endif
                        </div>
                    @endif

                    <footer class="flex flex-wrap gap-4 mt-6 border-t border-gray-700 pt-4 justify-end">
                        @if ($clase->tipo === 'individual')
                            <a href="{{ route('entrenador.clases.individuales.show', ['id' => $clase->id]) }}"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg font-semibold text-white transition-colors duration-150"
                                aria-label="Ver detalles de la clase individual">
                                Ver detalles
                            </a>

                            <a href="{{ route('entrenador.clases-individuales.edit', ['claseIndividual' => $clase->id]) }}"
                                class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 rounded-lg font-semibold text-white transition-colors duration-150"
                                aria-label="Editar clase individual">
                                Editar
                            </a>
                        @else
                            <a href="{{ route('entrenador.clases.grupales.show', ['id' => $clase->id ?? 0]) }}"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg font-semibold text-white transition-colors duration-150"
                                aria-label="Ver detalles de la clase grupal">
                                Ver detalles
                            </a>
                        @endif
                    </footer>

                </article>
            @empty
                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 text-center">
                    <p class="text-gray-400 text-lg mb-4">
                        No tienes clases programadas aún.
                    </p>
                </div>
            @endforelse
        </section>
    </main>
</x-app-layout>