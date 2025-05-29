<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Errores de validación --}}
        <x-validation-errors class="mb-4" />

        {{-- Mensajes de estado --}}
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        {{-- Formulario de login --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Correo electrónico --}}
            <div>
                <x-label for="email" value="{{ __('Correo') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
            </div>

            {{-- Contraseña --}}
            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="current-password" />
            </div>

            {{-- Recuérdame --}}
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
                </label>
            </div>

            {{-- Acciones y enlaces --}}
            <div class="mt-6 flex flex-col gap-3">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Registrarse') }}
                        </a>
                    @endif

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif

                    <x-button class="sm:ms-auto bg-indigo-600 hover:bg-indigo-700 text-white">
                        {{ __('Login') }}
                    </x-button>
                </div>

                {{-- Botón de Google --}}
                <a href="{{ route('auth.google.redirect') }}"
                    class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 text-gray-800 font-medium py-2 px-4 rounded shadow-sm hover:bg-gray-100 transition">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                        class="w-5 h-5" alt="Google">
                    Iniciar sesión con Google
                </a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
