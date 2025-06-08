<div class="py-8 px-4" style="background-color: #111828;"> {{-- Fondo principal de la vista --}}
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6 text-white">
            {{ __('Historial de Perfil') }}
        </h2>

        @if ($historial->isEmpty())
            <div class="bg-gray-800 text-white p-6 rounded-lg shadow-xl">
                <p class="text-lg">{{ __('No hay historial de perfil registrado.') }}</p>
            </div>
        @else
            <div class="overflow-x-auto shadow-xl rounded-lg border" style="border-color: #3b424d; background-color: #111828;">
                <table class="min-w-full text-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider" style="background-color: #2a313b; border-bottom: 1px solid #3b424d; border-right: 1px solid #3b424d;">{{ __('Fecha de cambio') }}</th>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider" style="background-color: #2a313b; border-bottom: 1px solid #3b424d; border-right: 1px solid #3b424d;">{{ __('Fecha de nacimiento') }}</th>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider" style="background-color: #2a313b; border-bottom: 1px solid #3b424d; border-right: 1px solid #3b424d;">{{ __('Peso (kg)') }}</th>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider" style="background-color: #2a313b; border-bottom: 1px solid #3b424d; border-right: 1px solid #3b424d;">{{ __('Altura (cm)') }}</th>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider" style="background-color: #2a313b; border-bottom: 1px solid #3b424d; border-right: 1px solid #3b424d;">{{ __('Objetivo') }}</th>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase tracking-wider" style="background-color: #2a313b; border-bottom: 1px solid #3b424d;">{{ __('Nivel') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historial as $item)
                            <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                                <td class="px-4 py-3 whitespace-nowrap border-b" style="border-color: #3b424d;">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap border-b" style="border-color: #3b424d;">{{ $item->fecha_nacimiento }}</td>
                                <td class="px-4 py-3 whitespace-nowrap border-b" style="border-color: #3b424d;">{{ $item->peso }}</td>
                                <td class="px-4 py-3 whitespace-nowrap border-b" style="border-color: #3b424d;">{{ $item->altura }}</td>
                                <td class="px-4 py-3 whitespace-nowrap border-b" style="border-color: #3b424d;">{{ $item->objetivo }}</td>
                                <td class="px-4 py-3 whitespace-nowrap border-b" style="border-color: #3b424d;">
                                    @if ($item->id_nivel == 1) <span class="text-green-400">{{ __('Básico') }}</span>
                                    @elseif ($item->id_nivel == 2) <span class="text-yellow-400">{{ __('Intermedio') }}</span>
                                    @elseif ($item->id_nivel == 3) <span class="text-red-400">{{ __('Avanzado') }}</span>
                                    @else - @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>