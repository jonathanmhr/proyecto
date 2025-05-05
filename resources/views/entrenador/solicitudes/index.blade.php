<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestionar Suscripciones Pendientes') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Suscripciones Pendientes</h1>
                <a href="{{ route('entrenador.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($suscripcionesPendientes->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alumno</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clase</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($suscripcionesPendientes as $suscripcion)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $suscripcion->usuario->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $suscripcion->clase->nombre }}</td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <!-- Botón Aceptar -->
                                        <button type="button"
                                            class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
                                            data-modal-target="modal-aceptar-{{ $suscripcion->id }}"
                                            data-modal-toggle="modal-aceptar-{{ $suscripcion->id }}">
                                            Aceptar
                                        </button>

                                        <!-- Modal Aceptar -->
                                        <div id="modal-aceptar-{{ $suscripcion->id }}"
                                            class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">
                                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-center">
                                                <h3 class="text-lg font-semibold mb-4 break-words leading-relaxed">
                                                    ¿Confirmas que deseas<br>aceptar esta suscripción?
                                                </h3>
                                                <form action="{{ route('entrenador.clases.aceptarSuscripcion', [$suscripcion->id_clase, $suscripcion->usuario_id]) }}" method="POST">
                                                    @csrf
                                                    <div class="flex justify-center gap-4 mt-4">
                                                        <button type="button"
                                                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
                                                            data-modal-hide="modal-aceptar-{{ $suscripcion->id }}">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit"
                                                            class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                                                            Confirmar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Botón Rechazar -->
                                        <button type="button"
                                            class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                                            data-modal-target="modal-rechazar-{{ $suscripcion->id }}"
                                            data-modal-toggle="modal-rechazar-{{ $suscripcion->id }}">
                                            Rechazar
                                        </button>

                                        <!-- Modal Rechazar -->
                                        <div id="modal-rechazar-{{ $suscripcion->id }}"
                                            class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">
                                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-center">
                                                <h3 class="text-lg font-semibold mb-4 break-words leading-relaxed">
                                                    ¿Confirmas que deseas<br>rechazar esta suscripción?
                                                </h3>
                                                <form action="{{ route('entrenador.clases.rechazarSuscripcion', [$suscripcion->id_clase, $suscripcion->usuario_id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="flex justify-center gap-4 mt-4">
                                                        <button type="button"
                                                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
                                                            data-modal-hide="modal-rechazar-{{ $suscripcion->id }}">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit"
                                                            class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
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
                    <p class="text-gray-600">No tienes suscripciones pendientes.</p>
                @endif
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $suscripcionesPendientes->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- Script de modales -->
    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                document.getElementById(modalId)?.classList.remove('hidden');
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-hide');
                document.getElementById(modalId)?.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>