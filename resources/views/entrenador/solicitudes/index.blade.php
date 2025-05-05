<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitudes Pendientes') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Solicitudes de Inscripción a tus Clases</h1>

        @if ($solicitudesPendientes->count() > 0)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alumno</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clase</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Solicitud</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($solicitudesPendientes as $solicitud)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $solicitud->usuario->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $solicitud->clase->nombre }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $solicitud->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('entrenador.solicitudes.aceptar', [$solicitud->clase->id, $solicitud->user_id]) }}">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                            Aceptar
                                        </button>
                                    </form>
                    
                                    <form method="POST" action="{{ route('entrenador.solicitudes.rechazar', [$solicitud->clase->id, $solicitud->user_id]) }}">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded">
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
            <div class="text-gray-700">No tienes solicitudes pendientes en este momento.</div>
        @endif
    </div>
</x-app-layout>
