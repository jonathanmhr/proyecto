<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clases Grupales Disponibles') }}
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
                @endif

                <!-- Lista de Clases -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($clases as $clase)
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-md">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $clase->nombre }}</h3>
                            <p class="text-gray-600 mb-3">{{ Str::limit($clase->descripcion, 100) }}</p>

                            <span
                                class="inline-block bg-blue-100 text-blue-800 text-sm font-medium py-1 px-3 rounded-full mb-4">
                                Cupos disponibles:
                                {{ $clase->cupos_maximos - $clase->usuarios->where('pivot.estado', 'aceptado')->count() }}
                            </span>

                            @if ($clase->inscrito)
                                <p class="text-green-600 font-semibold mt-2">Ya estás inscrito en esta clase.</p>
                            @elseif ($clase->solicitud_pendiente)
                                <p class="text-yellow-600 font-semibold mt-2">Tu solicitud está pendiente de aprobación.
                                </p>
                            @elseif ($clase->revocado)
                                <p class="text-red-600 font-semibold mt-2">No puedes unirte a esta clase porque te han
                                    revocado de la inscripción.</p>
                            @else
                                <form action="{{ route('clases.unirse', ['clase' => $clase->id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                                        Solicitar Unirse
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
