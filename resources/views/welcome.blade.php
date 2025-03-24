<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerCore - Gimnasio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Container -->
    <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-12 px-6 sm:px-8 lg:px-16">
        
        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center text-center max-w-lg">
            <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight mb-4">
                Bienvenido a <span class="text-yellow-400">PowerCore</span>
            </h1>
            <p class="text-lg sm:text-xl mb-8">
                El gimnasio que te lleva al siguiente nivel. Potencia tu entrenamiento con nosotros.
            </p>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                <!-- Log in Button -->
                <a href="{{ route('login') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
                    Iniciar sesión
                </a>

                <!-- Register Button -->
                <a href="{{ route('register') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-black text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
                    Únete hoy
                </a>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-[#1b1b18] text-white py-6 mt-8">
        <div class="text-center">
            <p>&copy; {{ date('Y') }} PowerCore. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>
