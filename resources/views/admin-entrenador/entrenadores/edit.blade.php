<x-app-layout>
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Editar Clases de {{ $entrenador->name }}</h2>

        <form action="{{ route('admin-entrenador.entrenadores.update', $entrenador) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gestión de Clases</label>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <!-- Clases Disponibles -->
                        <div>
                            <h3 class="font-semibold mb-2">Clases Disponibles</h3>
                            <select id="disponibles" class="w-full h-64 border rounded p-2" multiple>
                                @foreach($clases as $clase)
                                    @unless($entrenador->clasesGrupales->contains($clase->id))
                                        <option value="{{ $clase->id }}">{{ $clase->nombre }}</option>
                                    @endunless
                                @endforeach
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="flex flex-col items-center justify-center gap-4">
                            <button type="button" id="asignar" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">&rarr;</button>
                            <button type="button" id="quitar" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">&larr;</button>
                        </div>

                        <!-- Clases Asignadas -->
                        <div>
                            <h3 class="font-semibold mb-2">Clases Asignadas</h3>
                            <select name="clases[]" id="asignadas" class="w-full h-64 border rounded p-2" multiple>
                                @foreach($entrenador->clasesGrupales as $clase)
                                    <option value="{{ $clase->id }}">{{ $clase->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Usa los botones para mover clases entre listas.</p>
                </div>

                <!-- Botones -->
                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('admin-entrenador.entrenadores') }}" class="text-gray-500 hover:text-gray-700 py-2 px-4">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('asignar').addEventListener('click', function () {
            moverSeleccionados('disponibles', 'asignadas');
        });
    
        document.getElementById('quitar').addEventListener('click', function () {
            moverSeleccionados('asignadas', 'disponibles');
        });
    
        function moverSeleccionados(origenId, destinoId) {
            const origen = document.getElementById(origenId);
            const destino = document.getElementById(destinoId);
            const seleccionados = Array.from(origen.selectedOptions);
    
            seleccionados.forEach(op => {
                origen.removeChild(op);
                destino.appendChild(op);
            });
        }
    
        // Verifica los datos antes de enviar el formulario
        document.querySelector("form").addEventListener("submit", function (event) {
            // Primero eliminamos cualquier clase anterior en el formulario (si existiera)
            let inputClases = document.querySelector('input[name="clases[]"]');
            if (inputClases) {
                inputClases.remove();
            }
    
            // Obtener las clases asignadas
            const clasesAsignadas = Array.from(document.getElementById("asignadas").options).map(option => option.value);
            
            // Depurar los datos de las clases antes de enviar el formulario
            console.log("Clases asignadas:", clasesAsignadas);
    
            // Si no hay clases asignadas, no enviamos el campo
            if (clasesAsignadas.length > 0) {
                // Añadimos las clases asignadas al formulario como un campo oculto
                inputClases = document.createElement("input");
                inputClases.setAttribute("type", "hidden");
                inputClases.setAttribute("name", "clases[]");
                inputClases.setAttribute("value", clasesAsignadas.join(","));
                this.appendChild(inputClases);
            }
        });
    </script>
    
    
</x-app-layout>
