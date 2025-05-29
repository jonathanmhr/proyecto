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
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Panel del Entrenador')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            👋 ¡Bienvenido de nuevo, <?php echo e(auth()->user()->name); ?>!
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Resumen General -->
            <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-indigo-700 mb-4">Resumen General</h2>
                <div class="text-sm text-indigo-600">
                    <p><strong>Total de Clases Activas:</strong> <?php echo e($clases->count()); ?></p>
                    <p><strong>Entrenamientos en Curso:</strong> <?php echo e($entrenamientos->count()); ?></p>
                    <p><strong>Suscripciones Activas:</strong> <?php echo e($suscripciones->count()); ?></p>
                </div>
            </div>

            <!-- Mis Clases -->
            <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-blue-700 mb-4">Mis Clases</h2>
                <?php $__empty_1 = true; $__currentLoopData = $clases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border-b border-blue-300 pb-2 mb-2">
                        <div class="text-blue-800 font-medium"><?php echo e($clase->nombre); ?></div>
                        <div class="text-sm text-blue-600"><?php echo e($clase->descripcion); ?></div>
                        <div class="text-sm text-blue-600">Fecha: <?php echo e($clase->fecha_inicio); ?> - <?php echo e($clase->fecha_fin); ?>

                        </div>
                        <p class="text-sm text-blue-600">
                            <?php if($clase->cambio_pendiente): ?>
                                <span class="text-yellow-100 font-bold bg-yellow-600 rounded px-1">Cambio Pendiente de Aprobación</span>
                            <?php else: ?>
                                <span class="text-green-100 font-bold bg-green-600 rounded px-1">Clase Aceptada</span>
                            <?php endif; ?>
                        </p>
                        <a href="<?php echo e(route('entrenador.clases.edit', $clase)); ?>"
                            class="text-blue-500 hover:bg-white hover:shadow-sm all-transitions px-1 py-1 my-1 rounded duration-300">Editar clase</a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-blue-600">No tienes clases programadas.</p>
                <?php endif; ?>
                <div class="mt-4">
                    <a href="<?php echo e(route('entrenador.clases.index')); ?>" class="text-blue-500 hover:bg-white hover:shadow-sm all-transitions px-1 py-1 my-1 rounded duration-300">Ver todas
                        mis clases</a>
                </div>
            </div>

            <!-- Mis Entrenamientos -->
            <div class="bg-gradient-to-br from-green-100 to-green-200 p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-green-700 mb-4">Mis Entrenamientos</h2>
                <?php $__empty_1 = true; $__currentLoopData = $entrenamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrenamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border-b border-green-300 pb-2 mb-2">
                        <div class="text-green-800 font-medium"><?php echo e($entrenamiento->nombre); ?></div>
                        <div class="text-sm text-green-600">Tipo: <?php echo e($entrenamiento->tipo); ?></div>
                        <div class="text-sm text-green-600">Duración: <?php echo e($entrenamiento->duracion); ?> minutos</div>
                        <div class="text-sm text-green-600">Fecha: <?php echo e($entrenamiento->fecha); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-green-600">No tienes entrenamientos programados.</p>
                <?php endif; ?>
            </div>

            <!-- Mis Reservas y Estado de Solicitudes -->
            <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-yellow-700 mb-4">Mis Reservas y Estado de Solicitudes</h2>
                <?php $__empty_1 = true; $__currentLoopData = $reservas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reserva): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border-b border-yellow-300 pb-2 mb-2">
                        <div class="text-yellow-800 font-medium"><?php echo e($reserva->clase->nombre); ?> (Reserva para:
                            <?php echo e($reserva->usuario->name); ?>)</div>
                        <div class="text-sm text-yellow-600">
                            Estado de la Reserva:
                            <?php if($reserva->estado == 'pendiente'): ?>
                                <span class="text-yellow-500">Pendiente</span>
                            <?php elseif($reserva->estado == 'aceptada'): ?>
                                <span class="text-green-500">Aceptada</span>
                            <?php else: ?>
                                <span class="text-red-500">Rechazada</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-yellow-600">No tienes reservas para clases.</p>
                <?php endif; ?>
            </div>

            <!-- Solicitudes Pendientes -->
            <div class="bg-gradient-to-br from-teal-100 to-teal-200 p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-teal-700 mb-4">Solicitudes Pendientes</h2>
                <?php if($solicitudesPendientes->count() > 0): ?>
                    <p class="text-sm text-teal-600">
                        Tienes <?php echo e($solicitudesPendientes->count()); ?> solicitud(es) pendiente(s).
                    </p>
                    <a href="<?php echo e(route('entrenador.solicitudes.index')); ?>" class="text-teal-500 hover:underline">Ver
                        Solicitudes Pendientes</a>
                <?php else: ?>
                    <p class="text-sm text-teal-600">
                        No tienes solicitudes pendientes.
                    </p>
                <?php endif; ?>
            </div>



        </div>
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
<?php /**PATH /var/www/gimnasio/resources/views/entrenador/dashboard.blade.php ENDPATH**/ ?>