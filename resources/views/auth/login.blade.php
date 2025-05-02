<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
            <div class="text-center mb-6">
                <x-application-logo class="w-12 h-12 mx-auto" />
                <h1 class="text-2xl font-bold mt-2">Bienvenido</h1>
                <h3 class="text-2xl font-bold mt-2">Iniciar sesión en tu cuenta</h3>
            </div>

            <x-validation-errors class="mb-4" />
            @if (session('status'))
                <div class="mb-4 text-green-600 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Correo -->
                <div class="mb-4 relative">
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        placeholder="Correo electrónico"
                        class="w-full px-10 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i data-feather="mail"></i>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="mb-4 relative">
                    <input id="password" name="password" type="password" required
                        placeholder="Contraseña"
                        class="w-full px-10 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i data-feather="lock"></i>
                    </div>
                    <button type="button" onclick="togglePassword('password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i data-feather="eye"></i>
                    </button>
                </div>

                <div class="flex justify-between text-sm mb-6">
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Entrar
                </button>
            </form>

            <p class="mt-6 text-center text-sm">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate</a>
            </p>
        </div>
    </div>
</x-guest-layout>
