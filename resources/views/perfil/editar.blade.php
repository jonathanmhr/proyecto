<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-gradient-to-r from-cyan-700 to-cyan-500 p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-extrabold text-cyan-200 mb-6">Editar Perfil</h2>

        @if (session('status'))
            <div class="mb-6 p-4 rounded-lg text-white 
                {{ session('status_type') === 'success' ? 'bg-green-500' : 'bg-red-500' }}">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('perfil.actualizar') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-1">Peso (kg)</label>
                <input type="number" name="peso" value="{{ old('peso', $perfil?->peso ?? '') }}" min="1"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('peso') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-1">Objetivo</label>
                <input type="text" name="objetivo" value="{{ old('objetivo', $perfil?->objetivo ?? '') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('objetivo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

<div>
    <label class="block text-sm font-medium text-cyan-200 mb-1">Nivel</label>
    <select name="id_nivel"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">Seleccione un nivel</option>
        <option value="1" {{ old('id_nivel', $perfil?->id_nivel ?? '') == 1 ? 'selected' : '' }}>Principiante</option>
        <option value="2" {{ old('id_nivel', $perfil?->id_nivel ?? '') == 2 ? 'selected' : '' }}>Intermedio</option>
        <option value="3" {{ old('id_nivel', $perfil?->id_nivel ?? '') == 3 ? 'selected' : '' }}>Avanzado</option>
    </select>
    @error('id_nivel') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
</div>


            <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-lg bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
