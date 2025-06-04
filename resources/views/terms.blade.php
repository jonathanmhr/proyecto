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
                <h1 class="text-3xl sm:text-4xl font-extrabold text-red-500 mb-8 text-center">Términos de Servicio</h1>
                <div class="text-gray-300 space-y-6"> {{-- Contenedor principal para el texto con espaciado y color base --}}

                    <h2 class="text-2xl sm:text-3xl font-bold text-red-500 mb-6">Términos y Condiciones de Servicio de PowerCore</h2>

                    <p class="text-sm text-gray-400 mb-6"><strong>Última actualización:  24 de julio de 2024</strong></p>

                    <p class="leading-relaxed">Bienvenido/a a PowerCore. Al acceder y utilizar nuestro sitio web, nuestras instalaciones físicas, aplicaciones móviles (si las hubiera) y los servicios ofrecidos (colectivamente, los "Servicios"), aceptas cumplir y estar legalmente obligado/a por los siguientes términos y condiciones ("Términos"). Si no estás de acuerdo con estos Términos, no debes utilizar nuestros Servicios.</p>

                    <p class="leading-relaxed">Por favor, lee estos Términos detenidamente, así como nuestra <a href="{{ route('policy') }}" class="text-red-500 hover:text-red-400 underline font-medium transition-colors">Política de Privacidad</a>, que también rige tu uso de nuestros Servicios.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">1. Descripción de los Servicios</h3>
                    <p class="leading-relaxed">PowerCore ofrece servicios relacionados con el fitness y el bienestar, incluyendo, pero no limitado a:</p>
                    <ul class="list-disc list-inside space-y-2 pl-4 text-gray-400">
                        <li>Acceso a instalaciones de gimnasio y equipamiento.</li>
                        <li>Clases grupales de diversas disciplinas (ej. Fuerza, Cardio, Salud Activa).</li>
                        <li>Programas de entrenamiento personalizado y asesoramiento por entrenadores cualificados.</li>
                        <li>Planes de membresía con diferentes niveles de acceso y beneficios.</li>
                        <li>Contenido informativo y motivacional a través de nuestro Sitio Web.</li>
                    </ul>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">2. Elegibilidad y Cuentas de Usuario</h3>
                    <p class="leading-relaxed">Para utilizar ciertos Servicios, como la inscripción a planes o el acceso a áreas restringidas del Sitio Web, es posible que necesites registrarte y crear una cuenta ("Cuenta").</p>
                    <ul class="list-disc list-inside space-y-2 pl-4 text-gray-400">
                        <li>Debes ser mayor de 18 años o contar con el consentimiento de tus padres o tutores legales para registrarte y utilizar nuestros Servicios.</li>
                        <li>Te comprometes a proporcionar información precisa, actual y completa durante el proceso de registro y a actualizar dicha información para mantenerla precisa, actual y completa.</li>
                        <li>Eres responsable de salvaguardar tu contraseña y aceptas no revelarla a terceros. Eres el único responsable de cualquier actividad o acción que se realice en tu Cuenta, autorizada o no por ti.</li>
                        <li>Debes notificarnos inmediatamente cualquier uso no autorizado de tu Cuenta.</li>
                    </ul>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">3. Uso de las Instalaciones y Servicios</h3>
                    <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">3.1. Salud y Seguridad</h4>
                    <ul class="list-disc list-inside space-y-2 pl-4 text-gray-400">
                        <li>Reconoces que las actividades físicas conllevan un riesgo inherente de lesión. Al participar en nuestros Servicios, asumes voluntariamente todos los riesgos conocidos y desconocidos asociados con estas actividades.</li>
                        <li>Te recomendamos encarecidamente que consultes con tu médico antes de comenzar cualquier programa de ejercicios o utilizar nuestras instalaciones. Declaras que gozas de buena salud física y que no padeces ninguna condición médica que te impida o limite tu participación segura en actividades físicas.</li>
                        <li>Debes seguir todas las normas publicadas, las instrucciones del personal de PowerCore y utilizar el equipo de manera segura y adecuada.</li>
                        <li>Debes informar inmediatamente al personal de PowerCore sobre cualquier lesión sufrida en las instalaciones o cualquier equipo defectuoso o peligroso.</li>
                    </ul>
                    <h4 class="text-lg sm:text-xl font-medium text-red-400 mt-6 mb-3">3.2. Código de Conducta</h4>
                    <ul class="list-disc list-inside space-y-2 pl-4 text-gray-400">
                        <li>Se espera que todos los miembros y visitantes se comporten de manera respetuosa y considerada hacia los demás miembros, el personal y las instalaciones.</li>
                        <li>No se tolerará ningún tipo de acoso, comportamiento intimidatorio, discriminatorio o inapropiado.</li>
                        <li>Se requiere vestimenta deportiva adecuada en todo momento dentro de las áreas de entrenamiento.</li>
                        <li>Está prohibido el uso de sustancias ilegales en las instalaciones de PowerCore.</li>
                        <li>PowerCore se reserva el derecho de admisión y de revocar la membresía o el acceso a cualquier persona que no cumpla con estos Términos o cuyo comportamiento sea perjudicial para el ambiente del gimnasio.</li>
                    </ul>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">4. Tarifas, Pagos y Membresías</h3>
                    <ul class="list-disc list-inside space-y-2 pl-4 text-gray-400">
                        <li>Los detalles de nuestros planes de membresía (Basic, Premium, Elite) y sus respectivas tarifas se describen en nuestro Sitio Web.</li>
                        <li>Al suscribirte a un plan, aceptas pagar todas las tarifas aplicables según los términos de dicho plan. Las tarifas pueden estar sujetas a impuestos.</li>
                        <li>Los pagos suelen ser recurrentes (mensuales, anuales, etc.) según el plan seleccionado. Te comprometes a mantener actualizada tu información de pago.</li>
                        <li><strong class="text-gray-200">Renovación Automática:</strong> A menos que se indique lo contrario o canceles tu membresía antes de la fecha de renovación, tu membresía se renovará automáticamente por el mismo período y tarifa.</li>
                        <li><strong class="text-gray-200">Cancelación:</strong> Puedes cancelar tu membresía de acuerdo con la política de cancelación especificada para tu plan. Generalmente, las cancelaciones deben realizarse con un aviso previo determinado antes de la siguiente fecha de facturación. No se realizarán reembolsos por períodos de membresía parcialmente utilizados, a menos que la ley aplicable exija lo contrario.</li>
                        <li>Nos reservamos el derecho de cambiar nuestras tarifas o planes de membresía. Cualquier cambio se te notificará con antelación.</li>
                    </ul>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">5. Propiedad Intelectual</h3>
                    <p class="leading-relaxed">El Sitio Web, los Servicios y todo su contenido original, características y funcionalidad (incluyendo, pero no limitado a, todo el software, texto, muestras, imágenes, vídeo y audio, y el diseño, selección y disposición de los mismos, incluyendo el logo de PowerCore e imágenes como "logoRojo.png", "mancuerna.png", "grad.png", "tio2.png", etc.) son propiedad de PowerCore, sus licenciantes u otros proveedores de dicho material y están protegidos por leyes internacionales de derechos de autor, marcas registradas, patentes, secretos comerciales y otras leyes de propiedad intelectual o derechos de propiedad.</p>
                    <p class="leading-relaxed">Se te concede una licencia limitada, no exclusiva, no transferible y revocable para acceder y utilizar los Servicios para tu uso personal y no comercial, sujeto a estos Términos.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">6. Contenido del Usuario</h3>
                    <p class="leading-relaxed">Si publicas, subes o transmites cualquier contenido a través de nuestros Servicios (por ejemplo, testimonios, fotos de progreso, comentarios) ("Contenido del Usuario"), conservas la propiedad de dicho Contenido del Usuario, pero nos otorgas una licencia mundial, no exclusiva, libre de regalías, sublicenciable y transferible para usar, reproducir, distribuir, preparar trabajos derivados, mostrar y ejecutar ese Contenido del Usuario en conexión con los Servicios y nuestro negocio.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">7. Descargo de Responsabilidad de Garantías</h3>
                    <p class="leading-relaxed uppercase text-gray-400">LOS SERVICIOS SE PROPORCIONAN "TAL CUAL" Y "SEGÚN DISPONIBILIDAD", SIN GARANTÍAS DE NINGÚN TIPO, YA SEAN EXPRESAS O IMPLÍCITAS, INCLUYENDO, PERO NO LIMITADO A, GARANTÍAS IMPLÍCITAS DE COMERCIABILIDAD, IDONEIDAD PARA UN PROPÓSITO PARTICULAR, NO INFRACCIÓN O CURSO DE RENDIMIENTO.</p>
                    <p class="leading-relaxed uppercase text-gray-400">POWERCORE NO GARANTIZA QUE: A) LOS SERVICIOS FUNCIONARÁN DE FORMA ININTERRUMPIDA, SEGURA O DISPONIBLE EN CUALQUIER MOMENTO O LUGAR PARTICULAR; B) CUALQUIER ERROR O DEFECTO SERÁ CORREGIDO; C) LOS SERVICIOS ESTÉN LIBRES DE VIRUS U OTROS COMPONENTES DAÑINOS; O D) LOS RESULTADOS DE USAR LOS SERVICIOS CUMPLIRÁN TUS REQUISITOS O EXPECTATIVAS ESPECÍFICAS DE TRANSFORMACIÓN FÍSICA O MENTAL.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">8. Limitación de Responsabilidad</h3>
                    <p class="leading-relaxed uppercase text-gray-400">EN LA MÁXIMA MEDIDA PERMITIDA POR LA LEY APLICABLE, EN NINGÚN CASO POWERCORE, SUS DIRECTORES, EMPLEADOS, SOCIOS, AGENTES, PROVEEDORES O AFILIADOS, SERÁN RESPONSABLES DE NINGÚN DAÑO INDIRECTO, INCIDENTAL, ESPECIAL, CONSECUENTE O PUNITIVO, INCLUYENDO SIN LIMITACIÓN, PÉRDIDA DE BENEFICIOS, DATOS, USO, FONDO DE COMERCIO, U OTRAS PÉRDIDAS INTANGIBLES, RESULTANTES DE (I) TU ACCESO O USO O INCAPACIDAD DE ACCEDER O USAR LOS SERVICIOS; (II) CUALQUIER CONDUCTA O CONTENIDO DE CUALQUIER TERCERO EN LOS SERVICIOS; (III) CUALQUIER CONTENIDO OBTENIDO DE LOS SERVICIOS; Y (IV) ACCESO NO AUTORIZADO, USO O ALTERACIÓN DE TUS TRANSMISIONES O CONTENIDO, YA SEA BASADO EN GARANTÍA, CONTRATO, AGRAVIO (INCLUYENDO NEGLIGENCIA) O CUALQUIER OTRA TEORÍA LEGAL, HAYAMOS SIDO INFORMADOS O NO DE LA POSIBILIDAD DE DICHO DAÑO, E INCLUSO SI SE ENCUENTRA QUE UN REMEDIO ESTABLECIDO AQUÍ HA FALLADO EN SU PROPÓSITO ESENCIAL.</p>
                    <p class="leading-relaxed uppercase text-gray-400">NUESTRA RESPONSABILIDAD TOTAL ANTE TI POR CUALQUIER RECLAMACIÓN QUE SURJA DE O ESTÉ RELACIONADA CON ESTOS TÉRMINOS O LOS SERVICIOS SE LIMITARÁ A LA CANTIDAD QUE NOS HAYAS PAGADO POR LOS SERVICIOS EN LOS TRES (3) MESES ANTERIORES AL EVENTO QUE DIO LUGAR A LA RECLAMACIÓN, O CIEN EUROS (€100), LO QUE SEA MAYOR.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">9. Indemnización</h3>
                    <p class="leading-relaxed">Aceptas defender, indemnizar y eximir de responsabilidad a PowerCore y a sus licenciatarios y licenciantes, y a sus empleados, contratistas, agentes, funcionarios y directores, de y contra cualquier reclamación, daño, obligación, pérdida, responsabilidad, costo o deuda, y gastos (incluidos, entre otros, los honorarios de abogados), resultantes de o que surjan de a) tu uso y acceso a los Servicios, por ti o cualquier persona que utilice tu cuenta y contraseña; b) una violación de estos Términos, o c) Contenido del Usuario publicado en los Servicios.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">10. Modificación de los Términos</h3>
                    <p class="leading-relaxed">Nos reservamos el derecho, a nuestra sola discreción, de modificar o reemplazar estos Términos en cualquier momento. Si una revisión es material, intentaremos proporcionar al menos 30 días de aviso previo antes de que los nuevos términos entren en vigor. Lo que constituye un cambio material se determinará a nuestra sola discreción.</p>
                    <p class="leading-relaxed">Al continuar accediendo o utilizando nuestros Servicios después de que esas revisiones entren en vigor, aceptas estar obligado por los términos revisados. Si no estás de acuerdo con los nuevos términos, por favor deja de usar los Servicios.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">11. Terminación</h3>
                    <p class="leading-relaxed">Podemos terminar o suspender tu Cuenta y el acceso a los Servicios inmediatamente, sin previo aviso ni responsabilidad, por cualquier motivo, incluyendo, sin limitación, si incumples los Términos.</p>
                    <p class="leading-relaxed">Tras la terminación, tu derecho a utilizar los Servicios cesará inmediatamente. Si deseas terminar tu Cuenta, simplemente puedes dejar de utilizar los Servicios o seguir el proceso de cancelación de membresía.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">12. Ley Aplicable y Jurisdicción</h3>
                    <p class="leading-relaxed">Estos Términos se regirán e interpretarán de acuerdo con las leyes de España, sin tener en cuenta sus disposiciones sobre conflicto de leyes.</p>
                    <p class="leading-relaxed">Cualquier disputa que surja de o en relación con estos Términos, incluyendo cualquier pregunta sobre su existencia, validez o terminación, será sometida a la jurisdicción exclusiva de los tribunales de [Ciudad donde está registrado PowerCore, por ejemplo: Madrid], España.</p>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">13. Disposiciones Generales</h3>
                    <ul class="list-disc list-inside space-y-2 pl-4 text-gray-400">
                        <li><strong class="text-gray-200">Acuerdo Completo:</strong> Estos Términos constituyen el acuerdo completo entre tú y PowerCore con respecto a nuestros Servicios, y reemplazan y sustituyen cualquier acuerdo anterior que pudiéramos tener entre nosotros con respecto a los Servicios.</li>
                        <li><strong class="text-gray-200">Divisibilidad:</strong> Si alguna disposición de estos Términos se considera inválida o inaplicable por un tribunal, las disposiciones restantes de estos Términos seguirán en vigor.</li>
                        <li><strong class="text-gray-200">No Renuncia:</strong> El hecho de que no hagamos valer algún derecho o disposición de estos Términos no se considerará una renuncia a dichos derechos.</li>
                    </ul>

                    <h3 class="text-xl sm:text-2xl font-semibold text-white mt-8 mb-4">14. Contacto</h3>
                    <p class="leading-relaxed">Si tienes alguna pregunta sobre estos Términos, por favor contáctanos en:</p>
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