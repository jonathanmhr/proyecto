<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerCore - Tu gimnasio definitivo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white font-sans">
   <header class="fixed w-full z-30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center py-4 md:justify-start md:space-x-10">
      <div class="flex justify-start lg:w-0 lg:flex-1">
        <h1 class="font-bold font-Figtree text-xl md:text-2xl">
          <a href="/">
            <img src="{{ asset('images/logoRojo.png') }}" width="120px" alt="">
          </a>
        </h1>
      </div>

      <div class="-mr-2 -my-2 md:hidden">
        <button id="menu-toggle" type="button"
          class="bg-neutral-900 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-white hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500"
          aria-expanded="false" aria-controls="menu">
          <span class="sr-only">Abrir menú</span>
          <svg id="menu-icon-open" class="h-6 w-6 block" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg id="menu-icon-close" class="h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <nav class="hidden md:flex space-x-8 items-center">
        <a href="#inicio" class="text-base font-medium text-white hover:text-red-500 transition">Inicio</a>
        <a href="{{ route('tienda.index') }}" class="text-base font-medium text-white hover:text-red-500 transition">Productos</a>
        <a href="#entrenadores" class="text-base font-medium text-white hover:text-red-500 transition">Entrenadores</a>
      </nav>

      <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
        <a href="/login"
          class="whitespace-nowrap text-base font-medium text-white hover:text-white border-2 border-white hover:bg-red-600 py-2 px-4 transition-all duration-300 rounded-md">
          Iniciar sesión
        </a>
      </div>
    </div>
  </div>

  <nav id="menu"
    class="absolute top-full inset-x-0 p-2 transition transform origin-top-right md:hidden opacity-0 scale-95 pointer-events-none">
    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-neutral-800 divide-y-2 divide-neutral-700">
      <div class="pt-5 pb-6 px-5">
        <div class="space-y-6">
          <a href="#inicio" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Inicio</a>
          <a href="{{ route('tienda.index') }}" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Productos</a>
          <a href="#entrenadores" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Entrenadores</a>
        </div>
      </div>
      <div class="py-6 px-5">
        <a href="/login"
          class="block w-full text-center px-5 py-3 border-2 font-bold border-white hover:bg-red-600 text-sm transition-all duration-300 rounded-md mobile-nav-link">
          Iniciar sesión
        </a>
      </div>
    </div>
  </nav>
</header>
<script>
  const menuToggle = document.getElementById('menu-toggle');
  const menu = document.getElementById('menu');
  const menuIconOpen = document.getElementById('menu-icon-open');
  const menuIconClose = document.getElementById('menu-icon-close');
  const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

  function toggleMenu(isOpen) {
    menu.classList.toggle('opacity-0', !isOpen);
    menu.classList.toggle('scale-95', !isOpen);
    menu.classList.toggle('opacity-100', isOpen);
    menu.classList.toggle('scale-100', isOpen);
    menu.classList.toggle('pointer-events-none', !isOpen);
    menu.classList.toggle('pointer-events-auto', isOpen);

    menuIconOpen.classList.toggle('hidden', isOpen);
    menuIconOpen.classList.toggle('block', !isOpen);
    menuIconClose.classList.toggle('hidden', !isOpen);
    menuIconClose.classList.toggle('block', isOpen);

    menuToggle.setAttribute('aria-expanded', isOpen.toString());

    if (isOpen) {
      document.body.classList.add('overflow-hidden');
    } else {
      document.body.classList.remove('overflow-hidden');
    }
  }

  if (menuToggle && menu && menuIconOpen && menuIconClose) {
    menuToggle.addEventListener('click', () => {
      const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
      toggleMenu(!isExpanded);
    });

    mobileNavLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        toggleMenu(false);
      });
    });
  }
