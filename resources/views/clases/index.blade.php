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
                        <a href="{{ route('admin-entrenador.clases.create') }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg shadow transition duration-200">
                            Crear Clase
                        </a>
                    @endif
                </div>

                @foreach($clases as $clase)
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $clase->nombre }}</h3>
                        <p class="text-gray-600 mb-3">{{ $clase->descripcion }}</p>
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium py-1 px-3 rounded-full mb-4">
                            Cupos disponibles: {{ $clase->cupos_maximos - $clase->usuarios->count() }}
                        </span>

                        @if(auth()->user()->isA('cliente'))
                            <form action="{{ route('cliente.clases.unirse', $clase->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
                                    Unirse
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
