<!-- resources/views/profile/edit.blade.php -->
<form method="POST" action="{{ $perfil ? route('perfil.update') : route('perfil.store') }}">
    @csrf
    @if($perfil)
        @method('PUT') <!-- Si estamos editando, usamos el método PUT -->
    @endif

    <!-- Campos del formulario -->
    <div class="mb-4">
        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $perfil->fecha_nacimiento ?? '') }}" class="mt-1 block w-full" required>
    </div>

    <div class="mb-4">
        <label for="peso" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
        <input type="number" step="0.1" name="peso" id="peso" value="{{ old('peso', $perfil->peso ?? '') }}" class="mt-1 block w-full" required>
    </div>

    <div class="mb-4">
        <label for="altura" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
        <input type="number" step="0.1" name="altura" id="altura" value="{{ old('altura', $perfil->altura ?? '') }}" class="mt-1 block w-full" required>
    </div>

    <div class="mb-4">
        <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
        <textarea name="objetivo" id="objetivo" class="mt-1 block w-full" required>{{ old('objetivo', $perfil->objetivo ?? '') }}</textarea>
    </div>

    <div class="mb-4">
        <label for="id_nivel" class="block text-sm font-medium text-gray-700">Nivel de entrenamiento</label>
        <select name="id_nivel" id="id_nivel" class="mt-1 block w-full" required>
            <option value="1" {{ $perfil && $perfil->id_nivel == 1 ? 'selected' : '' }}>Principiante</option>
            <option value="2" {{ $perfil && $perfil->id_nivel == 2 ? 'selected' : '' }}>Intermedio</option>
            <option value="3" {{ $perfil && $perfil->id_nivel == 3 ? 'selected' : '' }}>Avanzado</option>
        </select>
    </div>

    <div class="mb-4">
        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded">Guardar cambios</button>
    </div>
</form>

