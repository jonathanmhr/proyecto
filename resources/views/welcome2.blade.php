<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerCore - Tu gimnasio definitivo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    </style>
</head>

<body class="bg-gray-900 text-white font-sans">
   <header class="fixed w-full z-30 bg-gray-900/80 backdrop-blur-md shadow-lg">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center py-4 md:justify-start md:space-x-10">
      <div class="flex justify-start lg:w-0 lg:flex-1">
        <h1 class="font-bold font-Figtree text-xl md:text-2xl">
          <a href="/">
            <img src="{{ asset('images/logoRojo.png') }}" width="120px" alt="PowerCore Logo">
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
        <a href="#servicios" class="text-base font-medium text-white hover:text-red-500 transition">Servicios</a>
        <a href="#entrenador" class="text-base font-medium text-white hover:text-red-500 transition">Entrenador</a>
        <a href="#precios" class="text-base font-medium text-white hover:text-red-500 transition">Precios</a>
        <a href="#miembros" class="text-base font-medium text-white hover:text-red-500 transition">Miembros</a>
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
    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-neutral-800/95 backdrop-blur-sm divide-y-2 divide-neutral-700">
      <div class="pt-5 pb-6 px-5">
        <div class="space-y-6">
          <a href="#inicio" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Inicio</a>
          <a href="#servicios" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Servicios</a>
          <a href="#entrenador" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Entrenador</a>
          <a href="#precios" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Precios</a>
          <a href="#miembros" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Miembros</a>
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
      if (window.innerWidth < 768) { 
        document.documentElement.classList.add('overflow-hidden'); 
      }
    } else {
      document.body.classList.remove('overflow-hidden');
      document.documentElement.classList.remove('overflow-hidden');
    }
  }

  if (menuToggle && menu && menuIconOpen && menuIconClose) {
    menuToggle.addEventListener('click', () => {
      const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
      toggleMenu(!isExpanded);
    });

    mobileNavLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        if (link.getAttribute('href').startsWith('#')) {
          toggleMenu(false); 
        }
      });
    });
  }
