<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notificaciones Enviadas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-between items-center space-x-4">
                <a href="{{ route('admin.notificaciones.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-sm transition">
                    ✉️Nueva Notificación
                </a>

                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                    ← Volver al dashboard
                </a>
            </div>



            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($notificaciones->count())
                    <table class="w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">Título</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Mensaje</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Fecha</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Destinatarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificaciones as $notificacion)
                                @php
                                    $data = json_decode($notificacion->data);
                                @endphp
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $data->titulo ?? '' }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $data->mensaje ?? '' }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ Carbon\Carbon::parse($notificacion->created_at)->format('d/m/Y H:i') }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $usuarios[$notificacion->notifiable_id]->name ?? 'Usuario no encontrado' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $notificaciones->links() }}
                    </div>
                @else
                    <p>No hay notificaciones enviadas.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
