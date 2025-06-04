<x-guest-layout>
    <header class="fixed w-full z-30 bg-gray-900/80 backdrop-blur-sm shadow-md">
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
                    <a href="/#inicio" class="text-base font-medium text-white hover:text-red-500 transition">Inicio</a>
                    <a href="/#clases" class="text-base font-medium text-white hover:text-red-500 transition">Productos</a>
                    <a href="/#entrenadores" class="text-base font-medium text-white hover:text-red-500 transition">Entrenadores</a>
                </nav>

                <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                    <a href="{{ route('login') }}" {{-- Usar route() si está definida --}}
                        class="whitespace-nowrap text-base font-medium text-white hover:text-white border-2 border-white hover:bg-red-600 py-2 px-4 transition-all duration-300 rounded-md">
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>

        {{-- Menú móvil --}}
        <nav id="menu"
            class="absolute top-full inset-x-0 p-2 transition transform origin-top-right md:hidden opacity-0 scale-95 pointer-events-none">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-neutral-800 divide-y-2 divide-neutral-700">
                <div class="pt-5 pb-6 px-5">
                    <div class="space-y-6">
                        <a href="/#inicio" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Inicio</a>
                        <a href="/#clases" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Productos</a>
                        <a href="/#entrenadores" class="block text-base font-medium text-white hover:text-red-500 transition mobile-nav-link">Entrenadores</a>
                    </div>
                </div>
                <div class="py-6 px-5">
                    <a href="{{ route('login') }}"
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

    <div class="pt-24 bg-gray-900 text-white font-sans"> 
        <div class="min-h-screen flex flex-col items-center sm:pt-0">
            <div class="w-full sm:max-w-3xl lg:max-w-4xl mt-6 mb-12 p-6 md:p-10 bg-slate-800 shadow-xl overflow-hidden sm:rounded-lg prose prose-invert prose-lg">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-red-500 mb-8 text-center">Política de Privacidad de PowerCore</h1>
                <div class="text-gray-300 space-y-6"> 
                    <div class="text-gray-300 space-y-6"> 


                        <p class="text-sm text-gray-400 mb-6"><strong>Última actualización: [Fecha de la última actualización, ej: 24 de julio de 2024]</strong></p>

                        <p class="leading-relaxed">PowerCore ("nosotros", "nuestro", o "PowerCore") se compromete a proteger y respetar tu privacidad. Esta Política de Privacidad explica cómo recopilamos, usamos, divulgamos y salvaguardamos tu información cuando visitas nuestro sitio web [tu-dominio.com] (el "Sitio Web"), utilizas nuestras instalaciones o interactúas con nuestros servicios (colectivamente, los "Servicios"). Por favor, lee esta política de privacidad cuidadosamente. Si no estás de acuerdo con los términos de esta política de privacidad, por favor no accedas al sitio ni utilices nuestros Servicios.</p>

                        <p class="leading-relaxed">Nos reservamos el derecho de realizar cambios a esta Política de Privacidad en cualquier momento y por cualquier motivo. Te alertaremos sobre cualquier cambio actualizando la fecha de "Última actualización" de esta Política de Privacidad. Te animamos a revisar periódicamente esta Política de Privacidad para mantenerte informado de las actualizaciones.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">1. Información que Recopilamos</h3>
                        <p class="leading-relaxed">Podemos recopilar información sobre ti de diversas maneras. La información que podemos recopilar a través de los Servicios incluye:</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">1.1. Datos Personales</h4>
                        <p class="leading-relaxed">Información de identificación personal, como tu nombre, dirección de envío, dirección de correo electrónico y número de teléfono, e información demográfica, como tu edad, sexo, ciudad natal e intereses, que nos proporcionas voluntariamente cuando te registras en los Servicios, te suscribes a una membresía, participas en diversas actividades relacionadas con los Servicios (como concursos, promociones, encuestas) o te pones en contacto con nosotros.</p>
                        <p class="leading-relaxed">También podemos recopilar información relacionada con tu salud y estado físico que nos proporciones voluntariamente para adaptar nuestros servicios, como objetivos de fitness, historial de ejercicios, limitaciones físicas o preferencias dietéticas, con tu consentimiento explícito cuando sea necesario.</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">1.2. Datos Derivados</h4>
                        <p class="leading-relaxed">Información que nuestros servidores recopilan automáticamente cuando accedes al Sitio Web, como tu dirección IP, tu tipo de navegador, tu sistema operativo, tus tiempos de acceso y las páginas que has visto directamente antes y después de acceder al Sitio Web.</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">1.3. Datos Financieros</h4>
                        <p class="leading-relaxed">Información financiera, como datos relacionados con tu método de pago (por ejemplo, número de tarjeta de crédito válida, marca de la tarjeta, fecha de caducidad) que podemos recopilar cuando compras, solicitas, devuelves o intercambias una membresía o servicio de nosotros. Almacenamos solo información muy limitada, si es que alguna, de los datos financieros. De lo contrario, toda la información financiera es almacenada por nuestros procesadores de pago (por ejemplo, Stripe, PayPal), y te animamos a revisar sus políticas de privacidad y contactarlos directamente para obtener respuestas a tus preguntas.</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">1.4. Datos de Uso de las Instalaciones</h4>
                        <p class="leading-relaxed">Si eres miembro, podemos recopilar datos sobre tu uso de nuestras instalaciones, como los horarios de entrada y salida, el uso de equipos específicos (si se rastrea a través de sistemas de membresía) y la participación en clases, para gestionar la capacidad, mejorar nuestros servicios y con fines de seguridad.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">2. Uso de Tu Información</h3>
                        <p class="leading-relaxed">Tener información precisa sobre ti nos permite ofrecerte una experiencia fluida, eficiente y personalizada. Específicamente, podemos usar la información recopilada sobre ti a través de los Servicios para:</p>
                        <ul class="list-disc list-inside space-y-2 pl-4 text-gray-400">
                            <li>Crear y gestionar tu cuenta.</li>
                            <li>Procesar tus pagos y suscripciones de membresía.</li>
                            <li>Personalizar y mejorar tu experiencia con nuestros Servicios.</li>
                            <li>Proporcionarte los servicios de entrenamiento, clases y programas solicitados.</li>
                            <li>Enviarte correos electrónicos sobre tu cuenta o pedidos.</li>
                            <li>Enviarte un boletín informativo y otras promociones, con tu consentimiento.</li>
                            <li>Solicitar retroalimentación y contactarte sobre tu uso de los Servicios.</li>
                            <li>Resolver disputas y solucionar problemas.</li>
                            <li>Prevenir actividades fraudulentas, supervisar contra el robo y proteger contra la actividad delictiva.</li>
                            <li>Cumplir con las obligaciones legales y reglamentarias.</li>
                            <li>Analizar el uso y las tendencias para mejorar nuestro Sitio Web y Servicios.</li>
                        </ul>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">3. Divulgación de Tu Información</h3>
                        <p class="leading-relaxed">Podemos compartir información que hemos recopilado sobre ti en ciertas situaciones. Tu información puede ser divulgada de la siguiente manera:</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">3.1. Por Ley o para Proteger Derechos</h4>
                        <p class="leading-relaxed">Si creemos que la divulgación de información sobre ti es necesaria para responder a un proceso legal, para investigar o remediar posibles violaciones de nuestras políticas, o para proteger los derechos, la propiedad y la seguridad de otros, podemos compartir tu información según lo permita o exija cualquier ley, norma o regulación aplicable.</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">3.2. Proveedores de Servicios Externos</h4>
                        <p class="leading-relaxed">Podemos compartir tu información con terceros que realizan servicios para nosotros o en nuestro nombre, incluyendo procesamiento de pagos, análisis de datos, envío de correos electrónicos, servicios de hosting, servicio al cliente y asistencia de marketing.</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">3.3. Entrenadores Personales</h4>
                        <p class="leading-relaxed">Si te inscribes en servicios de entrenamiento personal, tu información relevante (incluida cierta información de salud y estado físico que hayas proporcionado) se compartirá con el entrenador personal asignado para permitirle prestar los servicios contratados.</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">3.4. Transferencias Comerciales</h4>
                        <p class="leading-relaxed">Podemos compartir o transferir tu información en conexión con, o durante las negociaciones de, cualquier fusión, venta de activos de la empresa, financiación o adquisición de la totalidad o una parte de nuestro negocio a otra empresa.</p>

                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">3.5. Con Tu Consentimiento</h4>
                        <p class="leading-relaxed">Podemos divulgar tu información personal para cualquier otro propósito con tu consentimiento.</p>

                        <p class="leading-relaxed">No vendemos información personal a terceros.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">4. Tecnologías de Seguimiento</h3>
                        <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">4.1. Cookies y Web Beacons</h4>
                        <p class="leading-relaxed">Podemos usar cookies, web beacons, píxeles de seguimiento y otras tecnologías de seguimiento en el Sitio Web para ayudar a personalizar el Sitio Web y mejorar tu experiencia. Cuando accedes al Sitio Web, tu información personal no se recopila mediante el uso de tecnología de seguimiento. La mayoría de los navegadores están configurados para aceptar cookies de forma predeterminada. Puedes eliminar o rechazar las cookies, pero ten en cuenta que tal acción podría afectar la disponibilidad y funcionalidad del Sitio Web.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">5. Seguridad de Tu Información</h3>
                        <p class="leading-relaxed">Utilizamos medidas de seguridad administrativas, técnicas y físicas para ayudar a proteger tu información personal. Si bien hemos tomado medidas razonables para proteger la información personal que nos proporcionas, ten en cuenta que a pesar de nuestros esfuerzos, ninguna medida de seguridad es perfecta o impenetrable, y ningún método de transmisión de datos puede garantizarse contra cualquier interceptación u otro tipo de uso indebido.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">6. Tus Derechos de Protección de Datos</h3>
                        <p class="leading-relaxed">Dependiendo de tu ubicación, puedes tener ciertos derechos con respecto a tu información personal, como:</p>
                        <ul class="list-disc list-inside space-y-2 pl-4 text-gray-400">
                            <li>El derecho a acceder – Tienes derecho a solicitar copias de tus datos personales.</li>
                            <li>El derecho a la rectificación – Tienes derecho a solicitar que corrijamos cualquier información que creas que es inexacta o incompleta.</li>
                            <li>El derecho al olvido (supresión) – Tienes derecho a solicitar que eliminemos tus datos personales, bajo ciertas condiciones.</li>
                            <li>El derecho a restringir el procesamiento – Tienes derecho a solicitar que restrinjamos el procesamiento de tus datos personales, bajo ciertas condiciones.</li>
                            <li>El derecho a oponerte al procesamiento – Tienes derecho a oponerte a nuestro procesamiento de tus datos personales, bajo ciertas condiciones.</li>
                            <li>El derecho a la portabilidad de los datos – Tienes derecho a solicitar que transfiramos los datos que hemos recopilado a otra organización, o directamente a ti, bajo ciertas condiciones.</li>
                        </ul>
                        <p class="leading-relaxed">Si deseas ejercer alguno de estos derechos, por favor contáctanos utilizando la información de contacto proporcionada a continuación. Responderemos a tu solicitud dentro del plazo requerido por la ley aplicable.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">7. Retención de Datos</h3>
                        <p class="leading-relaxed">Retendremos tu información personal solo durante el tiempo que sea necesario para los fines establecidos en esta Política de Privacidad, a menos que la ley exija o permita un período de retención más largo (como requisitos fiscales, contables u otros requisitos legales). Cuando ya no tengamos una necesidad comercial legítima en curso para procesar tu información personal, la eliminaremos o la anonimizaremos, o, si esto no es posible (por ejemplo, porque tu información personal ha sido almacenada en archivos de respaldo), entonces almacenaremos de forma segura tu información personal y la aislaremos de cualquier procesamiento posterior hasta que la eliminación sea posible.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">8. Política para Niños</h3>
                        <p class="leading-relaxed">No solicitamos conscientemente información de ni procesamos datos personales de niños menores de 16 años sin el consentimiento verificable de los padres. Si nos damos cuenta de que hemos recopilado información personal de un niño menor de la edad aplicable sin el consentimiento de los padres, eliminaremos esa información lo más rápido posible. Si crees que podríamos tener alguna información de o sobre un niño menor de la edad aplicable, por favor contáctanos.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">9. Enlaces a Otros Sitios Web</h3>
                        <p class="leading-relaxed">Nuestro Sitio Web puede contener enlaces a otros sitios web que no son operados por nosotros. Si haces clic en un enlace de un tercero, serás dirigido al sitio de ese tercero. Te recomendamos encarecidamente que revises la Política de Privacidad de cada sitio que visites. No tenemos control ni asumimos ninguna responsabilidad por el contenido, las políticas de privacidad o las prácticas de los sitios o servicios de terceros.</p>

                        <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">10. Contacto</h3>
                        <p class="leading-relaxed">Si tienes preguntas o comentarios sobre esta Política de Privacidad, por favor contáctanos en:</p>
                        <address class="not-italic text-gray-400">
                            PowerCore<br>
                            España, Madrid, Madrid<br>
                            Correo electrónico: <a href="mailto:[info@powercore.es]" class="text-red-500 hover:text-red-400 underline transition-colors">info@powercore.com</a><br>
                            Teléfono: 562341232
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <li><a href="/#clases" class="text-sm hover:text-red-600 transition-colors duration-200">Entrenamiento de fuerza</a></li>
                        <li><a href="/#clases" class="text-sm hover:text-red-600 transition-colors duration-200">Entrenamiento cardiovascular</a></li>
                        <li><a href="/#clases" class="text-sm hover:text-red-600 transition-colors duration-200">Entrenamiento de salud</a></li>
                        <li><a href="/#clases" class="text-sm hover:text-red-600 transition-colors duration-200">Moldear el cuerpo</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-md font-semibold text-white uppercase tracking-wider mb-4">Sobre nosotros</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Información de la empresa</a></li>
                        <li><a href="#" class="text-sm hover:text-red-600 transition-colors duration-200">Área de negocios</a></li>
                        <li><a href="/#entrenadores" class="text-sm hover:text-red-600 transition-colors duration-200">Miembros</a></li> 
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
                    <a href="{{ route('terms') }}" class="text-xs text-gray-500 hover:text-red-600 transition-all duration-300 mx-2">Términos de Servicio</a>
                </div>
            </div>
        </div>
    </footer>

</x-guest-layout>