</script>
    <section id="inicio" class="min-h-screen flex items-center justify-center bg-cover bg-center relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-12 items-center">
        <div class="text-center md:text-left md:order-1">
            <h1 class="text-6xl sm:text-7xl md:text-8xl lg:text-8xl font-extrabold text-white mb-6 leading-none">
                DESAFÍA TUS <br><span class="text-red-600">LÍMITES</span>
            </h1>
            <p class="text-gray-300 text-lg sm:text-xl md:text-2xl mb-8 max-w-lg mx-auto md:mx-0">
                Transforma tu cuerpo y mente con entrenamientos efectivos, hábitos saludables y un enfoque único con tus metas físicas y personales.
            </p>
            <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                <a href="/login"
                    class="bg-red-600 border-2 border-red-600 font-bold hover:bg-red-700 hover:border-red-700 text-white py-3 px-8 text-lg rounded-md transition-all duration-300 shadow-lg hover:shadow-red-500/50">
                    Comienza ahora
                </a>
                <a href="#clases"
                    class="font-bold border-2 border-red-600 hover:bg-red-600 hover:text-white text-red-600 py-3 px-8 text-lg rounded-md transition-all duration-300">
                    Descubre más
                </a>
            </div>
        </div>

        <!-- Columna de Imágenes (Derecha) -->
        <div class="flex flex-col sm:flex-row items-center justify-center md:order-2 gap-4 sm:gap-6 md:gap-8 mt-10">
            <!-- Imagen Principal -->
            <div class="flex-shrink-0">
                <img src="{{ asset('images/grad.png') }}" alt="Decoración" class="w-full max-w-[280px] sm:max-w-xs md:max-w-sm lg:max-w-md h-auto">
            </div>
            <!-- Imagen 24h -->
            <div class="flex-shrink-0">
                <img src="{{ asset('images/24h.png') }}" alt="24h acceso" class="w-24 sm:w-28 md:w-32 lg:w-36 h-auto">
            </div>
        </div>

    </div>
