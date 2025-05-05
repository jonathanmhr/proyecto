<!-- resources/views/entrenador/clases/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Clase: ') }} {{ $clase->nombre }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Alumnos Suscritos a la Clase</h1>
            <a href="{{ route('entrenador.clases.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <!-- Lista de alumnos suscritos -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow">
            <h3 class="text-xl font-semibold text-blue-800 mb-4">Alumnos Suscritos</h3>

            @forelse ($clase->usuarios as $usuario)
                <div class="border-b border-blue-200 pb-2 mb-2">
                    <div class="text-blue-900 font-medium">{{ $usuario->name }}</div>
                    <div class="text-sm text-blue-700">{{ $usuario->email }}</div>
                    <div class="text-sm text-blue-700 mb-2"> Fecha de suscripción:
                        @if ($usuario->pivot->created_at)
                            {{ $usuario->pivot->created_at->format('d/m/Y') }}
                        @else
                            <span class="text-red-500">Fecha no disponible</span>
                        @endif
                        <div class="text-sm text-blue-700">
                            Estado de la Suscripción:
                            @if ($usuario->pivot->estado === 'pendiente')
                                <span class="text-yellow-500">Pendiente</span>
                            @elseif ($usuario->pivot->estado === 'aceptado')
                                <span class="text-green-500">Aceptado</span>
                            @else
                                <span class="text-red-500">Rechazado</span>
                            @endif
                        </div>

                        <!-- Botón para quitar de clase -->
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 mt-4"
                            data-modal-target="modal-quitar-{{ $usuario->id }}"
                            data-modal-toggle="modal-quitar-{{ $usuario->id }}">
                            Quitar de clase
                        </button>

                        <!-- Modal Quitar -->
                        <div id="modal-quitar-{{ $usuario->id }}"
                            class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-center">
                                <h3 class="text-lg font-semibold mb-4 break-words leading-relaxed">
                                    ¿Confirmas que deseas quitar a {{ $usuario->name }} de esta clase?
                                </h3>
                                <form action="{{ route('clases.quitarUsuario', ['clase' => $clase->id, 'userId' => $usuario->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-center gap-4 mt-4">
                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600" data-modal-hide="modal-quitar-{{ $usuario->id }}">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                                            Confirmar
                                        </button>
                                    </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-blue-600">No hay alumnos suscritos a esta clase.</p>
            @endforelse
        </div>
    </div>
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
