<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Gimnasio</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Reset de estilos */
        body, h1, h2, h3, p, ul, li {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            overflow-x: hidden;
        }

        /* Hero Section (imagen de fondo y texto centrado) */
        .hero {
            background-image: url('https://images.pexels.com/photos/531880/pexels-photo-531880.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        /* Fondo oscuro para el texto */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Sombra oscura para el texto */
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            z-index: 1;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            z-index: 1;
        }

        .cta-button {
            background-color: #ff6f61;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            z-index: 1;
        }

        .cta-button:hover {
            background-color: #e65c4b;
        }

        /* Servicios */
        .services {
            display: flex;
            justify-content: space-around;
            padding: 50px 0;
            background-color: #fff;
            flex-wrap: wrap;
        }

        .services div {
            text-align: center;
            width: 30%;
            margin-bottom: 30px;
        }

        .services div i {
            font-size: 3rem;
            color: #ff6f61;
            margin-bottom: 20px;
        }

        .services div h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .services div p {
            font-size: 1rem;
            color: #555;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }

        /* Media Queries para adaptabilidad */
        @media (max-width: 1024px) {
            .hero h1 {
                font-size: 3rem;
            }

            .hero p {
                font-size: 1.2rem;
            }

            .services div {
                width: 45%;
            }

            .cta-button {
                font-size: 1rem;
                padding: 12px 25px;
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .services div {
                width: 100%;
                margin-bottom: 20px;
            }

            .cta-button {
                font-size: 1rem;
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .cta-button {
                font-size: 0.9rem;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1>¡Bienvenido al Gimnasio!</h1>
            <p>Alcanza tus metas y transforma tu vida</p>
            <a href="#contact" class="cta-button">Únete Ahora</a>
            <!-- <a href="{{ route('login') }}" class="text-white hover:text-gray-200"> Iniciar sesión</a> -->
        </div>
    </section>

    <!-- Servicios -->
    <section class="services">
        <div>
            <i class="fas fa-dumbbell"></i>
            <h3>Entrenamiento Personalizado</h3>
            <p>Planes de entrenamiento diseñados específicamente para ti.</p>
        </div>
        <div>
            <i class="fas fa-heartbeat"></i>
            <h3>Clases Grupales</h3>
            <p>Disfruta de clases dinámicas para todos los niveles.</p>
        </div>
        <div>
            <i class="fas fa-calendar"></i>
            <h3>Flexibilidad Horaria</h3>
            <p>Horarios adaptados a tu ritmo de vida.</p>
        </div>
    </section>

    <!-- Contacto -->
    <footer>
        <p>¿Listo para empezar? Contáctanos y da el primer paso</p>
        <p>Email: contacto@gimnasio.com | Teléfono: +34 123 456 789</p>
    </footer>

</body>
</html>
