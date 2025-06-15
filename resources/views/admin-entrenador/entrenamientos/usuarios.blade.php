<x-app-layout>
    {{-- El header slot se mantiene vacío ya que el título y el botón se manejan en el cuerpo --}}
    <x-slot name="header"></x-slot>

    {{-- Contenedor principal de la página con fondo oscuro y padding generoso --}}
    <div class="py-8 md:py-12 bg-[#1a202c] min-h-screen">
        <div class="max-w-xl md:max-w-4xl lg:max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Encabezado de la Página con Título y Botón de Volver --}}
            <header class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4 bg-gray-900 p-6 rounded-xl shadow-lg border border-gray-700">
                <h1 class="text-4xl font-extrabold text-white text-center sm:text-left leading-tight">
                    Usuarios relacionados con: <span class="text-red-500">{{ $entrenamiento->titulo }}</span>
                </h1>
                
                {{-- Botón para Volver a Entrenamientos --}}
                <a href="{{ route('admin-entrenador.entrenamientos.index') }}"
                   class="inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
                    {{-- Icono de flecha izquierda de Feather Icons --}}
                    <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i> Volver a Entrenamientos
                </a>
            </header>

            {{-- Contenedor principal del contenido (tabla de usuarios o mensaje) --}}
            <div class="bg-gray-800 rounded-xl shadow-xl border border-gray-700 p-6 md:p-8">
                @if($usuarios->isEmpty())
                    {{-- Mensaje para cuando no hay usuarios --}}
                    <div class="bg-gray-700 border-l-4 border-yellow-600 text-gray-100 p-4 rounded-md shadow-md" role="alert">
                        <p class="font-bold mb-1 flex items-center">
                            {{-- Icono de información de Feather Icons --}}
                            <i data-feather="info" class="w-5 h-5 mr-2"></i> No hay usuarios relacionados con este entrenamiento.
                        </p>
                        <p>Cuando los usuarios guarden o estén realizando este entrenamiento, aparecerán aquí.</p>
                    </div>
                @else
                    {{-- Título de la sección de la tabla --}}
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3 flex items-center">
                        {{-- Icono de lista de Feather Icons --}}
                        <i data-feather="users" class="w-6 h-6 mr-3 text-red-500"></i> Detalle de Usuarios
                    </h2>

                    <div class="overflow-x-auto rounded-lg shadow-md border border-gray-700">
                        <table class="min-w-full bg-gray-800 text-white">
                            <thead>
                                <tr class="bg-gray-700 text-sm font-semibold uppercase tracking-wider">
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                    <th class="py-3 px-6 text-left">Email</th>
                                    <th class="py-3 px-6 text-left">Estado</th>
                                    <th class="py-3 px-6 text-left">Fecha de Inicio</th>
                                    <th class="py-3 px-6 text-left">Semanas Duración</th>
                                    <th class="py-3 px-6 text-left">Días Entrenamiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition duration-150 ease-in-out">
                                        <td class="py-3 px-6 whitespace-nowrap">{{ $usuario->name }}</td>
                                        <td class="py-3 px-6 whitespace-nowrap">{{ $usuario->email }}</td>
                                        <td class="py-3 px-6 whitespace-nowrap">
                                            @if($usuario->pivot->fecha_inicio)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-700 text-green-100">
                                                    <i data-feather="play-circle" class="w-4 h-4 mr-1"></i> En curso
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-700 text-yellow-100">
                                                    <i data-feather="bookmark" class="w-4 h-4 mr-1"></i> Guardado
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 whitespace-nowrap">
                                            {{ $usuario->pivot->fecha_inicio ? \Carbon\Carbon::parse($usuario->pivot->fecha_inicio)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="py-3 px-6 whitespace-nowrap">{{ $usuario->pivot->semanas_duracion ?? '-' }}</td>
                                        <td class="py-3 px-6 whitespace-nowrap">{{ $usuario->pivot->dias_entrenamiento ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
