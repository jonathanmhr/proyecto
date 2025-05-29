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
            <?php echo e(__('Mis Clases')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Mis Clases</h1>
            <a href="<?php echo e(route('entrenador.dashboard')); ?>" 
                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <div class="space-y-6">
            <?php $__currentLoopData = $clases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white border border-gray-300 rounded-lg  p-6 hover:shadow-lg hover:bg-gray-100 transition-all duration-500">
                    <h3 class="text-xl font-semibold text-blue-800 mb-2"><?php echo e($clase->nombre); ?></h3>
                    <p class="text-sm text-gray-700 mb-2"><?php echo e($clase->descripcion); ?></p>
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Fecha:</strong> <?php echo e($clase->fecha_inicio); ?> - <?php echo e($clase->fecha_fin); ?>

                    </div>
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Ubicación:</strong> <?php echo e($clase->ubicacion); ?>

                    </div>
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Cupos disponibles:</strong> <?php echo e($clase->cupos_maximos); ?>

                    </div>
                    <div class="text-sm text-gray-600 mb-4">
                        <strong>Duración estimada:</strong> <?php echo e($clase->duracion); ?> minutos
                    </div>

                    <?php if($clase->cambio_pendiente): ?>
                        <div class="text-yellow-500 text-sm mb-4">
                            <strong>Estado:</strong> Cambios pendientes de aprobación
                        </div>
                    <?php endif; ?>

                    <a href="<?php echo e(route('entrenador.clases.edit', $clase->id_clase)); ?>"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Editar Clase
                    </a>

                    <div class="mt-4">
                        <a href="<?php echo e(route('entrenador.clases.alumnos', $clase->id_clase)); ?>"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Gestionar Alumnos
                        </a>
                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH /var/www/gimnasio/resources/views/entrenador/clases/index.blade.php ENDPATH**/ ?>