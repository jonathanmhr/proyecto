<x-app-layout>
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Editar Entrenador: {{ $entrenador->name }}</h2>

        <!-- Formulario de edición del entrenador -->
        <form action="{{ route('admin-entrenador.entrenadores.update', $entrenador) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
                <!-- Nombre (si es necesario editar) -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $entrenador->name) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Correo (si es necesario editar) -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $entrenador->email) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Clases Asignadas -->
                <div class="space-y-2">
                    <label for="clases" class="block text-sm font-medium text-gray-700">Clases Asignadas</label>
                    <select name="clases[]" id="clases" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" multiple>
                        @foreach($clases as $clase)
                            <option value="{{ $clase->id }}" 
                                @if($entrenador->clasesGrupales->contains($clase->id)) selected @endif>
                                {{ $clase->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Selecciona las clases a las que se asignará el entrenador.</p>
                </div>

                <!-- Botón de Guardar Cambios -->
                <div class="space-x-4">
                    <button type="submit" 
                        class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('admin-entrenador.entrenadores') }}" 
                        class="text-gray-500 hover:text-gray-700 py-2 px-4 rounded-lg">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
