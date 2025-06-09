<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Producto') }}
        </h2>
    </x-slot>
    <div class="container">
        <h1>Editar Producto: {{ $producto->nombre }}</h1>

        <form action="{{ route('admin.almacen.update', $producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Muestra errores de validación si existen --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $producto->sku) }}" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="">Seleccione un tipo</option>
                            @foreach($tiposDisponibles as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo', $producto->tipo) == $tipo ? 'selected' : '' }}>{{ ucfirst(strtolower($tipo)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="cantidad_disponible" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" value="{{ old('cantidad_disponible', $producto->cantidad_disponible) }}" required min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="precio_unitario" class="form-label">Precio (€)</label>
                        <input type="number" step="0.01" class="form-control" id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario', $producto->precio_unitario) }}" required min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="valoracion" class="form-label">Valoración</label>
                        <select class="form-select" id="valoracion" name="valoracion">
                            <option value="">Sin valorar</option>
                            @foreach($valoracionesDisponibles as $valor)
                                <option value="{{ $valor }}" {{ old('valoracion', $producto->valoracion) == $valor ? 'selected' : '' }}>
                                    {{ $valor }} {{ $valor == 1 ? 'estrella' : 'estrellas' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="proveedor" class="form-label">Proveedor (Opcional)</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor" value="{{ old('proveedor', $producto->proveedor) }}">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
                @if ($producto->imagen)
                    <div class="mt-2">
                        <p>Imagen actual:</p>
                        <img src="{{ Storage::url('images/' . $producto->imagen) }}" alt="Imagen actual" style="max-width: 150px; border-radius: 5px;">
                    </div>
                    <small class="form-text text-muted">Subir una nueva imagen reemplazará la actual.</small>
                @endif
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.almacen.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            </div>

        </form>
    </div>
</x-app-layout>

