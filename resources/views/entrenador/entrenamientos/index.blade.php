<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            🏋️ Mis Entrenamientos
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro y padding global --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        @if (session('success'))
            <div class="bg-green-700 border border-green-800 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                    <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.103l-2.651 3.746a1.2 1.2 0 1 1-1.697-1.697l3.746-2.651-3.746-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.897l2.651-3.746a1.2 1.2 0 1 1 1.697 1.697L11.103 10l3.746 2.651a1.2 1.2 0 0 1 0 1.697z"/></svg>
                </span>
            </div>
        @endif

        {{-- Contenedor para los botones de acción --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0 sm:space-x-4">
            {{-- Botón para volver al Dashboard --}}
            <a href="{{ route('entrenador.dashboard') }}"
                class="inline-flex items-center px-6 py-3 bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition ease-in-out duration-150 w-full sm:w-auto justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                Volver al Dashboard
            </a>

            {{-- Botón para Crear Nuevo Entrenamiento (usando el rojo de acento de la imagen) --}}
            <a href="{{ route('entrenador.entrenamientos.create') }}"
                class="inline-flex items-center px-6 py-3 bg-red-700 text-white font-semibold rounded-lg shadow-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition ease-in-out duration-150 w-full sm:w-auto justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Crear Nuevo Entrenamiento
            </a>
        </div>

        @if ($entrenamientos->isEmpty())
            <div class="bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-8 text-center border border-gray-700">
                <p class="text-gray-300 text-lg">
                    Parece que aún no tienes ningún entrenamiento creado.
                    ¡Anímate a crear tu primer plan de ejercicios! 💪
                </p>
                {{-- Placeholder con colores que se ajustan al tema oscuro --}}
                <img src="https://placehold.co/300x200/2C2C3E/F0F0F0?text=Sin+entrenamientos" alt="No hay entrenamientos" class="mx-auto mt-6 rounded-lg opacity-75">
            </div>
        @else
            <div class="bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Nivel</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Fecha de Creación</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($entrenamientos as $entrenamiento)
                                <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ $entrenamiento->titulo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300 capitalize">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($entrenamiento->nivel == 'principiante') bg-teal-600 text-white
                                            @elseif($entrenamiento->nivel == 'intermedio') bg-yellow-500 text-gray-900
                                            @elseif($entrenamiento->nivel == 'avanzado') bg-red-700 text-white
                                            @else bg-gray-600 text-white
                                            @endif">
                                            {{ $entrenamiento->nivel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $entrenamiento->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-4">
                                            <a href="{{ route('entrenador.entrenamientos.edit', $entrenamiento->id) }}" class="text-blue-400 hover:text-blue-300 transition duration-150 ease-in-out" title="Editar Entrenamiento">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <a href="{{ route('entrenador.entrenamientos.usuarios', $entrenamiento->id) }}" class="text-purple-400 hover:text-purple-300 transition duration-150 ease-in-out" title="Ver Usuarios Asignados">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2m2-5h12m-4 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1.5m3.5-1.5h2m-5.5 10A1.5 1.5 0 0115 16.5v-2.5a1.5 1.5 0 00-3 0v2.5a1.5 1.5 0 01-1.5 1.5H9a1.5 1.5 0 00-1.5 1.5v2.5A1.5 1.5 0 019 23h4.5a1.5 1.5 0 001.5-1.5v-2.5z"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>