</div>
</section>
    <div>
        <section id="clases" class="py-20 text-center">
            <h3 class="text-4xl font-bold mb-10">TRANSFORMATE HOY</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 max-w-6xl mx-auto p-4">
                <div class="card-item relative flex flex-col bg-slate-800 text-left rounded-lg shadow-xl overflow-hidden hover:drop-shadow-[0_4px_6px_rgba(255,0,0,0.5)] transition-all duration-300 ease-in-out">
                    <div class="card-bg-overlay absolute inset-0 bg-red-600 opacity-0 transition-opacity duration-300 ease-in-out z-0"></div>
                    <div class="relative p-6 h-full flex flex-col z-10">
                        <div class="mb-3">
                        <img class="card-icon w-10 h-10 text-red-500" src="{{ asset('images/mancuerna.png') }}" >
                    </div>
                    <h4 class="text-xl font-bold text-white mb-1">Fuerza</h4>
                    <p class="card-description text-sm text-gray-400 transition-colors duration-300 mb-5 flex-grow">
                        Mejora resistencia y potencia muscular con ejercicios específicos de fuerza.
                    </p>
                    <a href="/login" class="card-internal-link group mt-auto inline-flex items-center text-gray-300 hover:text-white focus:text-white transition-colors duration-300 font-medium text-sm">
                        <span class="link-text">Únete ahora</span>
                        <svg class="arrow-icon ml-1.5 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="card-item relative flex flex-col bg-slate-800 text-left rounded-lg shadow-xl overflow-hidden hover:drop-shadow-[0_4px_6px_rgba(255,0,0,0.5)] transition-all duration-300 ease-in-out">
                <div class="card-bg-overlay absolute inset-0 bg-red-600 opacity-0 transition-opacity duration-300 ease-in-out z-0"></div>
                <div class="relative p-6 h-full flex flex-col z-10">
                <div class="mb-3">
                    <img class="card-icon w-10 h-10 text-red-500" src="{{ asset('images/correr.png') }}" >
                </div>
                <h4 class="text-xl font-bold text-white mb-1">Cardio</h4>
                <p class="card-description text-sm text-gray-400 transition-colors duration-300 mb-5 flex-grow">
                    Mejora tu resistencia y salud cardiovascular con ejercicios de cardio.
                </p>
                <a href="/login" class="card-internal-link group mt-auto inline-flex items-center text-gray-300 hover:text-white focus:text-white transition-colors duration-300 font-medium text-sm">
                    <span class="link-text">Únete ahora</span>
                    <svg class="arrow-icon ml-1.5 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>

        <div class="card-item relative flex flex-col bg-slate-800 text-left rounded-lg shadow-xl overflow-hidden hover:drop-shadow-[0_4px_6px_rgba(255,0,0,0.5)] transition-all duration-300 ease-in-out">
            <div class="card-bg-overlay absolute inset-0 bg-red-600 opacity-0 transition-opacity duration-300 ease-in-out z-0"></div>
            <div class="relative p-6 h-full flex flex-col z-10">
                <div class="mb-3">
                    <img class="card-icon w-10 h-10 text-red-500" src="{{ asset('images/corazon.png') }}" >
                </div>
                <h4 class="text-xl font-bold text-white mb-1">Salud Activa</h4>
                <p class="card-description text-sm text-gray-400 transition-colors duration-300 mb-5 flex-grow">
                    Fortalece tu salud física y mental con ejercicios diarios que te revitalizan.
                </p>
                <a href="/login" class="card-internal-link group mt-auto inline-flex items-center text-gray-300 hover:text-white focus:text-white transition-colors duration-300 font-medium text-sm">
                    <span class="link-text">Únete ahora</span>
                    <svg class="arrow-icon ml-1.5 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>

    
        <div class="card-item relative flex flex-col bg-slate-800 text-left rounded-lg shadow-xl overflow-hidden hover:drop-shadow-[0_4px_6px_rgba(255,0,0,0.5)] transition-all duration-300 ease-in-out">
            <div class="card-bg-overlay absolute inset-0 bg-red-600 opacity-0 transition-opacity duration-300 ease-in-out z-0"></div>
            <div class="relative p-6 h-full flex flex-col z-10">
                <div class="mb-3">
                    <img class="card-icon w-10 h-10 text-red-500" src="{{ asset('images/relog.png') }}" >
                </div>
                <h4 class="text-xl font-bold text-white mb-1">Moldea tu cuerpo</h4>
                <p class="card-description text-sm text-gray-400 transition-colors duration-300 mb-5 flex-grow">
                    Transforma tu figura y mejora tu condición física con entrenamientos guiados.
                </p>
                <a href="/login" class="card-internal-link group mt-auto inline-flex items-center text-gray-300 hover:text-white focus:text-white transition-colors duration-300 font-medium text-sm">
                    <span class="link-text">Únete ahora</span>
                    <svg class="arrow-icon ml-1.5 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>

    </div>
</section>
<div class="text-center text-3xl ml-10 mr-10 mt-20 mb-20 lg:mx-20">
    <p>Haz de tu bienestar fisico y mental una prioridad con entrenamientos diseñadospara transformar tu vida y alcanzar tus objetivos</p>
</div>

<section class="relative py-16 md:py-24 bg-gray-900 text-white overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-stretch"> 
            <div class="relative order-2 md:order-1 flex flex-col justify-center items-center md:items-start text-center md:text-left p-8 py-12 md:p-16 bg-cover bg-center rounded-lg min-h-[500px] md:min-h-[650px] lg:min-h-[750px]"
                 style="background-image: url('{{ asset('images/fadeB.png') }}');">
               

                <div class="relative z-10 max-w-xl"> 
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight">
                        MEJORA TU<br class="hidden sm:block"> POTENCIAL
                    </h1>
                    <p class="text-gray-200 text-lg sm:text-xl mb-8">
                        Explora nuestros programas diseñados para llevarte al siguiente nivel físico y mental, superando cada desafío con determinación.
                    </p>
                    <a href="#tu-enlace-aqui"
                       class="inline-block bg-red-600 border-2 border-red-600 font-semibold hover:bg-red-700 hover:border-red-700 text-white py-3 px-8 text-lg rounded-md transition-all duration-300 shadow-lg hover:shadow-red-500/50 transform hover:scale-105">
                        Conoce Más
                    </a>
                </div>
            </div>

            
            <div class="relative order-1 md:order-2 flex flex-col justify-center items-center min-h-[300px] sm:min-h-[400px]">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 md:left-auto md:right-0 md:translate-x-0 md:top-[-2rem] lg:top-[-2.5rem] z-20 text-center md:text-right w-full md:w-auto px-4">
                    <h2 class="text-5xl sm:text-6xl font-bold text-red-600 tracking-tight inline-block bg-gray-900 px-3 py-1 mr-20 rounded">
                        MOTÍVATE
                    </h2>
                </div>

                <div class="w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl mx-auto mt-16 md:mt-0">
                     <img src="{{ asset('images/tio2.png') }}" alt="Hombre motivado entrenando"
                         class="w-full h-auto rounded-lg shadow-2xl object-cover">
                </div>
            </div>
        </div>
    </div>
