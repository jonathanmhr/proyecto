<x-app-layout>
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Editar Clases de {{ $entrenador->name }}</h2>

        <form action="{{ route('admin-entrenador.entrenadores.update', $entrenador) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">

                <!-- Sección de Clases Asignadas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gestión de Clases</label>
                    
                    <div class="grid grid-cols-3 gap-4 items-center">
                        <!-- Clases Disponibles -->
                        <div>
                            <h3 class="text-sm font-semibold mb-2">Disponibles</h3>
                            <select id="clases_disponibles" class="w-full border rounded p-2 h-64" multiple>
                                @foreach($clases as $clase)
                                    @if(!$entrenador->clasesGrupales->contains($clase->id))
                                        <option value="{{ $clase->id }}">{{ $clase->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="flex flex-col items-center justify-center gap-4">
                            <button type="button" onclick="moverSeleccion('clases_disponibles', 'clases_asignadas')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">&gt;&gt;</button>
                            <button type="button" onclick="moverSeleccion('clases_asignadas', 'clases_disponibles')" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">&lt;&lt;</button>
                        </div>

                        <!-- Clases Asignadas -->
                        <div>
                            <h3 class="text-sm font-semibold mb-2">Asignadas</h3>
                            <select id="clases_asignadas" name="clases[]" class="w-full border rounded p-2 h-64" multiple>
                                @foreach($entrenador->clasesGrupales as $clase)
                                    <option value="{{ $clase->id }}">{{ $clase->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500 mt-2">
                        Mueve clases entre listas para asignarlas o quitarlas al entrenador. Recuerda que cada clase debe mantener al menos un entrenador.
                    </p>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('admin-entrenador.entrenadores') }}" class="text-gray-600 hover:text-gray-800">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function moverSeleccion(origenId, destinoId) {
            const origen = document.getElementById(origenId);
            const destino = document.getElementById(destinoId);

            Array.from(origen.selectedOptions).forEach(option => {
                destino.appendChild(option);
            });
        }
    </script>
</x-app-layout>
