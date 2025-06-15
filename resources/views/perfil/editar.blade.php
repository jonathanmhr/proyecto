<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-slate-900 p-8 rounded-2xl shadow-xl"> {{-- CAMBIO: Fondo oscuro como en la imagen --}}
        <h2 class="text-3xl font-extrabold text-white mb-6">Editar Perfil</h2> {{-- CAMBIO: Título blanco --}}

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
                <label class="block text-sm font-medium text-gray-300 mb-1">Peso (kg)</label> {{-- CAMBIO: Texto de etiqueta gris claro --}}
                <input type="number" name="peso" value="{{ old('peso', $perfil->peso) }}" min="1"
                       class="w-full border-slate-700 bg-slate-800 text-white rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"> {{-- CAMBIO: Bordes oscuros, fondo de input oscuro, texto blanco, enfoque rojo --}}
                @error('peso') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Objetivo</label> {{-- CAMBIO: Texto de etiqueta gris claro --}}
                <input type="text" name="objetivo" value="{{ old('objetivo', $perfil->objetivo) }}"
                       class="w-full border-slate-700 bg-slate-800 text-white rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"> {{-- CAMBIO: Bordes oscuros, fondo de input oscuro, texto blanco, enfoque rojo --}}
                @error('objetivo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Nivel</label> {{-- CAMBIO: Texto de etiqueta gris claro --}}
                <select name="id_nivel"
                        class="w-full border-slate-700 bg-slate-800 text-white rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"> {{-- CAMBIO: Bordes oscuros, fondo de select oscuro, texto blanco, enfoque rojo --}}
                    <option value="">Seleccione un nivel</option>
                    <option value="1" {{ old('id_nivel', $perfil->id_nivel) == 1 ? 'selected' : '' }}>Principiante</option>
                    <option value="2" {{ old('id_nivel', $perfil->id_nivel) == 2 ? 'selected' : '' }}>Intermedio</option>
                    <option value="3" {{ old('id_nivel', $perfil->id_nivel) == 3 ? 'selected' : '' }}>Avanzado</option>
                </select>
                @error('id_nivel') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-700 mt-6"> {{-- CAMBIO: Línea divisoria gris oscuro --}}
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-lg bg-gray-700 text-gray-300 hover:bg-gray-600 transition"> {{-- CAMBIO: Botón Cancelar gris como en la imagen --}}
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition"> {{-- CAMBIO: Botón Guardar rojo como en la imagen --}}
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