</section>
    <section class="py-16 md:py-24 bg-gray-800 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-red-600 text-sm sm:text-base font-semibold tracking-wider uppercase">Conoce a tu Guía</h2>
            <p class="mt-2 text-4xl sm:text-5xl font-extrabold tracking-tight lg:text-6xl">
                PERSONAL TRAINER
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 items-start md:items-center">

            <div class="w-full h-full flex justify-center items-center order-1 md:order-1">
                <div class="relative w-full max-w-sm aspect-[3/4] rounded-xl overflow-hidden shadow-2xl group transform transition-all duration-300 hover:scale-105">
                    <img src="{{ asset('images/tio3.png') }}" alt="Josh, Entrenador Personal - Retrato"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
            </div>


            <div class="w-full h-full flex justify-center items-center order-2 md:order-2">
                 <div class="relative w-full max-w-sm aspect-[2/4] rounded-xl overflow-hidden shadow-2xl mt-6 md:mt-0">
                    <img src="{{ asset('images/espalda.png') }}" alt="Demostración de ejercicio de espalda por Josh"
                         class="absolute inset-0 w-full h-full object-cover">
                 
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-75 transition-opacity duration-300"></div>
                    
                </div>
            </div>

            <div class="order-3 md:order-3 text-center md:text-left mt-8 md:mt-0 px-2">
                <h3 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight text-red-600">
                    SOBRE MÍ
                </h3>
                <div class="prose prose-lg prose-invert sm:prose-xl max-w-none mx-auto md:mx-0">
                    <p>
                        Me llamo <strong class="font-semibold">Josh</strong>, y mi pasión es ser el entrenador personal que te guíe en la transformación de tu físico y en la potenciación de tu bienestar integral.
                    </p>
                    <p>
                        Mi especialidad radica en crear programas de <strong class="font-semibold">entrenamiento personalizados y altamente efectivos</strong>, diseñados meticulosamente para alinearse con tus metas individuales y llevarte más allá de lo que creías posible.
                    </p>
                    <div class="mt-8">
                        <a href="#contacto"
                           class="inline-block bg-red-600 border-2 border-red-600 font-semibold hover:bg-red-700 hover:border-red-700 text-white py-3 px-6 text-base sm:text-lg rounded-md transition-all duration-300 shadow-md hover:shadow-lg">
                            Trabajemos Juntos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
