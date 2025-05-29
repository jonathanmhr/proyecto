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
    <div class="container mx-auto px-4 py-6">
        <!-- Botón para volver al Dashboard -->
        <div class="flex justify-end mb-4">
            <a href="<?php echo e(route('admin-entrenador.dashboard')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Volver
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-6">Solicitudes Pendientes de Clase</h1>

        <?php if($solicitudesPendientes->isEmpty()): ?>
            <p>No hay solicitudes pendientes.</p>
        <?php else: ?>
            <table class="min-w-full bg-white shadow rounded-lg">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Nombre del Usuario</th>
                        <th class="py-2 px-4 border-b">Clase</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $solicitudesPendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $solicitud): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo e($solicitud->usuario->name); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo e($solicitud->clase->nombre); ?></td>
                            <td class="py-2 px-4 border-b">
                                <form action="<?php echo e(route('admin-entrenador.solicitudes.aceptar', ['claseId' => $solicitud->id_clase, 'usuarioId' => $solicitud->id_usuario])); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-green-500 hover:text-green-700">Aceptar</button>
                                </form>
                                <form action="<?php echo e(route('admin-entrenador.solicitudes.rechazar', ['claseId' => $solicitud->id_clase, 'usuarioId' => $solicitud->id_usuario])); ?>" method="POST" class="inline ml-4">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-red-500 hover:text-red-700">Rechazar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
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
<?php /**PATH /var/www/gimnasio/resources/views/admin-entrenador/solicitudes/index.blade.php ENDPATH**/ ?>