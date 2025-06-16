<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white">Gestionar a <span class="text-red-500">{{ $user->name }}</span></h2>
            <p class="text-sm text-gray-400 mt-1">Asigna o elimina la participación del alumno en clases y planes nutricionales.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-700 text-white rounded-lg shadow-lg border border-green-800 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin-entrenador.alumnos.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="bg-gray-800 shadow-lg rounded-xl p-6 space-y-8 border border-gray-700">
                <div>
                    <label class="block text-white font-semibold mb-3 text-lg">Clases Asignadas</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($clases as $clase)
                            <label class="flex items-center space-x-3 bg-gray-700 p-4 rounded-lg border border-gray-600 cursor-pointer hover:bg-gray-600 transition duration-200 shadow-sm">
                                <input type="checkbox" name="clases[]" value="{{ $clase->id_clase }}"
                                    class="form-checkbox h-6 w-6 text-red-500 bg-gray-900 border-gray-600 rounded focus:ring-red-500 focus:ring-offset-gray-800 transition duration-150 ease-in-out"
                                    {{ ($user->clases && $user->clases->contains($clase->id_clase)) ? 'checked' : '' }}>
                                <span class="text-white font-medium text-base">{{ $clase->nombre }}</span>
                            </label>
                        @empty
                            <p class="text-gray-400 col-span-2 text-center py-4">No hay clases disponibles para asignar.</p>
                        @endforelse
                    </div>
                </div>

                <hr class="border-gray-700">
                <div>
                    <label class="block text-white font-semibold mb-3 text-lg">Planes Nutricionales Asignados</label>
                    <p class="text-sm text-gray-400 mb-4">Selecciona las dietas que seguirá este alumno.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($dietas as $dieta)
                            <label class="flex items-center space-x-3 bg-gray-700 p-4 rounded-lg border border-gray-600 cursor-pointer hover:bg-gray-600 transition duration-200 shadow-sm">
                                <input type="checkbox" name="dietas[]" value="{{ $dieta->id_dieta }}"
                                    class="form-checkbox h-6 w-6 text-red-500 bg-gray-900 border-gray-600 rounded focus:ring-red-500 focus:ring-offset-gray-800 transition duration-150 ease-in-out"
                                    {{ in_array($dieta->id_dieta, $dietasAsignadas) ? 'checked' : '' }}>
                                <div class="flex flex-col">
                                    <span class="text-white font-medium text-base">{{ $dieta->nombre }}</span>
                                    <span class="text-gray-400 text-xs">{{ $dieta->calorias_diarias }} kcal</span>
                                </div>
                            </label>
                        @empty
                            <p class="text-gray-400 col-span-2 text-center py-4">No hay dietas disponibles para asignar.</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                        Actualizar Asignaciones
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('admin-entrenador.alumnos.index') }}"
               class="text-gray-400 hover:text-white inline-flex items-center font-medium transition duration-200">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver a la lista de alumnos
            </a>
        </div>
    </div>
    
    @push('scripts')
    <script>
        feather.replace()
    </script>
    @endpush
</x-app-layout>