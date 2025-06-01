<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-white">Editar Clases de <span class="text-red-500">{{ $entrenador->name }}</span></h2>
            <a href="{{ route('admin-entrenador.entrenadores.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-700 text-white px-4 py-3 rounded-lg mb-6 shadow-md border border-green-800 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-700 text-white px-4 py-3 rounded-lg mb-6 shadow-md border border-red-800 animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin-entrenador.entrenadores.update', $entrenador) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-gray-800 shadow-lg rounded-xl p-6 space-y-6 border border-gray-700">
                <div>
                    <label class="block text-white font-semibold mb-3 text-lg">Gestión de Clases</label>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div>
                            <h3 class="font-bold text-white mb-2">Clases Disponibles</h3>
                            <select id="disponibles" class="w-full h-64 border border-gray-600 rounded-lg p-3 bg-gray-700 text-white focus:outline-none focus:border-red-500 focus:ring-red-500" multiple>
                                @foreach ($clases as $clase) {{-- Aquí se usa $clases --}}
                                    @unless ($entrenador->clasesGrupales->contains($clase->id_clase))
                                        <option value="{{ $clase->id_clase }}">{{ $clase->nombre }}</option>
                                    @endunless
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col items-center justify-center gap-4 mt-6 md:mt-0">
                            <button type="button" id="asignar"
                                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-bold shadow-md transition duration-200 transform hover:scale-105">
                                <i data-feather="arrow-right" class="w-6 h-6"></i>
                            </button>
                            <button type="button" id="quitar"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-bold shadow-md transition duration-200 transform hover:scale-105">
                                <i data-feather="arrow-left" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <div>
                            <h3 class="font-bold text-white mb-2">Clases Asignadas</h3>
                            <select name="clases[]" id="asignadas" class="w-full h-64 border border-gray-600 rounded-lg p-3 bg-gray-700 text-white focus:outline-none focus:border-red-500 focus:ring-red-500" multiple>
                                @foreach ($entrenador->clasesGrupales as $clase) {{-- Aquí se usa $entrenador->clasesGrupales --}}
                                    <option value="{{ $clase->id_clase }}" selected>{{ $clase->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 mt-4 text-center">Usa los botones para mover clases entre listas. Mantén 'Ctrl' o 'Cmd' para seleccionar múltiples.</p>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('admin-entrenador.entrenadores.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-red-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-red-700 shadow-md transition duration-200 transform hover:scale-105">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                // Get references to the select elements and buttons
                const disponiblesSelect = document.getElementById('disponibles');
                const asignadasSelect = document.getElementById('asignadas');
                const asignarButton = document.getElementById('asignar');
                const quitarButton = document.getElementById('quitar');
                const form = document.querySelector("form");

                // Function to move selected options between select elements
                function moveSelectedOptions(sourceSelect, targetSelect) {
                    const selectedOptions = Array.from(sourceSelect.selectedOptions);

                    selectedOptions.forEach(option => {
                        sourceSelect.removeChild(option);
                        targetSelect.appendChild(option);
                        option.selected = false;
                    });

                    // Sort the target select options alphabetically by text
                    sortSelectOptions(targetSelect);
                }

                // Function to sort select options alphabetically
                function sortSelectOptions(selectElement) {
                    const options = Array.from(selectElement.options);
                    options.sort((a, b) => a.text.localeCompare(b.text));
                    options.forEach(option => selectElement.appendChild(option));
                }

                // Event listeners for the move buttons
                asignarButton.addEventListener('click', function() {
                    moveSelectedOptions(disponiblesSelect, asignadasSelect);
                });

                quitarButton.addEventListener('click', function() {
                    moveSelectedOptions(asignadasSelect, disponiblesSelect);
                });

                // Before form submission, ensure all options in 'asignadas' are selected
                // so their values are sent to the server.
                form.addEventListener("submit", function(event) {
                    Array.from(asignadasSelect.options).forEach(option => {
                        option.selected = true;
                    });
                });

                // Initial sort of both selects (optional, but good for consistency)
                sortSelectOptions(disponiblesSelect);
                sortSelectOptions(asignadasSelect);
            });
        </script>
    @endpush
</x-app-layout>
