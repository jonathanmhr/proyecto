<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pedidos') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Listado de Compras</h1>
        {{-- <a href="{{ route('compras.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nueva Compra
        </a> --}}
    </div>

    @if($compras->isEmpty())
        <p class="text-gray-600">No hay compras registradas.</p>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID Compra
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                    <tr>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            #{{ $compra->id }}
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            {{ $compra->user->name ?? 'N/A' }} <br>
                            <small class="text-gray-600">{{ $compra->user->email ?? '' }}</small>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            {{ $compra->fecha_compra->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            {{ number_format($compra->total_compra, 2, ',', '.') }} €
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <span class="px-2 py-1 font-semibold leading-tight
                                @if($compra->estado == 'pagada') text-green-900 bg-green-200
                                @elseif($compra->estado == 'pendiente') text-yellow-900 bg-yellow-200
                                @elseif($compra->estado == 'cancelada') text-red-900 bg-red-200
                                @else text-gray-900 bg-gray-200
                                @endif
                                rounded-full">
                                {{ ucfirst($compra->estado) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <a href="{{ route('compras.show', $compra) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Ver
                            </a>
                            {{-- <a href="{{ route('compras.edit', $compra) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                Editar
                            </a>
                            <form action="{{ route('compras.destroy', $compra) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta compra?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    Eliminar
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $compras->links() }}
        </div>
    @endif
</div>

</x-app-layout>