<section class="py-16 md:py-24 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Título de la Sección -->
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                PRECIOS <span class="text-red-600">SIMPLES Y TRANSPARENTES</span>
            </h2>
            <p class="mt-4 text-lg text-gray-400 max-w-xl mx-auto">
                Elige el plan que mejor se adapte a tus objetivos y comienza tu transformación hoy mismo.
            </p>
        </div>

        <!-- Grid de Planes de Precios -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">

            <!-- Plan Basic -->
            <div class="group bg-slate-800 p-8 rounded-xl shadow-xl hover:shadow-red-600/40 transition-all duration-300 ease-in-out transform hover:-translate-y-2 hover:bg-red-600 flex flex-col">
                <h3 class="text-2xl font-bold mb-1 text-white group-hover:text-white">
                    BASIC PLAN
                </h3>
                <p class="text-sm text-red-600 group-hover:text-red-200 font-medium mb-3 transition-colors">Ideal para principiantes</p>
                <img src="{{ asset('images/lineaB.png') }}" alt="Divisor" class="w-full h-px opacity-20 group-hover:opacity-30 my-4">
                <div class="my-4">
                    <span class="text-5xl font-extrabold text-white group-hover:text-white">$12</span>
                    <span class="text-xl font-semibold text-red-600 group-hover:text-red-100">/mes</span>
                </div>
                <ul class="space-y-2 text-gray-300 group-hover:text-gray-100 flex-grow mb-8 text-left text-sm sm:text-base">
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Acceso a áreas principales del gimnasio.
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Equipos básicos de cardio y pesas.
                    </li>
                     <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Perfecto para comenzar tu viaje fitness.
                    </li>
                </ul>
                <a href="#comprar-basic" class="mt-auto block w-full text-center bg-slate-600 group-hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                    Seleccionar Plan
                </a>
            </div>

            <!-- Plan Premium -->
            <div class="group bg-slate-800 p-8 rounded-xl shadow-xl hover:shadow-red-500/40 transition-all duration-300 ease-in-out transform hover:-translate-y-2 hover:bg-red-600 flex flex-col ring-2 ring-red-600 relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">MÁS POPULAR</div>
                <h3 class="text-2xl font-bold mb-1 text-white group-hover:text-white">
                    PREMIUM PLAN
                </h3>
                <p class="text-sm text-red-600 group-hover:text-red-200 font-medium mb-3 transition-colors">Resultados acelerados</p>
                <img src="{{ asset('images/lineaB.png') }}" alt="Divisor" class="w-full h-px opacity-20 group-hover:opacity-30 my-4">
                <div class="my-4">
                    <span class="text-5xl font-extrabold text-white group-hover:text-white">49</span>
                    <span class="text-xl font-semibold text-red-600 group-hover:text-red-100">/mes</span>
                </div>
                <ul class="space-y-2 text-gray-300 group-hover:text-gray-100 flex-grow mb-8 text-left text-sm sm:text-base">
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Todo lo del Plan Basic.
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Acceso a todas las clases grupales.
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Asesoramiento nutricional básico.
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Seguimiento personalizado inicial.
                    </li>
                </ul>
                 <a href="#comprar-premium" class="mt-auto block w-full text-center bg-red-600 group-hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                    Seleccionar Plan
                </a>
            </div>

            <!-- Plan Elite -->
            <div class="group bg-slate-800 p-8 rounded-xl shadow-xl hover:shadow-red-500/40 transition-all duration-300 ease-in-out transform hover:-translate-y-2 hover:bg-red-600 flex flex-col">
                <h3 class="text-2xl font-bold mb-1 text-white group-hover:text-white">
                    ELITE PLAN
                </h3>
                <p class="text-sm text-red-600 group-hover:text-red-200 font-medium mb-3 transition-colors">Experiencia VIP total</p>
                <img src="{{ asset('images/lineaB.png') }}" alt="Divisor" class="w-full h-px opacity-20 group-hover:opacity-30 my-4">
                <div class="my-4">
                    <span class="text-5xl font-extrabold text-white group-hover:text-white">€79</span>
                    <span class="text-xl font-semibold text-red-600 group-hover:text-red-100">/mes</span>
                </div>
                <ul class="space-y-2 text-gray-300 group-hover:text-gray-100 flex-grow mb-8 text-left text-sm sm:text-base">
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Todo lo del Plan Premium.
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Acceso VIP a todas las instalaciones.
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Entrenador personal privado asignado.
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Plan de nutrición completamente personalizado.
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-600 group-hover:text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Accesorios y merchandising exclusivo.
                    </li>
                </ul>
                 <a href="#comprar-elite" class="mt-auto block w-full text-center bg-slate-600 group-hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                    Seleccionar Plan
                </a>
            </div>
        </div>
    </div>
</section>

    <!-- Primera Fila de Miembros (Fondo Oscuro) -->
