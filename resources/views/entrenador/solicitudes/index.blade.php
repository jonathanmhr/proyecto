<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            <span>Solicitudes Pendientes</span>
            <a href="{{ route('entrenador.dashboard') }}" class="bg-teal-500 text-white px-4 py-2 rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500">
                Volver al Dashboard
            </a>
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
                                        <!-- Botón de Aceptar -->
                                        <button type="button" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500" data-modal-target="modal-aceptar-{{ $solicitud->id }}" data-modal-toggle="modal-aceptar-{{ $solicitud->id }}">
                                            Aceptar
                                        </button>

                                        <!-- Modal de Confirmación Aceptar -->
                                        <div id="modal-aceptar-{{ $solicitud->id }}" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
                                            <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs w-full overflow-auto">
                                                <h3 class="text-xl font-semibold mb-4">¿Confirmas que deseas aceptar esta solicitud?</h3>
                                                <form action="{{ route('entrenador.clases.aceptarSolicitud', [$solicitud->id_clase, $solicitud->user_id]) }}" method="POST">
                                                    @csrf
                                                    <div class="flex justify-between">
                                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600" data-modal-hide="modal-aceptar-{{ $solicitud->id }}">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                                                            Confirmar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Botón de Rechazar -->
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500" data-modal-target="modal-rechazar-{{ $solicitud->id }}" data-modal-toggle="modal-rechazar-{{ $solicitud->id }}">
                                            Rechazar
                                        </button>

                                        <!-- Modal de Confirmación Rechazar -->
                                        <div id="modal-rechazar-{{ $solicitud->id }}" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
                                            <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs w-full overflow-auto">
                                                <h3 class="text-xl font-semibold mb-4">¿Confirmas que deseas rechazar esta solicitud?</h3>
                                                <form action="{{ route('entrenador.clases.rechazarSolicitud', [$solicitud->id_clase, $solicitud->user_id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="flex justify-between">
                                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600" data-modal-hide="modal-rechazar-{{ $solicitud->id }}">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                                                            Confirmar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
            {{ $solicitudesPendientes->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Scripts para abrir y cerrar modales -->
    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-hide');
                const modal = document.getElementById(modalId);
                modal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
