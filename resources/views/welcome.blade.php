<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a PowerCore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans text-gray-900 min-h-screen">

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
    <main class="container mx-auto px-6 py-12">
        <section class="text-center mb-16">
            <h2 class="text-4xl font-semibold text-gray-800 mb-4">Únete a PowerCore</h2>
            <p class="text-lg text-gray-700">Un gimnasio para alcanzar tus objetivos físicos y mentales.</p>
        </section>

        <!-- Servicios -->
        <section id="servicios" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-xl font-semibold mb-4">Entrenamiento Personalizado</h3>
                <p class="text-gray-600">Programa de entrenamiento adaptado a tus necesidades y objetivos.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-xl font-semibold mb-4">Clases Grupales</h3>
                <p class="text-gray-600">Entrena junto a otros y comparte la motivación para alcanzar el éxito.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-xl font-semibold mb-4">Nutrición</h3>
                <p class="text-gray-600">Asesoramiento nutricional para que puedas optimizar tu rendimiento.</p>
            </div>
        </section>

        <!-- Llamada a la acción -->
        <section class="text-center my-12">
            <h3 class="text-3xl font-semibold mb-4">¿Estás listo para comenzar?</h3>
            <p class="text-lg text-gray-600 mb-4">Únete a nuestra comunidad y empieza tu viaje hacia el bienestar.</p>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-md text-lg hover:bg-blue-700 transition-colors">Regístrate Ahora</a>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-4 text-center">
        <p>&copy; 2025 PowerCore Gym | Todos los derechos reservados</p>
    </footer>

</body>

</html>
