<div>
    <h2 class="text-2xl font-semibold mb-4">Historial de Perfil</h2>

    @if ($historial->isEmpty())
        <p>No hay historial registrado.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Fecha de cambio</th>
                    <th class="border px-4 py-2">Fecha de nacimiento</th>
                    <th class="border px-4 py-2">Peso (kg)</th>
                    <th class="border px-4 py-2">Altura (cm)</th>
                    <th class="border px-4 py-2">Objetivo</th>
                    <th class="border px-4 py-2">Nivel</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historial as $item)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">{{ $item->fecha_nacimiento }}</td>
                        <td class="border px-4 py-2">{{ $item->peso }}</td>
                        <td class="border px-4 py-2">{{ $item->altura }}</td>
                        <td class="border px-4 py-2">{{ $item->objetivo }}</td>
                        <td class="border px-4 py-2">
                            @if ($item->id_nivel == 1) Básico
                            @elseif ($item->id_nivel == 2) Intermedio
                            @elseif ($item->id_nivel == 3) Avanzado
                            @else - @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
