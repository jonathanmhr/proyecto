<x-app-layout>

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Editar Perfil</h2>

    @if (session('status'))
        <div class="mb-4 p-3 rounded text-white {{ session('status_type') === 'success' ? 'bg-green-500' : 'bg-red-500' }}">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.actualizar') }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Peso (kg)</label>
            <input type="number" name="peso" value="{{ old('peso', $perfil->peso) }}" min="1"
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            @error('peso') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Objetivo</label>
            <input type="text" name="objetivo" value="{{ old('objetivo', $perfil->objetivo) }}"
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            @error('objetivo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nivel</label>
            <select name="id_nivel" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                <option value="">Seleccione un nivel</option>
                <option value="1" {{ old('id_nivel', $perfil->id_nivel) == 1 ? 'selected' : '' }}>Principiante</option>
                <option value="2" {{ old('id_nivel', $perfil->id_nivel) == 2 ? 'selected' : '' }}>Intermedio</option>
                <option value="3" {{ old('id_nivel', $perfil->id_nivel) == 3 ? 'selected' : '' }}>Avanzado</option>
            </select>
            @error('id_nivel') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar Cambios</button>
        </div>
    </form>
</div>
</x-app-layout>