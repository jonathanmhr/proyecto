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
            Notificaciones Enviadas
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-between items-center space-x-4">
                <a href="<?php echo e(route('admin.notificaciones.create')); ?>"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-sm transition">
                    ✉️Nueva Notificación
                </a>

                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                    ← Volver al dashboard
                </a>
            </div>



            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <?php if($notificaciones->count()): ?>
                    <table class="w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">Título</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Mensaje</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Fecha</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Destinatarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $data = json_decode($notificacion->data);
                                ?>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo e($data->titulo ?? ''); ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo e($data->mensaje ?? ''); ?></td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <?php echo e(Carbon\Carbon::parse($notificacion->created_at)->format('d/m/Y H:i')); ?></td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <?php echo e($usuarios[$notificacion->notifiable_id]->name ?? 'Usuario no encontrado'); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <?php echo e($notificaciones->links()); ?>

                    </div>
                <?php else: ?>
                    <p>No hay notificaciones enviadas.</p>
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
<?php /**PATH /var/www/gimnasio/resources/views/admin/notificaciones/index.blade.php ENDPATH**/ ?>