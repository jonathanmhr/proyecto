<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container mx-auto px-4 py-6 space-y-10">

        
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <section>
            <h1 class="text-3xl font-bold mb-6">Panel General - Admin Total</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-indigo-600"><?php echo e($totalUsuarios ?? 0); ?></p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">👥 Usuarios totales</p>
                    </div>
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                        class="mt-4 inline-block text-indigo-500 hover:underline text-sm font-semibold">Ver más</a>
                </div>

                
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-blue-600"><?php echo e($usuariosActivosHoy ?? 0); ?></p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">📈 Usuarios activos hoy</p>
                    </div>
                    <a href="<?php echo e(route('admin.usuarios.conectados')); ?>"
                        class="mt-4 inline-block text-blue-500 hover:underline text-sm font-semibold">Ver actividad</a>
                </div>

                
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-red-600"><?php echo e($inactivosMas7Dias ?? 0); ?></p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">⏱️ Inactivos +7 días</p>
                    </div>
                    <a href="<?php echo e(route('admin.usuarios.inactivos')); ?>"
                        class="mt-4 inline-block text-red-500 hover:underline text-sm font-semibold">Revisar</a>
                </div>

                
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-green-600"><?php echo e($entrenadoresActivos ?? 0); ?></p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">🏋️ Entrenadores activos</p>
                    </div>
                    <a href="<?php echo e(route('admin.entrenadores')); ?>"
                        class="mt-4 inline-block text-green-500 hover:underline text-sm font-semibold">Ver
                        entrenadores</a>
                </div>

                
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-yellow-600"><?php echo e($gruposCreados ?? 0); ?></p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">👥 Grupos creados</p>
                    </div>
                    <a href="<?php echo e(route('admin.roles.index')); ?>"
                        class="mt-4 inline-block text-yellow-500 hover:underline text-sm font-semibold">Ver grupos</a>
                </div>
            </div>
        </section>

        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Acciones rápidas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">➕</span> Crear nuevo usuario
                </a>

                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">🧾</span> Generar reporte
                </a>

                <a href="<?php echo e(route('admin.notificaciones.index')); ?>"
                    class="bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">📤</span> Enviar anuncio
                </a>

                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">👥</span> Gestionar usuarios
                </a>

                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">👨‍👩‍👧‍👦</span> Gestionar grupos
                </a>
            </div>
        </section>

        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Notificaciones</h2>
            <ul class="bg-white shadow rounded-xl p-6 space-y-3 max-h-56 overflow-y-auto">
                <?php $__currentLoopData = $alertas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alerta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li
                        class="flex items-center gap-3 font-semibold
                <?php echo e(str_starts_with($alerta->icono, '⚠️') ? 'text-yellow-600' : (str_starts_with($alerta->icono, '✅') ? 'text-green-600' : 'text-red-600')); ?>">
                        <?php echo $alerta->icono; ?> <?php echo e($alerta->titulo); ?> - <small>de <?php echo e($alerta->remitente); ?></small>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>


        <section>
            <h2 class="text-2xl font-semibold mb-4">Actividad reciente</h2>
            <div class="bg-white shadow rounded-xl p-6 max-h-80 overflow-y-auto space-y-4">

                <div>
                    <h3 class="font-semibold">Usuarios registrados recientemente</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        <?php $__currentLoopData = $usuariosRecientes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($user->name); ?> - <?php echo e($user->created_at->format('Y-m-d')); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold">Cambios hechos por otros admins</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        
                        <li>Juan Pérez actualizó el perfil de Ana López</li>
                        <li>María Gómez creó un nuevo grupo "Equipo Sur"</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold">Últimos contenidos publicados</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        <li>Nuevo entrenamiento HIIT - 2025-05-15</li>
                        <li>Blog: Alimentación saludable - 2025-05-14</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold">Notificaciones enviadas recientemente</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        <?php $__currentLoopData = $notificacionesEnviadas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <?php echo e($notificacion->titulo); ?> -
                                <span
                                    class="text-gray-500 text-sm"><?php echo e(\Carbon\Carbon::parse($notificacion->fecha)->format('Y-m-d H:i')); ?></span>
                                -
                                <em class="text-gray-600">Enviado por: <?php echo e($notificacion->remitente); ?></em>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>


            </div>
        </section>


        
        <section>
            <h2 class="text-2xl font-semibold mb-4">Gráficos de Actividad Mensual</h2> 
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Altas de Usuarios por Mes</h3>
                    <div id="usersChart"></div> 
                </div>

                
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Altas y Bajas de Suscripciones</h3>
                    <div id="subscriptionsChart"></div> 
                </div>

                
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Creación de Clases por Mes</h3>
                    <div id="classesChart"></div> 
                </div>

                
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Progreso promedio semanal</h3>
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500">[Gráfico de barras aquí]</div>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Actividad por grupo o entrenador</h3>
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500">[Gráfico de barras aquí]</div>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Distribución de usuarios por rol</h3>
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500">[Gráfico circular o torta aquí]
                    </div>
                </div>

            </div>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.initApexCharts) {
            const chartDataUrl = '<?php echo e(route('admin.chart.data')); ?>';
            console.log('Intentando obtener datos de gráficos de la URL:', chartDataUrl); // ¡Añade esta línea!

            fetch(chartDataUrl) // Usa la variable
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error de red o servidor: ' + response.statusText + ' (' + response.status + ')');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.usersChartData && data.subscriptionsChartData && data.classesChartData) {
                        window.initApexCharts(
                            data.usersChartData,
                            data.subscriptionsChartData,
                            data.classesChartData
                        );
                    } else {
                        console.error("Los datos de los gráficos no están en el formato esperado desde el servidor.");
                        console.log("Datos recibidos:", data);
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los datos de los gráficos:', error);
                });
        } else {
            console.error("La función 'initApexCharts' no está disponible...");
        }
    });
</script><?php /**PATH C:\xampp\htdocs\jonathan\gimnasio\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>