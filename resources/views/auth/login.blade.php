<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
            <div class="flex justify-center mb-6">
                <x-application-logo class="w-12 h-12" />
            </div>
            <h2 class="text-center text-2xl font-bold mb-2">Bienvenido!</h2>
            <p class="text-center text-gray-500 mb-6">Inicia sesión en tu cuenta</p>

            <x-validation-errors class="mb-4" />
            @if (session('status'))
                <div class="mb-4 text-green-600 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4 relative">
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="Correo electrónico"
                        class="w-full px-10 py-3 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <x-icon-email />
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-4 relative">
                    <input id="password" type="password" name="password" required placeholder="Contraseña"
                        class="w-full px-10 py-3 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <x-icon-lock />
                    </div>
                    <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 inset-y-0 flex items-center text-gray-400">
                        <x-icon-eye />
                    </button>
                </div>

                {{-- Links --}}
                <div class="flex justify-between items-center text-sm mb-6">
                    <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">¿Has olvidado la contraseña?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Crear cuenta</a>
            </div>
        </div>
    </div>

    {{-- Script para mostrar/ocultar contraseña --}}
    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            const iconElement = icon.querySelector('svg');
    
            if (input.type === 'password') {
                input.type = 'text';
                iconElement.setAttribute('name', 'eye-off'); // Cambia el ícono a "ojo cerrado"
            } else {
                input.type = 'password';
                iconElement.setAttribute('name', 'eye'); // Cambia el ícono a "ojo abierto"
            }
        }
    </script>
</x-guest-layout>
