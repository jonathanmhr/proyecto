<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex justify-end mb-6">
            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="inline-flex items-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver al Dashboard
            </a>
        </div>

        <h1 class="text-3xl font-bold text-white mb-6">Solicitudes Pendientes de Clase</h1>

        @if (session('success'))
            <div class="mb-4 bg-green-700 text-white px-4 py-3 rounded-lg shadow-md border border-green-800 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-700 text-white px-4 py-3 rounded-lg shadow-md border border-red-800 animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        @if ($solicitudesPendientes->isEmpty())
            <p class="text-gray-400 text-center py-8">No hay solicitudes pendientes en este momento.</p>
        @else
            <div class="bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-700">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Nombre del Usuario</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Clase</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach ($solicitudesPendientes as $solicitud)
                            <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                                <td class="px-4 py-3 text-white">{{ $solicitud->usuario->name }}</td>
                                <td class="px-4 py-3 text-gray-300">{{ $solicitud->clase->nombre }}</td>
                                <td class="px-4 py-3 text-center space-x-4">
                                    <form action="{{ route('admin-entrenador.solicitudes.aceptar', ['claseId' => $solicitud->id_clase, 'usuarioId' => $solicitud->id_usuario]) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-400 hover:text-green-500 font-medium transition duration-200">Aceptar</button>
                                    </form>
                                    <form action="{{ route('admin-entrenador.solicitudes.rechazar', ['claseId' => $solicitud->id_clase, 'usuarioId' => $solicitud->id_usuario]) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-400 hover:text-red-500 font-medium transition duration-200">Rechazar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
