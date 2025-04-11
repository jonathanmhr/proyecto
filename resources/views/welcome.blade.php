<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a PowerCore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-900 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-600 text-white py-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center px-6">
            <h1 class="text-3xl font-bold">PowerCore</h1>
            <nav>
                <a href="{{ route('login') }}" class="mr-4 text-white hover:text-blue-300">Login</a>
                <a href="{{ route('register') }}" class="mr-4 text-white hover:text-blue-300">Registrar</a>
                <a href="#servicios" class="text-white hover:text-blue-300">Servicios</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-12">
        <!-- Aquí va el componente de autenticación -->
        <x-guest-layout>
            <x-authentication-card>
                <x-slot name="logo">
                    <!-- Logo aquí -->
                    <x-authentication-card-logo />
                </x-slot>

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Correo') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        @if (Route::has('register'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                                {{ __('Registrarse') }}
                            </a>
                        @endif

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                        @endif

                        <x-button class="ms-4">
                            {{ __('Login') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </x-guest-layout>

        <!-- Servicios (solo si no estás logueado) -->
        @guest
        <section id="servicios" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-16">
            <x-card title="Entrenamiento Personalizado">
                Programa de entrenamiento adaptado a tus necesidades y objetivos.
            </x-card>
            <x-card title="Clases Grupales">
                Entrena junto a otros y comparte la motivación para alcanzar el éxito.
            </x-card>
            <x-card title="Nutrición">
                Asesoramiento nutricional para que puedas optimizar tu rendimiento.
            </x-card>
        </section>
        @endguest

        <!-- Llamada a la acción -->
        @guest
        <section class="text-center my-12">
            <h3 class="text-3xl font-semibold mb-4">¿Estás listo para comenzar?</h3>
            <p class="text-lg text-gray-600 mb-4">Únete a nuestra comunidad y empieza tu viaje hacia el bienestar.</p>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-md text-lg hover:bg-blue-700 transition-colors">Regístrate Ahora</a>
        </section>
        @endguest
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-4 text-center">
        <p>&copy; 2025 PowerCore Gym | Todos los derechos reservados</p>
    </footer>

</body>
</html>
