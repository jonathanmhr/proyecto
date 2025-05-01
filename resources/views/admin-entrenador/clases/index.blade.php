<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                {{ session('error') }}
            </div>
        @endif


        <h1 class="text-2xl font-bold mb-6">Listado de Clases</h1>

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <!-- Botón Crear Clase (izquierda) -->
            <a href="{{ route('admin-entrenador.clases.create') }}"
                class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition w-[160px] justify-center">
                <i data-feather="plus-circle" class="w-5 h-5"></i> Crear Clase
            </a>

            <!-- Botón Volver (derecha) -->
            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="bg-green-100 hover:bg-green-200 text-green-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition w-[160px] justify-center">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Volver
            </a>
        </div>


        <div class="overflow-x-auto bg-white shadow rounded-xl p-4">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Clase</th>
                        <th class="px-4 py-2 text-left">Entrenador</th>
                        <th class="px-4 py-2 text-left">Fecha</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clases as $clase)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $clase->nombre }}</td>
                            <td class="px-4 py-2">
                                {{-- Verificar si el entrenador está asignado antes de acceder a su nombre --}}
                                {{ $clase->entrenador ? $clase->entrenador->name : 'No asignado' }}
                            </td>
                            <td class="px-4 py-2">{{ $clase->fecha }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin-entrenador.clases.edit', $clase) }}"
                                    class="text-yellow-500 hover:text-yellow-600">Editar</a>
                                <form action="{{ route('admin-entrenador.clases.destroy', $clase) }}" method="POST"
                                    class="inline-block ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
