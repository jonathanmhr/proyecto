<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Solicitudes Pendientes
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($solicitudesPendientes->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumno</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($solicitudesPendientes as $solicitud)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $solicitud->usuario->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $solicitud->clase->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                        <form action="{{ route('entrenador.clases.aceptarSolicitud', [$solicitud->id_clase, $solicitud->user_id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas aceptar esta solicitud?');">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                                Aceptar
                                            </button>
                                        </form>
                                        <form action="{{ route('entrenador.clases.rechazarSolicitud', [$solicitud->id_clase, $solicitud->user_id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas rechazar esta solicitud?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                Rechazar
                                            </button>
                                        </form>                                      
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600">No tienes solicitudes pendientes.</p>
                @endif
            </div>
        </div>
        
        <!-- Paginación -->
        <div class="mt-4">
            {{ $solicitudesPendientes->links('pagination::tailwind') }} <!-- Usa el diseño tailwind predeterminado para la paginación -->
        </div>
    </div>
</x-app-layout>
