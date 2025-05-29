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
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        
        <?php $__currentLoopData = ['success' => 'green', 'error' => 'red']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(session($type)): ?>
                <div
                    class="p-4 rounded-lg bg-<?php echo e($color); ?>-50 border border-<?php echo e($color); ?>-300 text-<?php echo e($color); ?>-800 shadow-sm">
                    <h2 class="font-semibold text-lg mb-1"><?php echo e($type === 'success' ? '¡Éxito!' : 'Error'); ?></h2>
                    <p><?php echo e(session($type)); ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <h1 class="text-3xl font-bold text-gray-800">Usuarios</h1>

        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <a href="<?php echo e(route('admin.usuarios.create')); ?>"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Usuario
            </a>

            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                ← Volver al dashboard
            </a>
        </div>

        
        <div class="bg-white p-6 rounded-lg shadow-md w-full">
            <form method="GET" action="<?php echo e(route('admin.usuarios.index')); ?>"
                class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 w-full">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700">Buscar por nombre o
                        email</label>
                    <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Ej: usuario@example.com">
                </div>

                <div class="flex flex-col md:flex-row md:items-end gap-2">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="role" id="role"
                            class="mt-1 w-full md:w-40 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Todos --</option>
                            <?php $__currentLoopData = ['admin', 'entrenador', 'cliente', 'admin_entrenador']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role); ?>" <?php echo e(request('role') === $role ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($role)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="flex gap-2 mt-1 md:mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                            🔍 Filtrar
                        </button>
                        <a href="<?php echo e(route('admin.usuarios.index')); ?>"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md text-sm font-medium transition-colors">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Roles</th>
                        <th class="px-6 py-3 text-center">Estado</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900"><?php echo e($user->name); ?></td>
                            <td class="px-6 py-4 text-gray-600"><?php echo e($user->email); ?></td>
                            <td class="px-6 py-4 space-x-1">
                                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                        <?php echo e(match ($role->name) {
                                            'admin' => 'bg-red-200 text-red-800',
                                            'entrenador' => 'bg-green-200 text-green-800',
                                            'cliente' => 'bg-blue-200 text-blue-800',
                                            'admin_entrenador' => 'bg-purple-200 text-purple-800',
                                            default => 'bg-gray-200 text-gray-800',
                                        }); ?>">
                                        <?php echo e(ucfirst($role->name)); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($users->isEmpty()): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                No se encontraron usuarios con esos criterios.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="px-2 py-0.5 rounded-full text-xs font-medium
                                    <?php echo e($user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($user->is_active ? 'Activo' : 'Inactivo'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-center space-x-1">
                        <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                            class="inline-flex items-center px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md"
                            title="Editar usuario">
                            <i data-feather="edit"></i>
                        </a>
                        <form action="<?php echo e(route('admin.users.resetPassword', $user->id)); ?>" method="POST"
                            class="inline"
                            onsubmit="event.preventDefault(); confirmAction('¿Deseas resetear la contraseña de este usuario?', this);">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="inline-flex items-center px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md"
                                title="Resetear contraseña">
                                <i data-feather="refresh-ccw"></i>
                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.users.changeStatus', $user->id)); ?>" method="POST" class="inline"
                            onsubmit="event.preventDefault(); confirmAction('¿Deseas cambiar el estado de este usuario?', this);">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="inline-flex items-center px-2 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-md"
                                title="Cambiar estado">
                                <i data-feather="toggle-left"></i>
                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="inline"
                            onsubmit="event.preventDefault(); confirmAction('¿Estás seguro de eliminar este usuario?', this);">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md"
                                title="Eliminar usuario">
                                <i data-feather="trash-2"></i>
                            </button>
                        </form>
                    </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div class="mt-4">
            <?php echo e($users->links()); ?>

        </div>

        
        <div id="confirm-modal"
            class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Confirmar acción</h2>
                <p class="text-gray-600 mb-6" id="confirm-message">¿Estás seguro?</p>
                <div class="flex justify-end gap-2">
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">Cancelar</button>
                    <button id="confirm-button"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">Confirmar</button>
                </div>
            </div>
        </div>

        
        <script>
            let formToSubmit = null;

            function confirmAction(message, form) {
                document.getElementById('confirm-message').innerText = message;
                document.getElementById('confirm-modal').classList.remove('hidden');
                formToSubmit = form;
            }

            function closeModal() {
                document.getElementById('confirm-modal').classList.add('hidden');
                formToSubmit = null;
            }

            document.getElementById('confirm-button').addEventListener('click', () => {
                if (formToSubmit) formToSubmit.submit();
            });

            document.addEventListener('DOMContentLoaded', () => {
                if (typeof feather !== 'undefined') feather.replace();
            });
        </script>
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
<?php /**PATH /var/www/gimnasio/resources/views/admin/users/index.blade.php ENDPATH**/ ?>