<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="bg-gray-900 shadow-md py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <h2 class="text-3xl font-extrabold leading-tight text-white">
                Completa tu perfil: <span class="text-red-500">{{ auth()->user()->name }}</span>
            </h2>
        </div>
    </div>

    <div class="py-8 bg-[#1a202c] min-h-screen"> {{-- Fondo oscuro general y padding vertical --}}
        <div class="max-w-4xl mx-auto bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700"> {{-- Contenedor del formulario --}}
            <form action="{{ route('perfil.guardar') }}" method="POST" autocomplete="off">
                @csrf

                <div class="space-y-6"> {{-- Agrupados los campos con espaciado consistente --}}

                    <!-- Campo Fecha de nacimiento -->
                    <div>
                        <label for="fecha_nacimiento" class="block text-white font-semibold mb-2 text-lg">Fecha de nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $perfil->fecha_nacimiento ?? '') }}" required 
                            min="1900-01-01" max="{{ now()->toDateString() }}" 
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200">
                        @error('fecha_nacimiento') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Campo Peso -->
                    <div>
                        <label for="peso" class="block text-white font-semibold mb-2 text-lg">Peso (kg)</label>
                        <input type="number" id="peso" name="peso" value="{{ old('peso', $perfil->peso ?? '') }}" min="1" max="500" required 
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200">
                        @error('peso') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Campo Altura -->
                    <div>
                        <label for="altura" class="block text-white font-semibold mb-2 text-lg">Altura (cm)</label>
                        <input type="number" id="altura" name="altura" value="{{ old('altura', $perfil->altura ?? '') }}" min="140" max="220" required 
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200">
                        @error('altura') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Campo Objetivo -->
                    <div>
                        <label for="objetivo" class="block text-white font-semibold mb-2 text-lg">Objetivo</label>
                        <textarea id="objetivo" name="objetivo" rows="4" maxlength="255" required 
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200">{{ old('objetivo', $perfil->objetivo ?? '') }}</textarea>
                        @error('objetivo') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Campo Nivel -->
                    <div>
                        <label for="id_nivel" class="block text-white font-semibold mb-2 text-lg">Nivel</label>
                        <select id="id_nivel" name="id_nivel" 
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200" required>
                            <option value="" class="bg-gray-700 text-white">Seleccione un nivel</option>
                            <option value="1" class="bg-gray-700 text-white" {{ old('id_nivel', $perfil->id_nivel ?? '') == 1 ? 'selected' : '' }}>Principiante</option>
                            <option value="2" class="bg-gray-700 text-white" {{ old('id_nivel', $perfil->id_nivel ?? '') == 2 ? 'selected' : '' }}>Intermedio</option>
                            <option value="3" class="bg-gray-700 text-white" {{ old('id_nivel', $perfil->id_nivel ?? '') == 3 ? 'selected' : '' }}>Avanzado</option>
                        </select>
                        @error('id_nivel') 
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                </div> {{-- Fin de space-y-6 --}}

                <!-- Botón de enviar -->
                <div class="mt-8 text-center"> {{-- Centrado y con más margen superior --}}
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                        Guardar Perfil
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
