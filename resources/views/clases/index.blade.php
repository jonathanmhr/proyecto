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
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($clases as $clase)
                        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $clase->nombre }}</h3>
                            <p class="mt-2 text-gray-600">{{ $clase->descripcion }}</p>

                            <form action="{{ route('clases.unirse', $clase->id_clase) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                                    Unirse
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