</script>

    <section id="inicio" class="min-h-screen flex items-center justify-center bg-cover bg-center relative pt-20 md:pt-24" style="background-image: url('{{ asset('images/tio4.png') }}');">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-70"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10 text-center">
            <img src="{{ asset('images/24h.png') }}" alt="24h acceso" class="w-20 sm:w-24 md:w-28 mx-auto mb-6 opacity-90">
            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-extrabold text-white mb-6 leading-tight">
                DESAFÍA TUS <span class="text-red-600">LÍMITES</span>
            </h1>
            <p class="text-gray-200 text-lg sm:text-xl md:text-2xl mb-10 max-w-2xl mx-auto">
                Transforma tu cuerpo y mente con entrenamientos efectivos y un enfoque único en tus metas.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/login"
                    class="bg-red-600 border-2 border-red-600 font-bold hover:bg-red-700 hover:border-red-700 text-white py-3 px-8 text-lg rounded-md transition-all duration-300 shadow-lg hover:shadow-red-500/50 transform hover:scale-105">
                    Comienza ahora
                </a>
                <a href="#servicios"
                    class="font-bold border-2 border-white hover:bg-white hover:text-gray-900 text-white py-3 px-8 text-lg rounded-md transition-all duration-300 transform hover:scale-105">
                    Descubre más
                </a>
            </div>
        </div>
    </section>

    <section id="porque-nosotros" class="py-16 md:py-24 bg-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 xl:gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-8 md:mb-10">
                        POR QUÉ<br>
                        <span class="text-red-600">ESCOGERNOS?</span>
                    </h2>
                    <ul class="space-y-5 text-lg sm:text-xl">
                        <li class="flex items-start">
                            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-6 h-6 mr-3 mt-1 flex-shrink-0">
                            <span>ENTRENAMIENTO PERSONALIZADO</span>
                        </li>
                        <li class="flex items-start">
                            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-6 h-6 mr-3 mt-1 flex-shrink-0">
                            <span>ASESORAMIENTO EXPERTO</span>
                        </li>
                        <li class="flex items-start">
                            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-6 h-6 mr-3 mt-1 flex-shrink-0">
                            <span>HORARIOS FLEXIBLES</span>
                        </li>
                        <li class="flex items-start">
                            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-6 h-6 mr-3 mt-1 flex-shrink-0">
                            <span>RUTINAS ADAPTADAS A TI</span>
                        </li>
                        <li class="flex items-start">
                            <img src="{{ asset('images/casillaTick.png') }}" alt="Tick" class="w-6 h-6 mr-3 mt-1 flex-shrink-0">
                            <span>AMBIENTE MOTIVADOR Y EQUIPO MODERNO</span>
                        </li>
                    </ul>
                     <img src="{{ asset('images/grad.png') }}" alt="Decoración gradiente" class="w-full max-w-md mt-8 opacity-60 hidden lg:block">
                </div>
                <div class="order-1 lg:order-2 grid grid-cols-2 gap-4 md:gap-6">
                    <div class="space-y-4 md:space-y-6">
                        <img src="{{ asset('images/tio5.png') }}" alt="Persona entrenando intensamente" class="w-full h-auto object-cover rounded-xl shadow-2xl aspect-[3/4] transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/tio6.png') }}" alt="Entrenador asistiendo a cliente" class="w-full h-auto object-cover rounded-xl shadow-2xl aspect-[3/4] transform hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="mt-[10%] sm:mt-[15%]">
                        <img src="{{ asset('images/tio2.png') }}" alt="Persona enfocada en su rutina" class="w-full h-auto object-cover rounded-xl shadow-2xl aspect-[3/5] transform hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="servicios" class="py-16 md:py-24 text-center bg-gray-900">
        <h3 class="text-4xl sm:text-5xl font-bold mb-12 md:mb-16">TRANSFÓRMATE HOY</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 max-w-7xl mx-auto p-4">
            <div class="card-item group relative flex flex-col bg-slate-800 text-left rounded-lg shadow-xl overflow-hidden transition-all duration-300 ease-in-out hover:shadow-red-500/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-red-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300 z-0"></div>
                <div class="relative p-6 h-full flex flex-col z-10">
                    <div class="mb-4">
                        <img class="card-icon w-12 h-12 text-red-500 group-hover:scale-110 transition-transform" src="{{ asset('images/mancuerna.png') }}" alt="Mancuerna">
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">Fuerza</h4>
                    <p class="card-description text-sm text-gray-300 group-hover:text-gray-200 transition-colors duration-300 mb-5 flex-grow">
                        Mejora resistencia y potencia muscular con ejercicios específicos de fuerza.
                    </p>
                    <a href="/login" class="card-internal-link mt-auto inline-flex items-center text-red-500 group-hover:text-red-400 focus:text-red-300 transition-colors duration-300 font-medium text-sm">
                        <span class="link-text">Únete ahora</span>
                        <svg class="arrow-icon ml-1.5 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="card-item group relative flex flex-col bg-slate-800 text-left rounded-lg shadow-xl overflow-hidden transition-all duration-300 ease-in-out hover:shadow-red-500/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-red-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300 z-0"></div>
                <div class="relative p-6 h-full flex flex-col z-10">
                    <div class="mb-4">
                        <img class="card-icon w-12 h-12 text-red-500 group-hover:scale-110 transition-transform" src="{{ asset('images/correr.png') }}" alt="Correr">
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">Cardio</h4>
                    <p class="card-description text-sm text-gray-300 group-hover:text-gray-200 transition-colors duration-300 mb-5 flex-grow">
                        Mejora tu resistencia y salud cardiovascular con ejercicios de cardio.
                    </p>
                    <a href="/login" class="card-internal-link mt-auto inline-flex items-center text-red-500 group-hover:text-red-400 focus:text-red-300 transition-colors duration-300 font-medium text-sm">
                        <span class="link-text">Únete ahora</span>
                        <svg class="arrow-icon ml-1.5 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="card-item group relative flex flex-col bg-slate-800 text-left rounded-lg shadow-xl overflow-hidden transition-all duration-300 ease-in-out hover:shadow-red-500/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-red-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300 z-0"></div>
                <div class="relative p-6 h-full flex flex-col z-10">
                    <div class="mb-4">
                        <img class="card-icon w-12 h-12 text-red-500 group-hover:scale-110 transition-transform" src="{{ asset('images/corazon.png') }}" alt="Corazón">
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">Salud Activa</h4>
                    <p class="card-description text-sm text-gray-300 group-hover:text-gray-200 transition-colors duration-300 mb-5 flex-grow">
                        Fortalece tu salud física y mental con ejercicios diarios que te revitalizan.
                    </p>
                    <a href="/login" class="card-internal-link mt-auto inline-flex items-center text-red-500 group-hover:text-red-400 focus:text-red-300 transition-colors duration-300 font-medium text-sm">
                        <span class="link-text">Únete ahora</span>
                        <svg class="arrow-icon ml-1.5 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="card-item group relative flex flex-col bg-slate-800 text-left rounded-lg shadow-xl overflow-hidden transition-all duration-300 ease-in-out hover:shadow-red-500/50 hover:-translate-y-1">
                <div class="absolute inset-0 bg-red-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300 z-0"></div>
                <div class="relative p-6 h-full flex flex-col z-10">
                    <div class="mb-4">
                        <img class="card-icon w-12 h-12 text-red-500 group-hover:scale-110 transition-transform" src="{{ asset('images/relog.png') }}" alt="Reloj">
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">Moldea tu cuerpo</h4>
                    <p class="card-description text-sm text-gray-300 group-hover:text-gray-200 transition-colors duration-300 mb-5 flex-grow">
                        Transforma tu figura y mejora tu condición física con entrenamientos guiados.
                    </p>
                    <a href="/login" class="card-internal-link mt-auto inline-flex items-center text-red-500 group-hover:text-red-400 focus:text-red-300 transition-colors duration-300 font-medium text-sm">
                        <span class="link-text">Únete ahora</span>
                        <svg class="arrow-icon ml-1.5 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center text-lg sm:text-xl text-gray-300 mt-12 md:mt-16 max-w-3xl mx-auto px-4">
            <p>Haz de tu bienestar físico y mental una prioridad con entrenamientos diseñados para transformar tu vida y alcanzar tus objetivos.</p>
        </div>
    </section>

    <section id="entrenador" class="py-16 md:py-24 bg-gray-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-red-600 text-base sm:text-lg font-semibold tracking-wider uppercase">Conoce a tu Guía</h2>
                <p class="mt-2 text-4xl sm:text-5xl font-extrabold tracking-tight lg:text-6xl">
                    TU PERSONAL TRAINER
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 md:gap-12 items-center">
                <div class="md:col-span-2 w-full flex justify-center md:justify-end">
                    <div class="relative w-full max-w-xs sm:max-w-sm aspect-[3/4] rounded-xl overflow-hidden shadow-2xl group transform transition-all duration-300 hover:scale-105">
                        <img src="{{ asset('images/tio3.png') }}" alt="Josh, Entrenador Personal - Retrato"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <h3 class="absolute bottom-4 left-4 text-2xl font-bold text-white z-10">JOSH</h3>
                    </div>
                </div>

                <div class="md:col-span-3 text-center md:text-left">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6 leading-tight">
                        <span class="text-red-600">SOBRE</span> MÍ
                    </h3>
                    <div class="prose prose-lg prose-invert sm:prose-xl max-w-none mx-auto md:mx-0 text-gray-300">
                        <p>
                            Me llamo <strong class="font-semibold text-white">Josh</strong>, y mi pasión es ser el entrenador personal que te guíe en la transformación de tu físico y en la potenciación de tu bienestar integral.
                        </p>
                        <p>
                            Mi especialidad radica en crear programas de <strong class="font-semibold text-white">entrenamiento personalizados y altamente efectivos</strong>, diseñados meticulosamente para alinearse con tus metas individuales y llevarte más allá de lo que creías posible.
                        </p>
                    </div>
                    <div class="mt-8 flex flex-col sm:flex-row items-center gap-4 md:gap-6">
                        <a href="#precios"
                           class="inline-block bg-red-600 border-2 border-red-600 font-semibold hover:bg-red-700 hover:border-red-700 text-white py-3 px-8 text-lg rounded-md transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105">
                            Ver Planes
                        </a>
                        <img src="{{ asset('images/espalda.png') }}" alt="Demostración de ejercicio de espalda por Josh"
                             class="w-48 h-auto rounded-lg shadow-xl object-cover hidden sm:block transform hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-16 md:py-24 bg-cover bg-center text-white" style="background-image: url('{{ asset('images/fadeB.png') }}');">
        <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">
                <div class="text-center md:text-left">
                    <h2 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight">
                        MEJORA TU<br class="hidden sm:block"> <span class="text-red-500">POTENCIAL</span>
                    </h2>
                    <p class="text-gray-200 text-lg sm:text-xl mb-8 max-w-lg mx-auto md:mx-0">
                        Explora nuestros programas diseñados para llevarte al siguiente nivel físico y mental, superando cada desafío con determinación.
                    </p>
                    <a href="#precios"
                       class="inline-block bg-red-600 border-2 border-red-600 font-semibold hover:bg-red-700 hover:border-red-700 text-white py-3 px-8 text-lg rounded-md transition-all duration-300 shadow-lg hover:shadow-red-500/50 transform hover:scale-105">
                        Únete y Transfórmate
                    </a>
                </div>
                <div class="flex justify-center md:justify-end">
                    <img src="{{ asset('images/tio2.png') }}" alt="Hombre motivado entrenando"
                         class="w-full max-w-md lg:max-w-lg h-auto rounded-lg shadow-2xl object-cover transform hover:scale-105 transition-transform duration-300">
                </div>
            </div>
        </div>
    </section>


    <section id="precios" class="py-16 md:py-24 bg-gray-900 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                    PRECIOS <span class="text-red-600">SIMPLES Y TRANSPARENTES</span>
                </h2>
                <p class="mt-4 text-lg text-gray-400 max-w-xl mx-auto">
                    Elige el plan que mejor se adapte a tus objetivos y comienza tu transformación hoy mismo.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="group bg-slate-800 p-8 rounded-xl shadow-xl hover:shadow-red-600/40 transition-all duration-300 ease-in-out transform hover:-translate-y-2 hover:bg-slate-700 flex flex-col">
                    <h3 class="text-2xl font-bold mb-1 text-white">
                        BASIC PLAN
                    </h3>
                    <p class="text-sm text-red-500 font-medium mb-3 transition-colors">Ideal para principiantes</p>
                    <img src="{{ asset('images/lineaB.png') }}" alt="Divisor" class="w-full h-px opacity-20 group-hover:opacity-30 my-4">
                    <div class="my-4">
                        <span class="text-5xl font-extrabold text-white">$12</span>
                        <span class="text-xl font-semibold text-red-500">/mes</span>
                    </div>
                    <ul class="space-y-3 text-gray-300 flex-grow mb-8 text-left text-sm sm:text-base">
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Acceso a áreas principales del gimnasio.
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Equipos básicos de cardio y pesas.
                        </li>
                         <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Perfecto para comenzar tu viaje fitness.
                        </li>
                    </ul>
                    <a href="/login" class="mt-auto block w-full text-center bg-slate-600 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                        Seleccionar Plan
                    </a>
                </div>

                <div class="group bg-red-600 p-8 rounded-xl shadow-2xl hover:shadow-red-700/60 transition-all duration-300 ease-in-out transform hover:-translate-y-2 flex flex-col ring-2 ring-red-400 relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-white text-red-600 text-xs font-semibold px-3 py-1 rounded-full shadow-md">MÁS POPULAR</div>
                    <h3 class="text-2xl font-bold mb-1 text-white">
                        PREMIUM PLAN
                    </h3>
                    <p class="text-sm text-red-200 font-medium mb-3 transition-colors">Resultados acelerados</p>
                    <img src="{{ asset('images/lineaB.png') }}" alt="Divisor" class="w-full h-px opacity-40 my-4">
                    <div class="my-4">
                        <span class="text-5xl font-extrabold text-white">€49</span> 
                        <span class="text-xl font-semibold text-red-100">/mes</span>
                    </div>
                    <ul class="space-y-3 text-red-50 flex-grow mb-8 text-left text-sm sm:text-base">
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Todo lo del Plan Basic.
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Acceso a todas las clases grupales.
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Asesoramiento nutricional básico.
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-100 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Seguimiento personalizado inicial.
                        </li>
                    </ul>
                     <a href="/login" class="mt-auto block w-full text-center bg-white hover:bg-red-100 text-red-600 font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                        Seleccionar Plan
                    </a>
                </div>

                <div class="group bg-slate-800 p-8 rounded-xl shadow-xl hover:shadow-red-500/40 transition-all duration-300 ease-in-out transform hover:-translate-y-2 hover:bg-slate-700 flex flex-col">
                    <h3 class="text-2xl font-bold mb-1 text-white">
                        ELITE PLAN
                    </h3>
                    <p class="text-sm text-red-500 font-medium mb-3 transition-colors">Experiencia VIP total</p>
                    <img src="{{ asset('images/lineaB.png') }}" alt="Divisor" class="w-full h-px opacity-20 group-hover:opacity-30 my-4">
                    <div class="my-4">
                        <span class="text-5xl font-extrabold text-white">€79</span>
                        <span class="text-xl font-semibold text-red-500">/mes</span>
                    </div>
                    <ul class="space-y-3 text-gray-300 flex-grow mb-8 text-left text-sm sm:text-base">
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Todo lo del Plan Premium.
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Acceso VIP a todas las instalaciones.
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Entrenador personal privado asignado.
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Plan de nutrición completamente personalizado.
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Accesorios y merchandising exclusivo.
                        </li>
                    </ul>
                     <a href="/login" class="mt-auto block w-full text-center bg-slate-600 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                        Seleccionar Plan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="miembros" class="bg-gray-800 text-white py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                   NUESTROS <span class="text-red-600">MIEMBROS</span> DESTACADOS
                </h2>
                 <p class="mt-4 text-lg text-gray-400 max-w-xl mx-auto">
                    Conoce a algunos de los atletas que confían en PowerCore para alcanzar sus metas.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12 mb-12 md:mb-16">
                <div class="text-center group p-4 rounded-lg hover:bg-slate-700/50 transition-all duration-300 ease-in-out">
                    <img src="{{ asset('images/m1.png') }}" class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover mx-auto mb-5 shadow-lg border-4 border-transparent group-hover:border-red-500 transition-all duration-300 transform group-hover:scale-105" alt="Carlos Rivas">
                    <h3 class="text-xl sm:text-2xl font-semibold text-red-500 mb-2">Carlos Rivas</h3>
                    <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                        Entrenador de alto rendimiento, maximizando la hipertrofia muscular.
                    </p>
                </div>
                <div class="text-center group p-4 rounded-lg hover:bg-slate-700/50 transition-all duration-300 ease-in-out">
                    <img src="{{ asset('images/m2.png') }}" class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover mx-auto mb-5 shadow-lg border-4 border-transparent group-hover:border-red-500 transition-all duration-300 transform group-hover:scale-105" alt="Diego Moreno">
                    <h3 class="text-xl sm:text-2xl font-semibold text-red-500 mb-2">Diego Moreno</h3>
                    <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                        Experto en calistenia, combinando fuerza y agilidad para un físico impresionante.
                    </p>
                </div>
                <div class="text-center group p-4 rounded-lg hover:bg-slate-700/50 transition-all duration-300 ease-in-out">
                    <img src="{{ asset('images/m3.png') }}" class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover mx-auto mb-5 shadow-lg border-4 border-transparent group-hover:border-red-500 transition-all duration-300 transform group-hover:scale-105" alt="Álex Fuentes">
                    <h3 class="text-xl sm:text-2xl font-semibold text-red-500 mb-2">Álex Fuentes</h3>
                    <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                        Especialista en fuerza funcional, mezcla pesas y ejercicios atléticos.
                    </p>
                </div>
                <div class="text-center group p-4 rounded-lg hover:bg-slate-700/50 transition-all duration-300 ease-in-out">
                    <img src="{{ asset('images/m4.png') }}" class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover mx-auto mb-5 shadow-lg border-4 border-transparent group-hover:border-red-500 transition-all duration-300 transform group-hover:scale-105" alt="Iván Serrano">
                    <h3 class="text-xl sm:text-2xl font-semibold text-red-500 mb-2">Iván Serrano</h3>
                    <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                        Powerlifter competitivo, domina levantamientos pesados con técnica impecable.
                    </p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-600 via-red-700 to-red-800 p-8 md:p-12 rounded-xl shadow-2xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                    <div class="text-center group">
                        <img src="{{ asset('images/m5.png') }}" class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover mx-auto mb-5 shadow-lg border-4 border-white/70 group-hover:border-white transition-all duration-300 transform group-hover:scale-105" alt="Annabel Lucinda">
                        <h3 class="text-xl sm:text-2xl font-semibold text-white mb-2">Annabel Lucinda</h3>
                        <p class="text-sm sm:text-base text-red-100 leading-relaxed">
                            Atleta fitness, combina estética y resistencia con entrenamiento de circuito.
                        </p>
                    </div>
                    <div class="text-center group">
                        <img src="{{ asset('images/m6.png') }}" class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover mx-auto mb-5 shadow-lg border-4 border-white/70 group-hover:border-white transition-all duration-300 transform group-hover:scale-105" alt="Lucía Gómez">
                        <h3 class="text-xl sm:text-2xl font-semibold text-white mb-2">Lucía Gómez</h3>
                        <p class="text-sm sm:text-base text-red-100 leading-relaxed">
                            Entrenadora de fuerza femenina que inspira confianza y logra resultados.
                        </p>
                    </div>
                    <div class="text-center group">
                        <img src="{{ asset('images/m7.png') }}" class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover mx-auto mb-5 shadow-lg border-4 border-white/70 group-hover:border-white transition-all duration-300 transform group-hover:scale-105" alt="Sofía Martínez">
                        <h3 class="text-xl sm:text-2xl font-semibold text-white mb-2">Sofía Martínez</h3>
                        <p class="text-sm sm:text-base text-red-100 leading-relaxed">
                            Especialista en musculación, enfocada en construir fuerza mental y física.
                        </p>
                    </div>
                    <div class="text-center group">
                        <img src="{{ asset('images/m8.png') }}" class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover mx-auto mb-5 shadow-lg border-4 border-white/70 group-hover:border-white transition-all duration-300 transform group-hover:scale-105" alt="Elena Díaz">
                        <h3 class="text-xl sm:text-2xl font-semibold text-white mb-2">Elena Díaz</h3>
                        <p class="text-sm sm:text-base text-red-100 leading-relaxed">
                            Fanática del levantamiento olímpico, destacada por su precisión y equilibrio.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="bg-slate-800 text-gray-300 border-t-4 border-red-600">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

            <div class="md:col-span-2 lg:col-span-2">
                <a href="/" class="inline-block mb-4">
                     <img src="{{ asset('images/logoRojo.png') }}" width="150px" alt="PowerCore Logo">
                </a>
                <p class="text-sm text-gray-400 leading-relaxed max-w-md">
                    Gimnasio innovador con entrenadores expertos, planes personalizados, equipo moderno y ambiente motivador. ¡Logra tus metas fitness con nosotros!
                </p>
            </div>
            <div>
                <h3 class="text-md font-semibold text-white uppercase tracking-wider mb-4">Programa</h3>
                <ul class="space-y-2">
                    <li><a href="#servicios" class="text-sm hover:text-red-500 transition-colors duration-200">Entrenamiento de fuerza</a></li>
                    <li><a href="#servicios" class="text-sm hover:text-red-500 transition-colors duration-200">Entrenamiento cardiovascular</a></li>
                    <li><a href="#servicios" class="text-sm hover:text-red-500 transition-colors duration-200">Entrenamiento de salud</a></li>
                    <li><a href="#servicios" class="text-sm hover:text-red-500 transition-colors duration-200">Moldear el cuerpo</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-md font-semibold text-white uppercase tracking-wider mb-4">Enlaces Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="#entrenador" class="text-sm hover:text-red-500 transition-colors duration-200">Nuestro Entrenador</a></li>
                    <li><a href="#precios" class="text-sm hover:text-red-500 transition-colors duration-200">Planes y Precios</a></li>
                    <li><a href="#miembros" class="text-sm hover:text-red-500 transition-colors duration-200">Miembros</a></li>
                    <li><a href="/login" class="text-sm hover:text-red-500 transition-colors duration-200">Iniciar Sesión</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 md:mt-16 pt-8 border-t border-slate-700 text-center">
            <p class="text-xs text-gray-500">
                © <script>document.write(new Date().getFullYear())</script> POWER-CORE. Todos los derechos reservados.
            </p>
            <div class="mt-2">
                <a href="/terms" class="text-xs text-gray-500 hover:text-red-500 transition-all duration-300 mx-2">Política de Privacidad</a>
                <span class="text-gray-600">|</span>
                <a href="/policy" class="text-xs text-gray-500 hover:text-red-500 transition-all duration-300 mx-2">Términos de Servicio</a>
            </div>
        </div>
    </div>
    </footer>
</body>
</html>