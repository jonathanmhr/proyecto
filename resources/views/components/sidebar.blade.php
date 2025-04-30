<aside x-data="{ open: false }" class="fixed top-4 left-4 h-[calc(100vh-2rem)] transition-all duration-300 bg-white rounded-xl shadow-md flex flex-col items-center py-4 z-50"
    :class="open ? 'w-64' : 'w-20'"
    @mouseenter="open = true" @mouseleave="open = false">

    <!-- Logo -->
    <div class="mb-6 flex justify-center w-full">
        <a href="{{ route('dashboard') }}">
            <x-application-mark class="h-8 w-auto" />
        </a>
    </div>

    <!-- Menú móvil -->
    <div class="sm:hidden mb-6">
        <button @click="open = !open" class="text-gray-600">
            <i class="w-6 h-6" data-feather="menu"></i>
        </button>
    </div>

    <!-- Navegación principal -->
    <nav class="flex-1 w-full space-y-4 px-2">
        <div class="flex justify-center">
            <x-sidebar-link icon="home" route="dashboard" label="Dashboard" />
        </div>

        @can('cliente-access')
        <div class="flex justify-center">
            <x-sidebar-link icon="calendar" route="cliente.clases.index" label="Mis Clases" />
        </div>
        @endcan

        @can('admin-access')
        <div class="flex justify-center">
            <x-sidebar-link icon="users" route="admin.users.index" label="Usuarios" />
        </div>
        @endcan
    </nav>

    <!-- Logout -->
    <div class="mt-auto w-full px-2 sm:block hidden">
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit"
                class="flex items-center gap-3 w-full text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-2 rounded-lg text-sm transition-all">
                <i data-feather="log-out" class="w-5 h-5"></i>
                <span :class="open ? 'inline' : 'hidden'" class="group-hover:inline">Cerrar sesión</span>
            </button>
        </form>
    </div>
</aside>
