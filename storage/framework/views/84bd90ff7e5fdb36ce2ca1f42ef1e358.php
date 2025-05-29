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
    <div class="container mx-auto mt-6">
        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <h2 class="text-2xl font-bold mb-4">Gestión de Entrenadores</h2>


        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <!-- Botón Agregar Entrenador -->
            <a href="<?php echo e(route('admin-entrenador.entrenadores.create')); ?>"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition w-[160px] justify-center">
                <i data-feather="user-plus" class="w-4 h-4"></i> Agregar
            </a>

            <!-- Botón Volver -->
            <a href="<?php echo e(route('admin-entrenador.dashboard')); ?>"
                class="bg-green-100 hover:bg-green-200 text-green-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition w-[160px] justify-center">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Volver
            </a>
        </div>


        <!-- Tabla de Entrenadores -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700">Nombre</th>
                        <th class="px-4 py-2 text-left text-gray-700">Correo</th>
                        <th class="px-4 py-2 text-left text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $entrenadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrenador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?php echo e($entrenador->name ?? 'Nombre no disponible'); ?></td>
                            <td class="px-4 py-2"><?php echo e($entrenador->email ?? 'Correo no disponible'); ?></td>
                            <td class="px-4 py-2 space-x-2">
                                <!-- Editar Entrenador -->
                                <a href="<?php echo e(route('admin-entrenador.entrenadores.edit', $entrenador)); ?>"
                                    class="text-blue-500 hover:text-blue-700">
                                    Editar
                                </a>

                                <form action="<?php echo e(route('admin-entrenador.entrenadores.darBaja', $entrenador->id)); ?>"
                                    method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('POST'); ?>
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        Dar Baja
                                    </button>
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
<?php /**PATH /var/www/gimnasio/resources/views/admin-entrenador/entrenadores/index.blade.php ENDPATH**/ ?>