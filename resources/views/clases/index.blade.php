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

                    @if(auth()->user()->isAn('admin_entrenador'))
                        <a href="{{ route('admin-entrenador.clases.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg shadow transition duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Crear Clase
                        </a>
                    @endif
                </div>

                @if ($clases->isEmpty())
                    <p class="text-center text-gray-500 text-lg">No hay clases disponibles en este momento.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($clases as $clase)
                            <div x-data="{ showModal: false }"
                                 class="bg-white border border-gray-200 rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $clase->nombre }}</h3>
                                <p class="text-gray-600 mb-3">{{ Str::limit($clase->descripcion, 100) }}</p>

                                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium py-1 px-3 rounded-full mb-4">
                                    Cupos disponibles: {{ $clase->cupos_maximos - $clase->usuarios->count() }}
                                </span>

                                <button @click="showModal = true"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
                                    Unirse
                                </button>

                                <!-- Modal -->
                                <div x-show="showModal"
                                     x-cloak
                                     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                    <div @click.away="showModal = false"
                                         class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
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
                                <!-- Fin del Modal -->
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
