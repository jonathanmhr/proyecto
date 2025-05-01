<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach ($clases as $clase)
        <div x-data="{ showModal: false }" class="bg-white border border-gray-200 rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300">
            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $clase->nombre }}</h3>
            <p class="text-gray-600 mb-3">{{ Str::limit($clase->descripcion, 100) }}</p>

            <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium py-1 px-3 rounded-full mb-4">
                Cupos disponibles: {{ $clase->cupos_maximos - $clase->usuarios->count() }}
            </span>

            <!-- Botón que abre el modal -->
            <button @click="showModal = true"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
                Unirse
            </button>

            <!-- Modal -->
            <div x-show="showModal" style="display: none;"
                class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">¿Deseas unirte a esta clase?</h2>
                    <p class="text-gray-600 mb-6">Confirmarás tu participación en <strong>{{ $clase->nombre }}</strong>.</p>

                    <div class="flex justify-end space-x-4">
                        <button @click="showModal = false"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                            Cancelar
                        </button>

                        <form action="{{ route('clases.unirse', $clase->id_clase) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                                Confirmar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
