<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Editar Entrenamiento') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Botón Volver -->
            <div class="mb-6">
                <a href="{{ route('admin-entrenador.entrenamientos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form method="POST" action="{{ route('admin-entrenador.entrenamientos.update', $entrenamiento->id_entrenamiento) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" value="{{ $entrenamiento->nombre }}"
                               class="w-full mt-1 border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tipo</label>
                        <input type="text" name="tipo" value="{{ $entrenamiento->tipo }}"
                               class="w-full mt-1 border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Duración (min)</label>
                        <input type="number" name="duracion" value="{{ $entrenamiento->duracion }}"
                               class="w-full mt-1 border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" name="fecha" value="{{ $entrenamiento->fecha }}"
                               class="w-full mt-1 border rounded px-3 py-2" required>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
