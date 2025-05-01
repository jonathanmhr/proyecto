<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Gestionar Clases de {{ $user->name }}</h2>
            <p class="text-sm text-gray-600">Asigna o elimina la participación del alumno en clases grupales.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin-entrenador.alumnos.actualizar', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="bg-white shadow rounded-xl p-6 space-y-6">

                <!-- Lista de clases -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Clases asignadas</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($clases as $clase)
                            <label class="flex items-center space-x-3 bg-gray-50 p-3 rounded border">
                                <input type="checkbox" name="clases[]" value="{{ $clase->id_clase }}"
                                    class="form-checkbox h-5 w-5 text-indigo-600"
                                    {{ $user->clases->contains($clase->id_clase) ? 'checked' : '' }}>
                                <span class="text-gray-700">{{ $clase->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Botón -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-5 rounded-lg">
                        Actualizar Clases
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-6">
            <a href="{{ route('admin-entrenador.alumnos') }}"
               class="text-sm text-indigo-600 hover:underline inline-flex items-center">
                <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Volver a la lista de alumnos
            </a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (window.feather) feather.replace();
        });
    </script>
</x-app-layout>
