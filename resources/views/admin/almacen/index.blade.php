<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Almacen') }}
        </h2>
    </x-slot>

    <div class="container">
    <h1>Gestión de Productos de Almacén</h1>

    <div class="mb-3">
        <a href="{{ route('admin.almacen.create') }}" class="btn btn-primary">Añadir Nuevo Producto</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>SKU</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>
                            @if ($producto->imagen)
                                {{-- CAMBIO: Añadimos 'images/' a la ruta para construir la URL correcta --}}
                                <img src="{{ Storage::url('images/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" width="60" style="border-radius: 4px;">
                            @else
                                <small>Sin imagen</small>
                            @endif
                        </td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->sku }}</td>
                        <td>{{ $producto->tipo }}</td>
                        <td>{{ $producto->cantidad_disponible }}</td>
                        <td>{{ number_format($producto->precio_unitario, 2) }} €</td>
                        <td>
                            <a href="{{ route('admin.almacen.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.almacen.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay productos en el almacén.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $productos->links() }}
    </div>
</x-app-layout>