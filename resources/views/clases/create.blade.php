<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Clase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('clases.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre de la Clase</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cupos_maximos">Cupos Máximos</label>
                        <input type="number" id="cupos_maximos" name="cupos_maximos" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Crear Clase</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
