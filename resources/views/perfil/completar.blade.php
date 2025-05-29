<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Completar Perfil') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            Completa tu perfil, {{ auth()->user()->name }}.
        </h1>

        <form action="{{ route('perfil.guardar') }}" method="POST" autocomplete="off">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Fecha de Nacimiento -->
                <div class="mb-4">
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $perfil->fecha_nacimiento ?? '') }}" required 
                        min="1900-01-01" max="{{ now()->toDateString() }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('fecha_nacimiento') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Peso -->
                <div class="mb-4">
                    <label for="peso" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
                    <input type="number" id="peso" name="peso" value="{{ old('peso', $perfil->peso ?? '') }}" min="1" max="500" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('peso') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Altura -->
                <div class="mb-4">
                    <label for="altura" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                    <input type="number" id="altura" name="altura" value="{{ old('altura', $perfil->altura ?? '') }}" min="140" max="220" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('altura') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Objetivo -->
                <div class="mb-4">
                    <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
                    <textarea id="objetivo" name="objetivo" rows="4" maxlength="255" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('objetivo', $perfil->objetivo ?? '') }}</textarea>
                    @error('objetivo') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Nivel -->
                <div class="mb-4">
                    <label for="id_nivel" class="block text-sm font-medium text-gray-700">Nivel</label>
                    <select id="id_nivel" name="id_nivel" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="">Seleccione un nivel</option>
                        <option value="1" {{ old('id_nivel', $perfil->id_nivel ?? '') == 1 ? 'selected' : '' }}>Principiante</option>
                        <option value="2" {{ old('id_nivel', $perfil->id_nivel ?? '') == 2 ? 'selected' : '' }}>Intermedio</option>
                        <option value="3" {{ old('id_nivel', $perfil->id_nivel ?? '') == 3 ? 'selected' : '' }}>Avanzado</option>
                    </select>
                    @error('id_nivel') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Botón de guardar -->
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
