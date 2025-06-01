<x-app-layout>
    <x-slot name="header">
        {{-- Título del slot header - Cambiado a texto blanco --}}
        <h2 class="font-semibold text-xl text-white leading-tight">
            Notificaciones Enviadas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-between items-center space-x-4">
                {{-- Botón "Nueva Notificación" - Mismo azul consistente --}}
                <a href="{{ route('admin.notificaciones.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-sm transition">
                    ✉️ Nueva Notificación
                </a>

                {{-- Botón "Volver al dashboard" - Mismo gris oscuro consistente --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                    ← Volver al dashboard
                </a>
            </div>

            {{-- Contenedor principal de la tabla/mensaje --}}
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700"> {{-- Fondo oscuro y borde --}}
                @if ($notificaciones->count())
                    <table class="w-full table-auto border-collapse border border-gray-700"> {{-- Bordes de tabla más oscuros --}}
                        <thead>
                            <tr class="bg-gray-700"> {{-- Fondo de cabecera más oscuro --}}
                                <th class="border border-gray-600 px-4 py-2 text-left text-gray-300">Título</th> {{-- Bordes y texto más claros --}}
                                <th class="border border-gray-600 px-4 py-2 text-left text-gray-300">Mensaje</th> {{-- Bordes y texto más claros --}}
                                <th class="border border-gray-600 px-4 py-2 text-left text-gray-300">Fecha</th> {{-- Bordes y texto más claros --}}
                                <th class="border border-gray-600 px-4 py-2 text-left text-gray-300">Destinatarios</th> {{-- Bordes y texto más claros --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificaciones as $notificacion)
                                @php
                                    $data = json_decode($notificacion->data);
                                @endphp
                                <tr class="bg-gray-800 hover:bg-gray-700 transition-colors"> {{-- Fondo de fila oscuro con hover sutil --}}
                                    <td class="border border-gray-700 px-4 py-2 text-white">{{ $data->titulo ?? '' }}</td> {{-- Texto blanco --}}
                                    <td class="border border-gray-700 px-4 py-2 text-gray-300">{{ $data->mensaje ?? '' }}</td> {{-- Texto gris claro --}}
                                    <td class="border border-gray-700 px-4 py-2 text-gray-300"> {{-- Texto gris claro --}}
                                        {{ Carbon\Carbon::parse($notificacion->created_at)->format('d/m/Y H:i') }}</td>
                                    <td class="border border-gray-700 px-4 py-2 text-gray-300"> {{-- Texto gris claro --}}
                                        {{ $usuarios[$notificacion->notifiable_id]->name ?? 'Usuario no encontrado' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 text-white"> {{-- Paginación con texto blanco --}}
                        {{ $notificaciones->links() }}
                    </div>
                @else
                    {{-- Mensaje de "No hay notificaciones" --}}
                    <p class="text-gray-400">No hay notificaciones enviadas.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>