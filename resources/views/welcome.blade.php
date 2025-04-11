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
    <header class="bg-blue-600 text-white py-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center px-6">
            <h1 class="text-3xl font-bold">PowerCore</h1>
            <nav>
                <a href="{{ route('login') }}" class="mr-4 text-white hover:text-blue-300">Login</a>
                <a href="{{ route('register') }}" class="mr-4 text-white hover:text-blue-300">Registrar</a>
                <a href="#servicios" class="text-white hover:text-blue-300">Servicios</a>
                <a href="#nosotros" class="text-white hover:text-blue-300">Nosotros</a>
                <a href="#contacto" class="text-white hover:text-blue-300">Contacto</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-12">
        <!-- Hero Section -->
        <section class="text-center mb-16">
            <h2 class="text-4xl font-semibold text-blue-600 mb-4">Transforma tu Cuerpo, Transforma tu Vida</h2>
            <p class="text-lg text-gray-700 mb-6">En PowerCore, te ayudamos a alcanzar tus objetivos con entrenamientos personalizados, clases grupales y asesoramiento nutricional.</p>
            <a href="#servicios" class="bg-blue-600 text-white px-6 py-2 rounded-full text-lg hover:bg-blue-700">Ver Servicios</a>
        </section>

        <!-- Servicios Section -->
        <section id="servicios" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <x-card title="Entrenamiento Personalizado">
                Programa de entrenamiento adaptado a tus necesidades y objetivos. Nuestros entrenadores te guiarán en cada paso.
            </x-card>
            <x-card title="Clases Grupales">
                Únete a nuestras clases grupales y mejora tu rendimiento en equipo. ¡La motivación es contagiosa!
            </x-card>
            <x-card title="Nutrición">
                Asesoramiento nutricional para optimizar tu salud y rendimiento. ¡Comer bien nunca fue tan fácil!
            </x-card>
        </section>

        <!-- Nosotros Section -->
        <section id="nosotros" class="bg-gray-200 py-12 mb-16">
            <h2 class="text-3xl font-semibold text-center text-blue-600 mb-6">¿Quiénes Somos?</h2>
            <div class="container mx-auto px-6 text-center">
                <p class="text-lg text-gray-700 mb-4">PowerCore es un gimnasio diseñado para ayudarte a alcanzar tus metas de salud y bienestar. Nuestra misión es brindarte un ambiente motivador, entrenadores expertos y un enfoque integral para tu bienestar físico y mental.</p>
                <p class="text-lg text-gray-700">Con instalaciones de vanguardia, programas de entrenamiento personalizados y un equipo de profesionales comprometidos, estamos aquí para ayudarte a ser la mejor versión de ti mismo.</p>
            </div>
        </section>

        <!-- Testimonios Section -->
        <section id="testimonios" class="mb-16">
            <h2 class="text-3xl font-semibold text-center text-blue-600 mb-6">Lo Que Dicen Nuestros Miembros</h2>
            <div class="container mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <p class="text-lg text-gray-700 mb-4">"PowerCore ha cambiado mi vida. Gracias a su enfoque personalizado, he perdido peso y me siento más fuerte que nunca."</p>
                    <p class="font-semibold text-blue-600">Ana García</p>
                    <p class="text-sm text-gray-500">Miembro desde 2023</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <p class="text-lg text-gray-700 mb-4">"Las clases grupales son geniales. La energía de los entrenadores y compañeros de clase me motivan a seguir adelante."</p>
                    <p class="font-semibold text-blue-600">Carlos López</p>
                    <p class="text-sm text-gray-500">Miembro desde 2022</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <p class="text-lg text-gray-700 mb-4">"El asesoramiento nutricional ha sido clave para mejorar mi rendimiento. Ahora tengo más energía para mis entrenamientos."</p>
                    <p class="font-semibold text-blue-600">María Rodríguez</p>
                    <p class="text-sm text-gray-500">Miembro desde 2024</p>
                </div>
            </div>
        </section>

        <!-- Contacto Section -->
        <section id="contacto" class="bg-blue-600 text-white py-12">
            <h2 class="text-3xl font-semibold text-center mb-6">Contáctanos</h2>
            <div class="container mx-auto px-6 text-center">
                <p class="text-lg mb-6">Si tienes alguna pregunta o quieres más información, no dudes en contactarnos. ¡Estamos aquí para ayudarte a alcanzar tus metas!</p>
                <a href="mailto:contacto@powercore.com" class="bg-white text-blue-600 px-6 py-2 rounded-full text-lg hover:bg-gray-200">Enviar Correo</a>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-4 text-center">
        <p>&copy; 2025 PowerCore Gym | Todos los derechos reservados</p>
    </footer>

</body>
</html>
