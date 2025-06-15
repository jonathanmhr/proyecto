<x-app-layout>
    <x-slot name="header">
        <!-- El título del header ahora usa la clase 'text-white' para ser visible sobre un fondo oscuro -->
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Completar Perfil') }}
        </h2>
    </x-slot>

    <!-- El contenedor principal ahora tiene un fondo oscuro y padding para centrar el contenido -->
    <div class="min-h-screen bg-[#1a202c] flex items-center justify-center p-4 sm:p-6">
        <div class="container mx-auto max-w-lg p-6 rounded-lg">
            <!-- Título principal del formulario con color de texto blanco -->
            <h1 class="text-3xl font-bold text-white mb-8 text-center">
                Completa tu perfil, {{ auth()->user()->name }}.
            </h1>

            <form action="{{ route('perfil.guardar') }}" method="POST" autocomplete="off">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Campo Fecha de nacimiento -->
                    <div class="mb-4">
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-[#e53e3e] mb-1">Fecha de nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $perfil->fecha_nacimiento ?? '') }}" required 
                            min="1900-01-01" max="{{ now()->toDateString() }}" 
                            class="mt-1 block w-full rounded-md border border-gray-600 bg-gray-700 text-white 
                                   focus:ring-[#e53e3e] focus:border-[#e53e3e] sm:text-sm p-2.5">
                        @error('fecha_nacimiento') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Campo Peso -->
                    <div class="mb-4">
                        <label for="peso" class="block text-sm font-medium text-[#e53e3e] mb-1">Peso (kg)</label>
                        <input type="number" id="peso" name="peso" value="{{ old('peso', $perfil->peso ?? '') }}" min="1" max="500" required 
                            class="mt-1 block w-full rounded-md border border-gray-600 bg-gray-700 text-white 
                                   focus:ring-[#e53e3e] focus:border-[#e53e3e] sm:text-sm p-2.5">
                        @error('peso') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Campo Altura -->
                    <div class="mb-4">
                        <label for="altura" class="block text-sm font-medium text-[#e53e3e] mb-1">Altura (cm)</label>
                        <input type="number" id="altura" name="altura" value="{{ old('altura', $perfil->altura ?? '') }}" min="140" max="220" required 
                            class="mt-1 block w-full rounded-md border border-gray-600 bg-gray-700 text-white 
                                   focus:ring-[#e53e3e] focus:border-[#e53e3e] sm:text-sm p-2.5">
                        @error('altura') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Campo Objetivo -->
                    <div class="mb-4">
                        <label for="objetivo" class="block text-sm font-medium text-[#e53e3e] mb-1">Objetivo</label>
                        <textarea id="objetivo" name="objetivo" rows="4" maxlength="255" required 
                            class="mt-1 block w-full rounded-md border border-gray-600 bg-gray-700 text-white 
                                   focus:ring-[#e53e3e] focus:border-[#e53e3e] sm:text-sm p-2.5">{{ old('objetivo', $perfil->objetivo ?? '') }}</textarea>
                        @error('objetivo') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Campo Nivel -->
                    <div class="mb-4">
                        <label for="id_nivel" class="block text-sm font-medium text-[#e53e3e] mb-1">Nivel</label>
                        <select id="id_nivel" name="id_nivel" 
                            class="mt-1 block w-full rounded-md border border-gray-600 bg-gray-700 text-white 
                                   focus:ring-[#e53e3e] focus:border-[#e53e3e] sm:text-sm p-2.5" required>
                            <option value="" class="bg-gray-700 text-white">Seleccione un nivel</option>
                            <option value="1" class="bg-gray-700 text-white" {{ old('id_nivel', $perfil->id_nivel ?? '') == 1 ? 'selected' : '' }}>Principiante</option>
                            <option value="2" class="bg-gray-700 text-white" {{ old('id_nivel', $perfil->id_nivel ?? '') == 2 ? 'selected' : '' }}>Intermedio</option>
                            <option value="3" class="bg-gray-700 text-white" {{ old('id_nivel', $perfil->id_nivel ?? '') == 3 ? 'selected' : '' }}>Avanzado</option>
                        </select>
                        @error('id_nivel') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Botón Guardar -->
                    <div class="mt-6 flex justify-center">
                        <button type="submit" class="bg-[#e53e3e] text-white px-6 py-3 rounded-md font-semibold 
                                                hover:bg-[#ff4d4d] transition duration-300 ease-in-out">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
