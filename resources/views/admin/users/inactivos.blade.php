<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-6">
            {{-- Título - Cambiado a texto blanco para el fondo oscuro --}}
            <h2 class="text-3xl font-semibold text-white">Usuarios inactivos (más de 7 días)</h2>
            {{-- Botón Volver al dashboard - Mismo azul consistente --}}
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                ← Volver al dashboard
            </a>
        </div>

        {{-- Contenedor de la Tabla - Fondo oscuro y borde --}}
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700"> {{-- Divisor más oscuro --}}
                <thead class="bg-gray-700"> {{-- Fondo de cabecera más oscuro --}}
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"> {{-- Texto más claro --}}
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"> {{-- Texto más claro --}}
                            Correo electrónico
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"> {{-- Texto más claro --}}
                            Última actualización
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"> {{-- Texto más claro --}}
                            Estado
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700"> {{-- Fondo de cuerpo más oscuro, divisor más oscuro --}}
                    @forelse ($inactivos as $usuario)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-white font-medium"> {{-- Texto blanco para el nombre --}}
                                {{ $usuario->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300"> {{-- Texto gris claro para detalles --}}
                                {{ $usuario->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300"> {{-- Texto gris claro para detalles --}}
                                {{ $usuario->updated_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-red-400 font-semibold"> {{-- Rojo un poco más claro para "Inactivo" --}}
                                Inactivo
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400"> {{-- Texto gris medio para el mensaje de vacío --}}
                                No hay usuarios inactivos recientes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>