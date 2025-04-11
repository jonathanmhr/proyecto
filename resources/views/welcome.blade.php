<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Gimnasio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Asegúrate de tener este archivo de vite -->
</head>
<body class="bg-gray-100 font-sans text-gray-900 min-h-screen">

    <!-- Header -->
    <header class="bg-blue-600 text-white p-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">PowerCore</h1>
            <nav>
                <a href="{{ route('login') }}" class="mr-4 hover:text-yellow-400">Login</a> <!-- Ruta de login -->
                <a href="{{ route('register') }}" class="mr-4 hover:text-yellow-400">Registrar</a> <!-- Ruta de registro -->
                <a href="#services" class="hover:text-yellow-400">Servicios</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-8 min-h-screen">
        <section class="text-center mb-12">
            <h2 class="text-4xl font-semibold mb-4 text-gray-800">Únete a PowerCore</h2>
            <p class="text-lg text-gray-600">Un gimnasio para alcanzar tus objetivos, con entrenamientos, nutrición y clases grupales personalizadas.</p>
        </section>

        <!-- Servicios -->
        <section id="services" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 ease-in-out">
                <h3 class="text-xl font-semibold mb-4 text-blue-600">Entrenamiento Personalizado</h3>
                <p>Programa de entrenamiento adaptado a tus necesidades, con seguimiento de progreso.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 ease-in-out">
                <h3 class="text-xl font-semibold mb-4 text-blue-600">Clases Grupales</h3>
                <p>Entrena junto a otros y comparte la motivación en nuestras clases grupales.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 ease-in-out">
                <h3 class="text-xl font-semibold mb-4 text-blue-600">Nutrición</h3>
                <p>Recibe asesoramiento nutricional para maximizar tus resultados de entrenamiento.</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-6 text-center">
        <p>&copy; 2025 PowerCore Gym. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
