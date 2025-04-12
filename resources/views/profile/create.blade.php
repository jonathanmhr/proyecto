<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Completa tu perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('perfil.store') }}">
                    @csrf

                    <!-- Campos del formulario -->
                    <div class="mb-4">
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label for="peso" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
                        <input type="number" step="0.1" name="peso" id="peso" class="mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label for="altura" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                        <input type="number" step="0.1" name="altura" id="altura" class="mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
                        <textarea name="objetivo" id="objetivo" class="mt-1 block w-full" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="id_nivel" class="block text-sm font-medium text-gray-700">Nivel de entrenamiento</label>
                        <select name="id_nivel" id="id_nivel" class="mt-1 block w-full" required>
                            <option value="1">Principiante</option>
                            <option value="2">Intermedio</option>
                            <option value="3">Avanzado</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded">Guardar perfil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
