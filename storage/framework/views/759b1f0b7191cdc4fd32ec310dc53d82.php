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
        <h2 class="text-xl font-semibold text-gray-800 leading-tight overflow-hidden truncate">
            <?php echo e(__('Gestión de Entrenamientos')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-between items-center">
            <!-- Botón Crear Entrenamiento -->
            <a href="<?php echo e(route('admin-entrenador.entrenamientos.create')); ?>"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Crear Entrenamiento
            </a>

            <!-- Botón Volver -->
            <a href="<?php echo e(route('admin-entrenador.dashboard')); ?>"
                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <!-- Tabla de Entrenamientos -->
        <div class="bg-white shadow-sm rounded-lg p-4">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Duración</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Usuarios</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $entrenamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrenamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-t">
                            <td class="px-4 py-2"><?php echo e($entrenamiento->nombre); ?></td>
                            <td class="px-4 py-2"><?php echo e($entrenamiento->tipo); ?></td>
                            <td class="px-4 py-2"><?php echo e($entrenamiento->duracion); ?> min</td>
                            <td class="px-4 py-2"><?php echo e($entrenamiento->fecha); ?></td>
                            <td class="px-4 py-2">
                                <a href="<?php echo e(route('admin-entrenador.entrenamientos.usuarios', $entrenamiento->id_entrenamiento)); ?>"
                                    class="text-blue-600 hover:underline">
                                    Ver (<?php echo e($entrenamiento->usuarios->count()); ?>)
                                </a>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="<?php echo e(route('admin-entrenador.entrenamientos.edit', $entrenamiento->id_entrenamiento)); ?>"
                                    class="text-yellow-600 hover:underline">Editar</a>
                                <form
                                    action="<?php echo e(route('admin-entrenador.entrenamientos.destroy', $entrenamiento->id_entrenamiento)); ?>"
                                    method="POST" class="inline-block"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este entrenamiento?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
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
<?php /**PATH /var/www/gimnasio/resources/views/admin-entrenador/entrenamientos/index.blade.php ENDPATH**/ ?>