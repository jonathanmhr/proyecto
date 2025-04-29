<div {{ $attributes->merge(['class' => 'space-y-1']) }}>
    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-responsive-nav-link>

    @can('admin-access')
        <x-responsive-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
            {{ __('Administración') }}
        </x-responsive-nav-link>
    @endcan

    @can('entrenador-access')
        <x-responsive-nav-link href="{{ route('entrenador.dashboard') }}" :active="request()->routeIs('entrenador.*')">
            {{ __('Panel Entrenador') }}
        </x-responsive-nav-link>
    @endcan

    <x-responsive-nav-link href="{{ route('entrenador.clases.index') }}" :active="request()->routeIs('entrenador.clases.*')">
        {{ __('Clases') }}
    </x-responsive-nav-link>

    @canany(['admin_entrenador', 'entrenador-access'])
        <x-responsive-nav-link href="{{ route('entrenador.clases.create') }}" :active="request()->routeIs('entrenador.clases.create')">
            {{ __('Crear Clase') }}
        </x-responsive-nav-link>
    @endcanany
</div>