<section class="bg-gray-900 text-white py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Título General de la Sección (Opcional, si quieres uno arriba de todo) -->
        <!-- Si solo es "MIEMBROS" para todo, puedes ponerlo aquí -->
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
               MIEMBROS
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
            
            {{-- Carlos Rivas --}}
            <div class="text-center hover:drop-shadow-[0_4px_6px_rgba(255,0,0,0.5)] transition-all duration-300 ease-in-out">
                <img src="{{ asset('images/m1.png') }}" class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto mb-4 shadow-lg">
                <h3 class="text-lg sm:text-xl font-semibold text-red-600 mb-5">Carlos Rivas</h3>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed px-2">
                    Entrenador de alto rendimiento dedicado a maximizar la hipertrofia muscular con técnicas avanzadas
                </p>
            </div>

            {{-- Diego Moreno --}}
            <div class="text-center hover:drop-shadow-[0_4px_6px_rgba(255,0,0,0.5)] transition-all duration-300 ease-in-out"">
                <img src="{{ asset('images/m2.png') }}" class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto mb-4 shadow-lg">
                <h3 class="text-lg sm:text-xl font-semibold text-red-600 mb-5">Diego Moreno</h3>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed px-2">
                    Experto en calistenia que combina fuerza y agilidad para esculpir un físico impresionante
                </p>
            </div>

            {{-- Álex Fuentes --}}
            <div class="text-center hover:drop-shadow-[0_4px_6px_rgba(255,0,0,0.5)] transition-all duration-300 ease-in-out"">
                <img src="{{ asset('images/m3.png') }}" class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto mb-4 shadow-lg">
                <h3 class="text-lg sm:text-xl font-semibold text-red-600 mb-5">Álex Fuentes</h3>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed px-2">
                    Especialista en fuerza funcional, mezcla levantamiento de pesas y ejercicios atléticos
                </p>
            </div>
            
            {{-- Iván Serrano --}}
            <div class="text-center hover:drop-shadow-[0_4px_6px_rgba(255,0,0,0.5)] transition-all duration-300 ease-in-out"">
                <img src="{{ asset('images/m4.png') }}" class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto mb-4 shadow-lg">
                <h3 class="text-lg sm:text-xl font-semibold text-red-600 mb-5">Iván Serrano</h3>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed px-2">
                    Powerlifter competitivo que domina levantamientos pesados con técnica impecable
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Segunda Fila de Miembros (Fondo Rojo) -->
<section class="bg-gradient-to-r from-red-600 to-gray-900 text-white py-20 md:py-16 lg:py-30">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
            
            {{-- Annabel Lucinda --}}
            <div class="text-center">
                <img src="{{ asset('images/m5.png') }}" class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto mb-4 shadow-lg border-2 border-white/50">
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-5">Annabel Lucinda</h3>
                <p class="text-xs sm:text-sm text-gray-200 leading-relaxed px-2">
                    Atleta fitness que combina estética y resistencia, enfocada en entrenamiento de circuito
                </p>
            </div>

            {{-- Lucía Gómez --}}
            <div class="text-center">
                <img src="{{ asset('images/m6.png') }}" class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto mb-4 shadow-lg border-2 border-white/50">
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-5">Lucía Gómez</h3>
                <p class="text-xs sm:text-sm text-gray-200 leading-relaxed px-2">
                    Entrenadora de fuerza femenina que inspira confianza y logra resultados increíbles
                </p>
            </div>

            {{-- Sofía Martínez --}}
            <div class="text-center">
                <img src="{{ asset('images/m7.png') }}" class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto mb-4 shadow-lg border-2 border-white/50">
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-5">Sofía Martínez</h3>
                <p class="text-xs sm:text-sm text-gray-200 leading-relaxed px-2">
                    Especialista en musculación con enfoque en la construcción de fuerza mental y física
                </p>
            </div>
            
            {{-- Elena Díaz --}}
            <div class="text-center">
                <img src="{{ asset('images/m8.png') }}" class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto mb-4 shadow-lg border-2 border-white/50">
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-5">Elena Díaz</h3>
                <p class="text-xs sm:text-sm text-gray-200 leading-relaxed px-2">
                    Fanática del levantamiento olímpico, destacada por su precisión y equilibrio
                </p>
            </div>
        </div>
    </div>
