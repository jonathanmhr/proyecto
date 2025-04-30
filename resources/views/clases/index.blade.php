<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clases Grupales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class="text-3xl font-semibold text-gray-900 mb-6">Clases Disponibles</h1>

                <!-- Mostrar el botón para crear clases solo si el usuario tiene el permiso adecuado -->
                @canany(['crear_clases', 'admin_entrenador', 'entrenador'])
                    <div class="mb-6 text-right">
                        <a href="{{ route('admin-entrenador.clases.create') }}" class="inline-block bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-200">
                            Crear Clase
                        </a>                        
                    </div>
                @endcanany

                @if ($clases->isEmpty())
                    <p class="text-center text-gray-500">No hay clases disponibles en este momento.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($clases as $clase)
                            <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $clase->nombre }}</h3>
                                <p class="mt-2 text-gray-600">{{ Str::limit($clase->descripcion, 100) }}</p>
                                <div class="mt-4">
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium py-1 px-2 rounded-full">
                                        Cupos disponibles: {{ $clase->cupos_maximos - $clase->usuarios->count() }}
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <form action="{{ route('clases.unirse', $clase->id_clase) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                                            Unirse
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
