<!-- resources/views/components/sidebar.blade.php -->
<aside 
    x-data="{ expanded: false }"
    @mouseenter="expanded = true" 
    @mouseleave="expanded = false"
    class="bg-white shadow-md fixed top-0 left-0 h-screen transition-all duration-300 z-50"
    :class="expanded ? 'w-64' : 'w-16'"
>

    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b">
        <img src="/icon.svg" class="w-8 h-8" alt="Logo" />
    </div>

    <!-- Menú Cliente -->
    <nav class="flex flex-col mt-4 space-y-2 px-2">

        <x-sidebar-link href="{{ route('dashboard') }}" icon="home" label="Panel" :expanded="expanded" />
        <x-sidebar-link href="{{ route('clases.index') }}" icon="calendar" label="Clases" :expanded="expanded" />
        <x-sidebar-link href="{{ route('entrenamientos.index') }}" icon="dumbbell" label="Entrenamientos" :expanded="expanded" />
        <x-sidebar-link href="{{ route('suscripciones.index') }}" icon="credit-card" label="Suscripciones" :expanded="expanded" />

    </nav>

    <!-- Entrenador -->
    @can('gestionar-clases')
    <div class="mt-6 border-t border-gray-200 pt-4 px-2">
        <x-sidebar-link href="{{ route('entrenador.alumnos') }}" icon="users" label="Mis alumnos" :expanded="expanded" />
        <x-sidebar-link href="{{ route('clases.create') }}" icon="plus-circle" label="Crear clase" :expanded="expanded" />
    </div>
    @endcan

    <!-- Entrenador Admin -->
    @role('entrenador_admin')
    <div class="mt-6 border-t border-gray-200 pt-4 px-2">
        <x-sidebar-link href="{{ route('entrenadores.index') }}" icon="user-cog" label="Gestionar entrenadores" :expanded="expanded" />
    </div>
    @endrole

    <!-- Admin -->
    @role('admin')
    <div class="mt-6 border-t border-gray-200 pt-4 px-2">
        <x-sidebar-link href="{{ route('admin.panel') }}" icon="settings" label="Panel Admin" :expanded="expanded" />
        <x-sidebar-link href="{{ route('usuarios.index') }}" icon="users" label="Usuarios" :expanded="expanded" />
        <x-sidebar-link href="{{ route('pagos.index') }}" icon="dollar-sign" label="Pagos" :expanded="expanded" />
    </div>
    @endrole

    <!-- Cierre de sesión -->
    <form method="POST" action="{{ route('logout') }}" class="absolute bottom-0 w-full">
        @csrf
        <button class="w-full flex items-center px-4 py-3 hover:bg-gray-100">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span x-show="expanded" class="ml-3">Cerrar sesión</span>
        </button>
    </form>

</aside>
