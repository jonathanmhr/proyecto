<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Solicitudes Pendientes') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Solicitudes de Inscripción a tus Clases</h1>
            <a href="{{ route('entrenador.dashboard') }}" {{-- Assuming this route is correct for the trainer's dashboard --}}
                class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-700 border border-green-800 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-700 border border-red-800 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        @if ($solicitudesPendientes->count() > 0)
            <div class="bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-700">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Alumno</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Clase</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Fecha Solicitud</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach ($solicitudesPendientes as $solicitud)
                        <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                {{ $solicitud->usuario->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                {{ $solicitud->clase->nombre }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                {{ $solicitud->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-4"> {{-- Increased space for buttons --}}
                                    <form method="POST" action="{{ route('entrenador.solicitudes.aceptar', [$solicitud->id]) }}">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-5 py-2 rounded-lg shadow-md transition duration-200">
                                            Aceptar
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('entrenador.solicitudes.rechazar', [$solicitud->id]) }}">
                                        @csrf
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2 rounded-lg shadow-md transition duration-200">
                                            Rechazar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-400 text-center py-8">No tienes solicitudes pendientes en este momento.</p>
        @endif
    </div>
</x-app-layout>
