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
                <div class="mb-4">
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-red-600">Fecha de nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $perfil->fecha_nacimiento ?? '') }}" required 
                        min="1900-01-01" max="{{ now()->toDateString() }}" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                               focus:ring-blue-500 focus:border-blue-500 sm:text-sm"> {{-- CAMBIO AQUÍ: focus:ring-blue-500 y focus:border-blue-500 --}}
                    @error('fecha_nacimiento') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="peso" class="block text-sm font-medium text-red-600">Peso (kg)</label>
                    <input type="number" id="peso" name="peso" value="{{ old('peso', $perfil->peso ?? '') }}" min="1" max="500" required 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                               focus:ring-blue-500 focus:border-blue-500 sm:text-sm"> {{-- CAMBIO AQUÍ: focus:ring-blue-500 y focus:border-blue-500 --}}
                    @error('peso') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="altura" class="block text-sm font-medium text-red-600">Altura (cm)</label>
                    <input type="number" id="altura" name="altura" value="{{ old('altura', $perfil->altura ?? '') }}" min="140" max="220" required 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                               focus:ring-blue-500 focus:border-blue-500 sm:text-sm"> {{-- CAMBIO AQUÍ: focus:ring-blue-500 y focus:border-blue-500 --}}
                    @error('altura') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="objetivo" class="block text-sm font-medium text-red-600">Objetivo</label>
                    <textarea id="objetivo" name="objetivo" rows="4" maxlength="255" required 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                               focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('objetivo', $perfil->objetivo ?? '') }}</textarea> {{-- CAMBIO AQUÍ: focus:ring-blue-500 y focus:border-blue-500 --}}
                    @error('objetivo') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="id_nivel" class="block text-sm font-medium text-red-600">Nivel</label>
                    <select id="id_nivel" name="id_nivel" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                               focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required> {{-- CAMBIO AQUÍ: focus:ring-blue-500 y focus:border-blue-500 --}}
                        <option value="">Seleccione un nivel</option>
                        <option value="1" {{ old('id_nivel', $perfil->id_nivel ?? '') == 1 ? 'selected' : '' }}>Principiante</option>
                        <option value="2" {{ old('id_nivel', $perfil->id_nivel ?? '') == 2 ? 'selected' : '' }}>Intermedio</option>
                        <option value="3" {{ old('id_nivel', $perfil->id_nivel ?? '') == 3 ? 'selected' : '' }}>Avanzado</option>
                    </select>
                    @error('id_nivel') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>