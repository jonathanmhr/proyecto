@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $user = Auth::user();
@endphp

<aside x-data="{ openItem: null }" class="fixed top-4 left-4 bg-white rounded-2xl shadow-xl p-4 w-20 hover:w-64 transition-all duration-300 overflow-hidden z-50 h-[calc(100vh-2rem)] flex flex-col justify-between">
    <ul class="space-y-2">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-600 hover:bg-blue-100 hover:text-blue-600 transition">
                <i data-feather="home" class="w-5 h-5"></i>
                <span class="truncate">Dashboard</span>
            </a>
        </li>

        <!-- Menú por roles -->
        @if($user->hasRole('admin'))
            <li x-data="{ open: openItem === 'admin', toggle() { openItem = openItem === 'admin' ? null : 'admin' } }">
                <button @click="toggle" class="flex items-center space-x-3 p-3 w-full text-left rounded-xl text-gray-600 hover:bg-blue-100 hover:text-blue-600 transition">
                    <i data-feather="settings" class="w-5 h-5"></i>
                    <span class="truncate">Admin</span>
                </button>
                <ul x-show="open" x-transition class="ml-8 mt-1 space-y-1 text-sm">
                    <li><a href="{{ route('usuarios.index') }}" class="block text-gray-500 hover:text-blue-600">Usuarios</a></li>
                    <li><a href="{{ route('clases.index') }}" class="block text-gray-500 hover:text-blue-600">Clases</a></li>
                    <li><a href="{{ route('entrenadores.index') }}" class="block text-gray-500 hover:text-blue-600">Entrenadores</a></li>
                </ul>
            </li>
        @endif

        @if($user->hasRole('entrenador'))
            <li x-data="{ open: openItem === 'entrenador', toggle() { openItem = openItem === 'entrenador' ? null : 'entrenador' } }">
                <button @click="toggle" class="flex items-center space-x-3 p-3 w-full text-left rounded-xl text-gray-600 hover:bg-blue-100 hover:text-blue-600 transition">
                    <i data-feather="users" class="w-5 h-5"></i>
                    <span class="truncate">Entrenador</span>
                </button>
                <ul x-show="open" x-transition class="ml-8 mt-1 space-y-1 text-sm">
                    <li><a href="{{ route('mis.clientes') }}" class="block text-gray-500 hover:text-blue-600">Mis clientes</a></li>
                    <li><a href="{{ route('mis.clases') }}" class="block text-gray-500 hover:text-blue-600">Mis clases</a></li>
                </ul>
            </li>
        @endif

        @if($user->hasRole('cliente'))
            <li>
                <a href="{{ route('cliente.clases') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-600 hover:bg-blue-100 hover:text-blue-600 transition">
                    <i data-feather="calendar" class="w-5 h-5"></i>
                    <span class="truncate">Mis clases</span>
                </a>
            </li>
            <li>
                <a href="{{ route('cliente.suscripciones') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-600 hover:bg-blue-100 hover:text-blue-600 transition">
                    <i data-feather="credit-card" class="w-5 h-5"></i>
                    <span class="truncate">Mi suscripción</span>
                </a>
            </li>
        @endif
    </ul>

    <!-- Footer: Perfil / Logout -->
    <div class="mt-auto pt-4 border-t border-gray-200">
        <div class="flex items-center space-x-2 px-2">
            <img src="{{ $user->profile_photo_url }}" alt="Perfil" class="w-8 h-8 rounded-full object-cover">
            <div class="truncate">
                <div class="text-sm font-medium text-gray-800">{{ $user->name }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs text-red-500 hover:underline mt-1">{{ __('Cerrar sesión') }}</button>
                </form>
            </div>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        feather.replace();
    });
</script>
