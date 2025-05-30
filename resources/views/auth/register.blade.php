<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Crear una cuenta
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Empieza a disfrutar de nuestros servicios registrándote.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="rounded-md shadow-sm -space-y-px">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                        <input id="name" name="name" type="text" autocomplete="name" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            value="{{ old('name') }}" placeholder="Tu nombre completo">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            value="{{ old('email') }}" placeholder="ejemplo@correo.com">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="********">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="********">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Registrarse
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-gray-600">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-500">
                    Iniciar sesión
                </a>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('auth.google.redirect') }}"
                    class="inline-flex items-center justify-center w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none">
                        <path fill="#EA4335"
                            d="M12 11.5v3.6h5.3c-.2 1.4-1.6 4-5.3 4-3.2 0-5.8-2.7-5.8-6s2.6-6 5.8-6c1.8 0 3 0.8 3.7 1.5l2.5-2.5C16.1 5.1 14.2 4.2 12 4.2 7.5 4.2 4 7.7 4 12.3s3.5 8.1 8 8.1c4.6 0 7.6-3.2 7.6-7.8 0-.5 0-.8-.1-1.2H12z" />
                    </svg>
                    Registrarse con Google
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
