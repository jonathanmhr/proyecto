<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Gimnasio PowerCore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-900 min-h-screen">

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-4xl font-bold">PowerCore</h1>
            <nav>
                <a href="{{ route('login') }}" class="mr-4 hover:text-yellow-300">Login</a> <!-- Ruta de login -->
                <a href="{{ route('register') }}" class="mr-4 hover:text-yellow-300">Registrar</a> <!-- Ruta de registro -->
                <a href="#services" class="hover:text-yellow-300">Servicios</a>
                <a href="#about" class="hover:text-yellow-300">Nosotros</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-96 text-white flex justify-center items-center relative" style="background-image: url('https://via.placeholder.com/1600x600?text=PowerCore+Gym');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="z-10 text-center">
            <h2 class="text-5xl font-bold mb-4">¡Transforma tu Cuerpo y Mente con PowerCore!</h2>
            <p class="text-lg mb-8">Un gimnasio donde tu bienestar es nuestra prioridad. ¡Únete hoy y empieza tu camino hacia un estilo de vida saludable!</p>
            <a href="{{ route('register') }}" class="bg-yellow-500 text-white px-8 py-3 rounded-full text-lg hover:bg-yellow-400">Únete Ahora</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto p-8">

        <!-- Section: Services -->
        <section id="services" class="text-center mb-16">
            <h2 class="text-4xl font-semibold mb-6 text-blue-800">Nuestros Servicios</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 ease-in-out">
                    <h3 class="text-2xl font-semibold mb-4 text-blue-600">Entrenamiento Personalizado</h3>
                    <p>Un programa de entrenamiento adaptado a tus necesidades, con un plan de progreso continuo.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 ease-in-out">
                    <h3 class="text-2xl font-semibold mb-4 text-blue-600">Clases Grupales</h3>
                    <p>Entrena junto a otros y comparte la motivación en nuestras clases dinámicas y divertidas.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 ease-in-out">
                    <h3 class="text-2xl font-semibold mb-4 text-blue-600">Nutrición</h3>
                    <p>Recibe asesoramiento nutricional para lograr una mejor recuperación y rendimiento en tus entrenamientos.</p>
                </div>
            </div>
        </section>

        <!-- Section: About Us -->
        <section id="about" class="bg-gray-200 p-12 rounded-lg mb-16">
            <h2 class="text-4xl font-semibold text-center text-blue-800 mb-6">Sobre PowerCore</h2>
            <div class="text-center">
                <p class="text-lg text-gray-700 mb-4">PowerCore es un gimnasio que va más allá del ejercicio físico. Nos enfocamos en tu salud mental, bienestar y resultados duraderos. Con entrenadores expertos, clases personalizadas y un ambiente motivador, PowerCore es el lugar ideal para que consigas tus metas.</p>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg hover:bg-blue-500">Más Información</a>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="text-center mb-16">
            <h2 class="text-4xl font-semibold mb-6 text-blue-800">Testimonios</h2>
            <div class="flex justify-center space-x-8">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs">
                    <p class="italic text-gray-600">"¡PowerCore ha cambiado mi vida! Los entrenamientos personalizados me han ayudado a alcanzar mis metas más rápido de lo que imaginaba." - Laura G.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs">
                    <p class="italic text-gray-600">"Un ambiente increíblemente motivador y un equipo de entrenadores que siempre están a tu lado. ¡Recomiendo PowerCore al 100%!" - Javier M.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs">
                    <p class="italic text-gray-600">"Las clases grupales son lo mejor. El equipo es genial y el ambiente siempre positivo. ¡No hay excusas para no entrenar!" - Ana P.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 text-center">
        <p>&copy; 2025 PowerCore Gym | Todos los derechos reservados</p>
        <p>
            <a href="#privacy" class="hover:text-yellow-300">Política de privacidad</a> | 
            <a href="#terms" class="hover:text-yellow-300">Términos y condiciones</a>
        </p>
    </footer>

</body>
</html>
