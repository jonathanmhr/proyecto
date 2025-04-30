<aside x-data="{ open: false }"
    class="fixed top-4 left-4 h-[calc(100vh-2rem)] transition-all duration-300 bg-white rounded-xl shadow-md flex flex-col items-center py-4 z-50"
    :class="open ? 'w-64' : 'w-20'" @mouseenter="open = true" @mouseleave="open = false">

    <!-- Logo -->
    <div class="mb-6">
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
    <nav class="flex-1 w-full space-y-2 px-2">
        <x-sidebar-link icon="home" route="dashboard" label="Dashboard" />

        @can('cliente-access')
            <x-sidebar-link icon="calendar" route="cliente.clases.index" label="Mis Clases" />
        @endcan

        @can('admin-access')
            <x-sidebar-link icon="users" route="admin.users.index" label="Usuarios" />
        @endcan
    </nav>

    <!-- Ajustes de perfil -->
    <div class="w-full px-2">
        <a href="{{ route('profile.show') }}""
            class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all group">
            <i data-feather="settings" class="w-5 h-5"></i>
            <span class="hidden group-hover:inline sm:inline">Ajustes</span>
        </a>
    </div>

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
