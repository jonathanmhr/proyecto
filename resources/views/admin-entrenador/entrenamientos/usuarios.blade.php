<x-app-layout>
    {{-- Contenedor principal de la página con fondo oscuro y padding --}}
    <div class="py-8 md:py-12 bg-gray-900 min-h-screen">
        <div class="max-w-xl md:max-w-4xl lg:max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Encabezado de la Página --}}
            <header class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-4xl font-extrabold text-white text-center sm:text-left">
                    Usuarios que guardaron: <span class="text-red-500">{{ $entrenamiento->titulo }}</span>
                </h1>
                {{-- Botón para Volver --}}
                <a href="{{ route('admin-entrenador.entrenamientos.index') }}"
                    class="inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
                    <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i> Volver a Entrenamientos
                </a>
            </header>

            {{-- Contenedor principal del contenido (lista de usuarios o mensaje) --}}
            <div class="bg-gray-800 rounded-xl shadow-xl border border-gray-700 p-6 md:p-8">
                @if($entrenamiento->usuariosGuardaron->isEmpty())
                    {{-- Mensaje para cuando no hay usuarios --}}
                    <div class="bg-gray-700 border-l-4 border-yellow-600 text-gray-100 p-4 rounded-md shadow-md" role="alert">
                        <p class="font-bold mb-1 flex items-center">
                            <i data-feather="info" class="w-5 h-5 mr-2"></i> No hay usuarios que hayan guardado este entrenamiento.
                        </p>
                        <p>Cuando los usuarios guarden este entrenamiento, aparecerán aquí.</p>
                    </div>
                @else
                    {{-- Lista de Usuarios en un formato de tarjeta o tabla más legible --}}
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3 flex items-center">
                        <i data-feather="users" class="w-6 h-6 mr-3 text-red-500"></i> Lista de Usuarios
                    </h2>

                    <div class="space-y-4">
                        @foreach($entrenamiento->usuariosGuardaron as $usuario)
                            <div class="bg-gray-700 p-5 rounded-lg shadow-md border border-gray-600 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                <div class="flex items-center">
                                    <i data-feather="user" class="w-6 h-6 text-blue-400 mr-3 flex-shrink-0"></i>
                                    <div>
                                        <p class="text-white text-lg font-semibold">{{ $usuario->name }}</p>
                                        <p class="text-gray-400 text-sm">{{ $usuario->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>