<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Gimnasio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-900">

    <!-- Header -->
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">PowerCore Gym</h1>
            <nav>
                <a href="#" class="mr-4">Inicio</a>
                <a href="#" class="mr-4">Servicios</a>
                <a href="#">Contactos</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-8">
        <section class="text-center mb-8">
            <h2 class="text-4xl font-semibold mb-4">Únete a PowerCore</h2>
            <p class="text-lg text-gray-700">Un gimnasio para alcanzar tus objetivos</p>
        </section>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Entrenamiento Personalizado</h3>
                <p>Programa de entrenamiento adaptado a tus necesidades.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Clases Grupales</h3>
                <p>Entrena junto a otros y comparte la motivación.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Nutrición</h3>
                <p>Asesoramiento nutricional para un rendimiento óptimo.</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-4 text-center">
        <p>&copy; 2025 PowerCore Gym</p>
    </footer>

</body>
</html>
