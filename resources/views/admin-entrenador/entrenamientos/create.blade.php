<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Crear Entrenamiento') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form method="POST" action="{{ route('admin-entrenador.entrenamientos.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" class="w-full mt-1 border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                        <input type="text" name="tipo" class="w-full mt-1 border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (min)</label>
                        <input type="number" name="duracion" class="w-full mt-1 border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" name="fecha" class="w-full mt-1 border rounded px-3 py-2" required>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Crear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
