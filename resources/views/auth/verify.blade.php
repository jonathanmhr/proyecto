<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Antes de continuar, por favor verifica tu correo electrónico.') }}
        </div>

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-button>
                    {{ __('Reenviar correo de verificación') }}
                </x-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-button>
                    {{ __('Cerrar sesión') }}
                </x-button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
