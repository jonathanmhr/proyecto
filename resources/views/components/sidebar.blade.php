<aside x-data="{ open: false }" class="fixed top-4 left-4 h-[calc(100vh-2rem)] w-20 sm:w-64 hover:w-64 transition-all duration-300 bg-white rounded-xl shadow-md flex flex-col items-center py-4 group z-50">
    <!-- Logo -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}">
            <x-application-mark class="h-8 w-auto" />
        </a>
    </div>

    <!-- Menú en Móviles: Botón de Menú Hamburguesa -->
    <div class="sm:hidden mb-6">
        <button @click="open = !open" class="text-gray-600">
            <i class="w-6 h-6" data-feather="menu"></i>
        </button>
    </div>

    <!-- Menú Desplegable: Pantalla Móvil -->
    <div x-show="open" x-transition class="sm:hidden w-full space-y-2 px-2 mt-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg transition-all">
            <i data-feather="home" class="w-5 h-5"></i>
            <span class="text-sm">Dashboard</span>
        </a>

        <!-- CLIENTE -->
        @can('cliente-access')
        <a href="{{ route('cliente.clases.index') }}" class="flex items-center gap-3 text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg transition-all">
            <i data-feather="calendar" class="w-5 h-5"></i>
            <span class="text-sm">Mis Clases</span>
        </a>
        @endcan

        <!-- Perfil / Logout -->
        <div class="mt-4 px-2">
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-2 rounded-lg text-sm transition-all">
                    <i data-feather="log-out" class="w-5 h-5"></i>
                    <span class="text-sm">Cerrar sesión</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Menú en Pantallas Grandes (Desplegado) -->
    <nav class="flex-1 w-full space-y-2 px-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg transition-all group-hover:justify-start">
            <i data-feather="home" class="w-5 h-5"></i>
            <span class="hidden sm:inline text-sm">Dashboard</span>
        </a>

        <!-- ADMIN -->
        @can('admin-access')
        <div x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center w-full gap-3 text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg transition-all">
                <i data-feather="settings" class="w-5 h-5"></i>
                <span class="hidden sm:inline text-sm">Administración</span>
            </button>
            <div x-show="open" class="mt-1 ml-8 space-y-1">
                <a href="{{ route('admin.users.index') }}" class="block text-gray-500 hover:text-blue-600 text-sm">Usuarios</a>
            </div>
        </div>
        @endcan

        <!-- CLIENTE -->
        @can('cliente-access')
        <a href="{{ route('cliente.clases.index') }}" class="flex items-center gap-3 text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg transition-all">
            <i data-feather="calendar" class="w-5 h-5"></i>
            <span class="hidden sm:inline text-sm">Mis Clases</span>
        </a>
        @endcan
    </nav>

    <!-- Perfil / Logout -->
    <div class="mt-auto w-full px-2 sm:block hidden">
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-2 rounded-lg text-sm transition-all">
                <i data-feather="log-out" class="w-5 h-5"></i>
                <span class="hidden group-hover:inline">Cerrar sesión</span>
            </button>
        </form>
    </div>
</aside>
