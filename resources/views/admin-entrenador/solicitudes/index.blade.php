<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">

        <div class="flex justify-end mb-6">
            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="inline-flex items-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver al Dashboard
            </a>
        </div>

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

        {{-- Solicitudes de Clases --}}
        <h2 class="text-3xl font-bold mb-4">Solicitudes Pendientes de Clases</h2>
        @if ($solicitudesClasesPendientes->isEmpty())
        <p class="text-gray-400 mb-10">No hay solicitudes pendientes de clase.</p>
        @else
        <div class="bg-gray-800 shadow rounded-xl p-4 mb-10">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-300">Nombre de la Clase</th>
                        <th class="px-4 py-2 text-left text-gray-300">Descripción</th>
                        <th class="px-4 py-2 text-center text-gray-300">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($solicitudesClasesPendientes as $clase)
                    <tr class="hover:bg-gray-700">
                        <td class="px-4 py-2">{{ $clase->nombre }}</td>
                        <td class="px-4 py-2">{{ $clase->descripcion ?? 'Sin descripción' }}</td>
                        <td class="px-4 py-2 text-center space-x-4">
                            <form action="{{ route('admin-entrenador.solicitudes.aceptar', $clase->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-400 hover:text-green-500 font-semibold">Aceptar</button>
                            </form>
                            <form action="{{ route('admin-entrenador.solicitudes.rechazar', $clase->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-400 hover:text-red-500 font-semibold">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Solicitudes de Entrenamientos --}}
        <h2 class="text-3xl font-bold mb-4">Solicitudes Pendientes de Entrenamientos</h2>
        @if ($solicitudesEntrenamientosPendientes->isEmpty())
        <p class="text-gray-400">No hay solicitudes pendientes de entrenamiento.</p>
        @else
        <div class="bg-gray-800 shadow rounded-xl p-4">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-300">Nombre Entrenamiento</th>
                        <th class="px-4 py-2 text-left text-gray-300">Entrenador</th>
                        <th class="px-4 py-2 text-left text-gray-300">Estado</th>
                        <th class="px-4 py-2 text-center text-gray-300">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($solicitudesEntrenamientosPendientes as $solicitud)
                    <tr class="hover:bg-gray-700">
                        <td class="px-4 py-2">{{ $solicitud->entrenamiento->nombre ?? 'Entrenamiento eliminado' }}</td>
                        <td class="px-4 py-2">{{ $solicitud->entrenador->name ?? 'Entrenador desconocido' }}</td>
                        <td class="px-4 py-2 text-yellow-400 font-semibold">{{ ucfirst($solicitud->estado) }}</td>
                        <td class="px-4 py-2 text-center space-x-4">
                            <form action="{{ route('admin-entrenador.solicitudes-entrenamientos.aceptar', $solicitud->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-400 hover:text-green-500 font-semibold">Aceptar</button>
                            </form>
                            <form action="{{ route('admin-entrenador.solicitudes-entrenamientos.rechazar', $solicitud->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-400 hover:text-red-500 font-semibold">Rechazar</button>
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