<x-app-layout>

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Panel General - Admin Entrenador</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Total de clases -->
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Clases</h2>
            <p class="text-3xl font-bold text-blue-500">{{ $totalClases }}</p>
        </div>

        <!-- Total de entrenadores -->
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Entrenadores</h2>
            <p class="text-3xl font-bold text-green-500">{{ $totalEntrenadores }}</p>
        </div>

        <!-- Total de alumnos -->
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Alumnos</h2>
            <p class="text-3xl font-bold text-purple-500">{{ $totalAlumnos }}</p>
        </div>
    </div>

    <!-- Sección rápida de accesos -->
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-4">Accesos rápidos</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin-entrenador.clases.index') }}"
               class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition">
                <i data-feather="clipboard-list" class="w-5 h-5"></i> Gestionar Clases
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="bg-green-100 hover:bg-green-200 text-green-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition">
                <i data-feather="users" class="w-5 h-5"></i> Gestionar Usuarios
            </a>
        </div>
    </div>
</div>
@endsection

</x-app-layout>