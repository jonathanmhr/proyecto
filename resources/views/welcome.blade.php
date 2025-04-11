<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Gimnasio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Asegúrate de tener el Vite integrado correctamente -->
</head>
<body class="bg-gray-100 font-sans">

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-screen" style="background-image: url('https://images.unsplash.com/photo-1506354639039-7b2d6d071121?crop=entropy&cs=tinysrgb&fit=max&ixid=MnwzNjUyOXwwfDF8c2VhY2h8NXx8Z2ltfGVufDB8fHx8fDE2Nzc0OTI2ODc&ixlib=rb-1.2.1&q=80&w=1080');">
        <div class="absolute inset-0 bg-black opacity-40"></div> <!-- Filtro oscuro para mejor legibilidad -->
        <div class="flex justify-center items-center h-full relative z-10 text-center text-white px-4">
            <div>
                <h1 class="text-5xl md:text-6xl font-extrabold mb-4">¡Bienvenido al Gimnasio!</h1>
                <p class="text-lg md:text-xl mb-6">Alcanza tus metas y transforma tu vida</p>
                <a href="#contacto" class="inline-block bg-red-600 text-white py-3 px-8 rounded-lg text-lg hover:bg-red-700 transition">Únete Ahora</a>
                <a href="{{ route('login') }}" class="inline-block bg-red-600 text-white py-3 px-8 rounded-lg text-lg hover:bg-red-700 transition">Iniciar sesion</a>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <i class="fas fa-dumbbell text-5xl text-red-600 mb-6"></i>
                    <h3 class="text-2xl font-semibold mb-3">Entrenamiento Personalizado</h3>
                    <p class="text-gray-600">Planes de entrenamiento diseñados específicamente para ti.</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-heartbeat text-5xl text-red-600 mb-6"></i>
                    <h3 class="text-2xl font-semibold mb-3">Clases Grupales</h3>
                    <p class="text-gray-600">Disfruta de clases dinámicas para todos los niveles.</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-calendar text-5xl text-red-600 mb-6"></i>
                    <h3 class="text-2xl font-semibold mb-3">Flexibilidad Horaria</h3>
                    <p class="text-gray-600">Horarios adaptados a tu ritmo de vida.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <footer id="contacto" class="bg-gray-800 text-white text-center py-8">
        <p class="text-xl mb-2">¿Listo para empezar? Contáctanos y da el primer paso</p>
        <p class="text-lg">Email: contacto@gimnasio.com | Teléfono: +34 123 456 789</p>
    </footer>

</body>
</html>
