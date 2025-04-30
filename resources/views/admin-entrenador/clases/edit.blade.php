<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Editar Clase: {{ $clase->nombre }}</h1>

        <form action="{{ route('admin-entrenador.clases.update', $clase->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white shadow rounded-xl p-6">

                <!-- Nombre de la clase -->
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700">Nombre de la Clase</label>
                    <input type="text" name="nombre" id="nombre" value="{{ $clase->nombre }}" class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Selección de Entrenador -->
                <div class="mb-4">
                    <label for="entrenador_id" class="block text-gray-700">Entrenador</label>
                    <select name="entrenador_id" id="entrenador_id" class="w-full p-3 border border-gray-300 rounded" required>
                        <option value="">Seleccionar Entrenador</option>
                        @foreach ($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}" {{ $clase->entrenador_id == $entrenador->id ? 'selected' : '' }}>{{ $entrenador->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Fecha de la clase -->
                <div class="mb-4">
                    <label for="fecha" class="block text-gray-700">Fecha</label>
                    <input type="datetime-local" name="fecha" id="fecha" value="{{ \Carbon\Carbon::parse($clase->fecha)->format('Y-m-d\TH:i') }}" class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Botón de Actualizar Clase -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg">
                        Actualizar Clase
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
