<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('perfil.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Campo para la fecha de nacimiento -->
                    <div class="mb-4">
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ $perfil->fecha_nacimiento }}" class="mt-1 block w-full" required>
                    </div>

                    <!-- Campo para el peso -->
                    <div class="mb-4">
                        <label for="peso" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
                        <input type="number" step="0.1" name="peso" id="peso" value="{{ $perfil->peso }}" class="mt-1 block w-full" required>
                    </div>

                    <!-- Campo para la altura -->
                    <div class="mb-4">
                        <label for="altura" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                        <input type="number" step="0.1" name="altura" id="altura" value="{{ $perfil->altura }}" class="mt-1 block w-full" required>
                    </div>

                    <!-- Campo para el objetivo -->
                    <div class="mb-4">
                        <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
                        <textarea name="objetivo" id="objetivo" class="mt-1 block w-full" required>{{ $perfil->objetivo }}</textarea>
                    </div>

                    <!-- Campo para seleccionar el nivel -->
                    <div class="mb-4">
                        <label for="id_nivel" class="block text-sm font-medium text-gray-700">Nivel de entrenamiento</label>
                        <select name="id_nivel" id="id_nivel" class="mt-1 block w-full" required>
                            <option value="1" {{ $perfil->id_nivel == 1 ? 'selected' : '' }}>Principiante</option>
                            <option value="2" {{ $perfil->id_nivel == 2 ? 'selected' : '' }}>Intermedio</option>
                            <option value="3" {{ $perfil->id_nivel == 3 ? 'selected' : '' }}>Avanzado</option>
                        </select>
                    </div>

                    <!-- Botón para actualizar -->
                    <div class="mb-4">
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded">Actualizar perfil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
