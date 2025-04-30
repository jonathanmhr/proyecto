<aside class="fixed top-4 left-4 h-[calc(100vh-2rem)] transition-all duration-300 bg-white rounded-xl shadow-md flex flex-col items-center py-4 z-50"
    :class="$store.sidebarOpen ? 'w-64' : 'w-20'">

    <!-- Logo -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}">
            <x-application-mark class="h-8 w-auto" />
        </a>
    </div>

    <!-- Menú móvil -->
    <div class="sm:hidden mb-6">
        <button @click="$store.sidebarOpen = !$store.sidebarOpen" class="text-gray-600">
            <i class="w-6 h-6" data-feather="menu"></i>
        </button>
    </div>

    <!-- Navegación principal -->
    <nav class="flex-1 w-full space-y-2 px-2">
        <!-- Enlace de Dashboard -->
        <x-sidebar-link icon="home" route="dashboard" label="Dashboard" class="group flex items-center justify-center sm:justify-start" />

        @can('cliente-access')
        <x-sidebar-link icon="calendar" route="cliente.clases.index" label="Mis Clases" class="group flex items-center justify-center sm:justify-start" />
        @endcan

        @can('admin-access')
        <!-- Aquí puedes agregar más enlaces -->
        @endcan
    </nav>

    <!-- Logout -->
    <div class="mt-auto w-full px-2 sm:block hidden">
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit"
                class="flex items-center gap-3 w-full text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-2 rounded-lg text-sm transition-all">
                <i data-feather="log-out" class="w-5 h-5"></i>
                <span class="hidden group-hover:inline">Cerrar sesión</span>
            </button>
        </form>
    </div>
</aside>
