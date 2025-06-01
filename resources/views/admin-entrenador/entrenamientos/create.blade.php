<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            {{ __('Crear Entrenamiento') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro --}}
    <div class="py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin-entrenador.entrenamientos.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md mb-6">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>

            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
                <form method="POST" action="{{ route('admin-entrenador.entrenamientos.store') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-700 border border-red-800 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-6">
                        <div class="mb-4">
                            <label for="nombre" class="block text-white font-semibold mb-2">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                                class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                        </div>

                        <div class="mb-4">
                            <label for="tipo" class="block text-white font-semibold mb-2">Tipo</label>
                            <input type="text" name="tipo" id="tipo" value="{{ old('tipo') }}"
                                class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                        </div>

                        <div class="mb-4">
                            <label for="duracion" class="block text-white font-semibold mb-2">Duración (min)</label>
                            <input type="number" name="duracion" id="duracion" value="{{ old('duracion') }}"
                                class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                        </div>

                        <div class="mb-4">
                            <label for="fecha" class="block text-white font-semibold mb-2">Fecha</label>
                            <input type="date" name="fecha" id="fecha" value="{{ old('fecha') }}"
                                min="{{ now()->format('Y-m-d') }}" max="{{ now()->addMonths(6)->format('Y-m-d') }}" {{-- Example: 6 months in future --}}
                                class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-red-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-red-700 shadow-md transition duration-200 transform hover:scale-105">
                                Crear
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (window.feather) {
                    feather.replace();
                }

                const fechaInput = document.getElementById('fecha');
                const hoy = new Date();
                const maxFecha = new Date();
                maxFecha.setMonth(hoy.getMonth() + 6); // Set max date 6 months from now

                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                };

                fechaInput.min = formatDate(hoy);
                fechaInput.max = formatDate(maxFecha);
            });
        </script>
    @endpush
</x-app-layout>
