<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Botón para volver al Dashboard -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin-entrenador.dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Volver al Dashboard
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-6">Solicitudes Pendientes de Clase</h1>

        @if ($solicitudesPendientes->isEmpty())
            <p>No hay solicitudes pendientes.</p>
        @else
            <table class="min-w-full bg-white shadow rounded-lg">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Nombre del Usuario</th>
                        <th class="py-2 px-4 border-b">Clase</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudesPendientes as $solicitud)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $solicitud->usuario->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $solicitud->clase->nombre }}</td>
                            <td class="py-2 px-4 border-b">
                                <form action="{{ route('admin-entrenador.solicitudes.aceptar', ['claseId' => $solicitud->id_clase, 'usuarioId' => $solicitud->id_usuario]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:text-green-700">Aceptar</button>
                                </form>
                                <form action="{{ route('admin-entrenador.solicitudes.rechazar', ['claseId' => $solicitud->id_clase, 'usuarioId' => $solicitud->id_usuario]) }}" method="POST" class="inline ml-4">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700">Rechazar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
