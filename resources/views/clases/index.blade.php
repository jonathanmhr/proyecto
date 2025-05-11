<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clases Grupales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Clases Disponibles</h1>
                </div>

                <!-- Mensajes de estado -->
                @if (session('success'))
                    <div class="bg-green-500 text-white p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="bg-red-500 text-white p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @elseif(session('info'))
                    <div class="bg-blue-500 text-white p-3 rounded mb-4">
                        {{ session('info') }}
                    </div>
                @endif

                @if ($clases->isEmpty())
                    <p class="text-center text-gray-500 text-lg">No hay clases disponibles en este momento.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($clases as $clase)
                            <div x-data="{ showModal: false }"
                                class="bg-white border border-gray-200 rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $clase->nombre }}</h3>
                                <p class="text-gray-600 mb-3">{{ Str::limit($clase->descripcion, 100) }}</p>

                                <span
                                    class="inline-block bg-blue-100 text-blue-800 text-sm font-medium py-1 px-3 rounded-full mb-4">
                                    Cupos disponibles:
                                    {{ $clase->cupos_maximos - $clase->usuarios->where('pivot.estado', 'aceptado')->count() }}
                                </span>

                                @if (!$estaInscrito && !$solicitud)
                                    <button @click="showModal = true"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
                                        Unirse
                                    </button>
                                @elseif ($estaInscrito)
                                    <p class="text-green-600 font-semibold mt-2">Ya estás inscrito en esta clase.</p>
                                @elseif ($solicitud)
                                    @if ($solicitud->estado === 'pendiente')
                                        <p class="text-yellow-600 font-semibold mt-2">Tu solicitud está pendiente de
                                            aprobación por el entrenador.</p>
                                    @elseif ($solicitud->estado === 'aceptado')
                                        <p class="text-green-600 font-semibold mt-2">Tu solicitud ha sido aceptada.</p>
                                    @elseif ($solicitud->estado === 'rechazado')
                                        <p class="text-red-600 font-semibold mt-2">Tu solicitud ha sido rechazada.</p>
                                    @endif
                                @endif

                                <!-- Modal -->
                                <div x-show="showModal" x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                    <div @click.away="showModal = false"
                                        class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                                        <h2 class="text-xl font-semibold text-gray-800 mb-4">¿Deseas unirte a esta
                                            clase?</h2>
                                        <p class="text-gray-600 mb-6">Confirmarás tu participación en
                                            <strong>{{ $clase->nombre }}</strong>.
                                        </p>

                                        <div class="flex justify-end space-x-4">
                                            <button @click="showModal = false"
                                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                                                Cancelar
                                            </button>
                                            <form action="{{ route('cliente.clases.unirse', ['clase' => $clase->id_clase]) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                                                    Confirmar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin del Modal -->
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Agregar entrenamiento -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Mis Entrenamientos</h2>
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-lg">
                        <p class="text-gray-700 mb-4">Agrega un entrenamiento para programar tus actividades.</p>
                        <form action="{{ route('entrenamientos.agregar') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="nombre" class="block text-gray-700">Nombre del Entrenamiento</label>
                                <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg" required>
                            </div>
                            <div class="mb-4">
                                <label for="tipo" class="block text-gray-700">Tipo</label>
                                <select id="tipo" name="tipo" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg" required>
                                    <option value="cardio">Cardio</option>
                                    <option value="fuerza">Fuerza</option>
                                    <option value="flexibilidad">Flexibilidad</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="duracion" class="block text-gray-700">Duración (minutos)</label>
                                <input type="number" id="duracion" name="duracion" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg" required>
                            </div>
                            <div class="mb-4">
                                <label for="fecha" class="block text-gray-700">Fecha</label>
                                <input type="date" id="fecha" name="fecha" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg" required>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
                                    Agregar Entrenamiento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