</section>
<section class="py-16 md:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 xl:gap-16 items-center">

            
            <div class="grid grid-cols-2 gap-4 md:gap-6">
                <div class="space-y-4 md:space-y-6">
                    <img src="{{ asset('images/tio5.png') }}" alt="Persona entrenando intensamente" class="w-full h-auto object-cover rounded-xl shadow-lg aspect-[3/4]">
                    <img src="{{ asset('images/tio6.png') }}" alt="Entrenador asistiendo a cliente" class="w-full h-auto object-cover rounded-xl shadow-lg aspect-[3/4]">
                </div>
                <div class="mt-[10%] sm:mt-[15%]">
                    <img src="{{ asset('images/tio4.png') }}" alt="Persona enfocada en su rutina" class="w-full h-auto object-cover rounded-xl shadow-lg aspect-[3/5]">
                </div>
            </div>

            
            <div>
    <h1 class="text-5xl sm:text-6xl lg:text-8xl font-extrabold tracking-tight mb-10 md:mb-12">
        POR QUÉ<br>
        <span class="text-red-600">NOSOTROS?</span>
    </h1>
    <ul class="space-y-5">
        <li class="flex items-start text-2xl">
            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-7 h-7 mr-4 mt-1 flex-shrink-0"> 
            <span>TEN UN ENTRENAMIENTO PERSONAL</span>
        </li>
        <li class="flex items-start text-2xl">
            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-7 h-7 mr-4 mt-1 flex-shrink-0"> 
            <span>ASESORAMIENTO DE UN EXPERTO</span>
        </li>
        <li class="flex items-start text-2xl"> 
            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-7 h-7 mr-4 mt-1 flex-shrink-0"> 
            <span>ENTRENAMIENTO FLEXIBLE</span>
        </li>
        <li class="flex items-start text-2xl">
            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-7 h-7 mr-4 mt-1 flex-shrink-0"> 
            <span>RUTINAS ADAPTADAS A TI</span>
        </li>
    </ul>
</div>

        </div>
    </div>
</section>
    <footer class="bg-slate-800 text-gray-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

            <div class="md:col-span-2 lg:col-span-2">
                <a href="/" class="inline-block">
                    <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight">
                        POWER-<span class="text-red-600">CORE</span>
                    </h2>
                </a>
                <p class="mt-4 text-sm text-gray-400 leading-relaxed max-w-md">
                    Gimnasio innovador con entrenadores expertos, planes personalizados, equipo moderno y ambiente motivador. ¡Logra tus metas fitness con nosotros!
                </p>
            </div>
            <div>
                <h3 class="text-md font-semibold text-white uppercase tracking-wider mb-4">Programa</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Entrenamiento de fuerza</a></li>
                    <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Entrenamiento cardiovascular</a></li>
                    <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Entrenamiento de salud</a></li>
                    <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Moldear el cuerpo</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-md font-semibold text-white uppercase tracking-wider mb-4">Sobre nosotros</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Información de la empresa</a></li>
                    <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Área de negocios</a></li>
                    <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Miembros</a></li>
                    <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Anuncios</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 md:mt-16 pt-8 border-t border-slate-700 text-center">
            <p class="text-xs text-gray-500">
                © <script>document.write(new Date().getFullYear())</script> POWER-CORE. Todos los derechos reservados.
            </p>
           
            <div class="mt-2">
                <a href="{{ route('policy') }}" class="text-xs text-gray-500 hover:text-red-600 transition-all duration-300 mx-2">Política de Privacidad</a>
                <span class="text-gray-600">|</span>
                <a  href="{{ route('terms') }}" class="text-xs text-gray-500 hover:text-red-600 transition-all duration-300 mx-2">Términos de Servicio</a>
            </div>
        </div>
    </div>
    </footer>
</body>
</html>
