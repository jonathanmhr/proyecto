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
            <?php echo e(__('Panel del Cliente')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            <!-- Clases Grupales -->
            <div class="bg-white p-6 rounded-2xl shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">Clases Grupales</h3>
                    <a href="<?php echo e(route('cliente.clases.index')); ?>"
                       class="text-blue-600 hover:underline">Ver todas</a>
                </div>

                <?php if($clases->isEmpty()): ?>
                    <p class="text-gray-500">No hay clases disponibles actualmente.</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $clases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-gray-100 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold text-gray-700"><?php echo e($clase->nombre); ?></h4>
                                <p class="text-sm text-gray-600"><?php echo e(Str::limit($clase->descripcion, 100)); ?></p>
                                <p class="text-sm text-gray-500 mt-2">Inicio: <?php echo e(\Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y')); ?></p>
                                <p class="text-sm text-gray-500">Cupos: <?php echo e($clase->cupos_maximos); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Entrenamientos -->
            <div class="bg-white p-6 rounded-2xl shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">Entrenamientos</h3>
                    <a href="<?php echo e(route('cliente.entrenamientos.index')); ?>"
                       class="text-blue-600 hover:underline">Ver todos</a>
                </div>

                <?php if($entrenamientos->isEmpty()): ?>
                    <p class="text-gray-500">No hay entrenamientos disponibles actualmente.</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $entrenamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrenamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-gray-100 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold text-gray-700"><?php echo e($entrenamiento->nombre); ?></h4>
                                <p class="text-sm text-gray-600">Tipo: <?php echo e($entrenamiento->tipo); ?></p>
                                <p class="text-sm text-gray-500 mt-2">Duración: <?php echo e($entrenamiento->duracion); ?> min</p>
                                <p class="text-sm text-gray-500">Fecha: <?php echo e(\Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y')); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
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
<?php /**PATH /var/www/gimnasio/resources/views/cliente/dashboard.blade.php ENDPATH**/ ?>