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
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            <?php echo e(__('Panel de Usuario')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-black mb-6">
            👋 ¡Bienvenido de nuevo, <?php echo e(auth()->user()->name); ?>!
        </h1>

        <?php if(session('incomplete_profile')): ?>
            <div class="alert alert-warning bg-yellow-200 text-yellow-800 p-4 rounded-lg mb-4">
                <?php echo e(session('incomplete_profile')); ?>

            </div>
        <?php endif; ?>

        <!-- Modal para completar el perfil -->
        <?php if($incompleteProfile): ?>
            <div id="profile-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50"
                style="display: flex;">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">¡Tu perfil está incompleto!</h2>
                    <p class="text-gray-700 mb-4">Por favor, completa tus datos para acceder a las clases y
                        entrenamientos personalizados.</p>
                    <div class="flex justify-end gap-2">
                        <a href="<?php echo e(route('perfil.completar')); ?>"
                            class="bg-teal-500 text-white px-4 py-2 rounded-lg">Completar Perfil</a>
                        <button class="bg-gray-500 text-white px-4 py-2 rounded-lg"
                            onclick="closeModal()">Cerrar</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Mostrar notificación de éxito -->
        <?php if(session('status') && session('status_type') == 'success'): ?>
            <div class="flex items-center bg-green-200 text-green-800 p-4 rounded-lg mb-4">
                <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                <span><?php echo e(session('status')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Mostrar notificación de error -->
        <?php if(session('status') && session('status_type') == 'error'): ?>
            <div class="flex items-center bg-red-200 text-red-800 p-4 rounded-lg mb-4">
                <i data-feather="alert-triangle" class="w-5 h-5 mr-2"></i>
                <span><?php echo e(session('status')); ?></span>
            </div>
        <?php endif; ?>

        <?php if($datosCompletos): ?>
            <div class="bg-gradient-to-r from-cyan-700 to-cyan-500 p-6 rounded-2xl shadow mb-6">
                <h2 class="text-xl font-semibold text-cyan-200 mb-4 flex items-center gap-2">
                    <i data-feather="user" class="w-5 h-5"></i> Mi Perfil
                </h2>
                <ul class="text-white space-y-2">
                    <li><strong>Fecha de Nacimiento:</strong>
                        <?php echo e(\Carbon\Carbon::parse($perfil->fecha_nacimiento)->format('d/m/Y')); ?></li>
                    <li><strong>Peso:</strong> <?php echo e($perfil->peso); ?> kg</li>
                    <li><strong>Altura:</strong> <?php echo e($perfil->altura); ?> cm</li>
                    <li><strong>Objetivo:</strong> <?php echo e($perfil->objetivo); ?></li>
                    <li><strong>Nivel:</strong>
                        <?php switch($perfil->id_nivel):
                            case (1): ?>
                                Principiante
                            <?php break; ?>

                            <?php case (2): ?>
                                Intermedio
                            <?php break; ?>

                            <?php case (3): ?>
                                Avanzado
                            <?php break; ?>
                        <?php endswitch; ?>
                    </li>
                </ul>
                <div class="mt-4">
                    <a href="<?php echo e(route('perfil.editar')); ?>" class="bg-teal-600 text-white px-4 py-2 rounded-lg">Editar
                        perfil</a>
                </div>
            </div>
        <?php endif; ?>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Clases Inscritas -->
            <div
                class="bg-gradient-to-r from-green-700 to-green-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500 group">
                <h2 class="text-xl font-semibold text-lime-100 mb-4 flex items-center gap-2">
                    <i data-feather="book-open" class="w-5 h-5"></i> Clases Inscritas
                </h2>

                <?php if($clases->isEmpty()): ?>
                    <p class="text-white animate-fade-in">No estás inscrito en ninguna clase por ahora.</p>
                <?php else: ?>
                    <div
                        class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100">
                        <?php $__currentLoopData = $clases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-b border-teal-200 pb-2 mb-2">
                                <div class="text-white font-medium"><?php echo e($clase->nombre); ?></div>
                                <div class="text-sm text-white"><?php echo e($clase->descripcion); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Entrenamientos -->
            <div
                class="group bg-gradient-to-r from-purple-700 to-purple-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500">
                <h2 class="text-xl font-semibold text-purple-200 mb-4 flex items-center gap-2">
                    <i data-feather="activity" class="w-5 h-5"></i> Entrenamientos
                </h2>

                <?php if($entrenamientos->isEmpty()): ?>
                    <p class="text-white animate-fade-in">No tienes entrenamientos asignados.</p>
                <?php else: ?>
                    <div
                        class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100">
                        <?php $__currentLoopData = $entrenamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrenamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-b border-purple-200 pb-2 mb-2">
                                <div class="text-white font-medium"><?php echo e($entrenamiento->nombre); ?></div>
                                <div class="text-sm text-white"><?php echo e($entrenamiento->descripcion); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Suscripciones -->
            <div
                class="group bg-gradient-to-r from-pink-700 to-pink-500 p-6 rounded-2xl hover:shadow-xl transition-all duration-500">
                <h2 class="text-xl font-semibold text-pink-200 mb-4 flex items-center gap-2">
                    <i data-feather="calendar" class="w-5 h-5"></i> Suscripciones Activas
                </h2>

                <?php if($suscripciones->isEmpty()): ?>
                    <p class="text-white animate-fade-in">Aún no tienes suscripciones.</p>
                <?php else: ?>
                    <div
                        class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100">
                        <?php $__currentLoopData = $suscripciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suscripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($suscripcion->clase): ?>
                                <div class="border-b border-pink-200 pb-2 mb-2">
                                    <div class="text-white font-medium"><?php echo e($suscripcion->clase->nombre); ?></div>
                                    <div class="text-sm text-white">
                                        <?php if($suscripcion->created_at): ?>
                                            Suscrito el <?php echo e($suscripcion->created_at->format('d/m/Y')); ?>

                                        <?php else: ?>
                                            Suscripción sin fecha
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="text-sm text-red-500">❌ Clase eliminada de una suscripción anterior.</div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Notificaciones -->

            <div class="mt-8 bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="bell" class="w-6 h-6 text-blue-600"></i>
                        Notificaciones
                    </h2>
                    <?php if($notificaciones->whereNull('read_at')->count() > 0): ?>
                        <form action="<?php echo e(route('perfil.notificaciones.marcarTodasLeidas')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="text-sm bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Marcar todas como leídas
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <?php if($notificaciones->isEmpty()): ?>
                    <p class="text-gray-600">No tienes notificaciones recientes.</p>
                <?php elseif($notificaciones->whereNull('read_at')->count() === 0): ?>
                    <p class="text-green-700 bg-green-100 p-4 rounded-lg flex items-center gap-2">
                        <i data-feather="check-circle" class="w-5 h-5"></i>
                        No tienes notificaciones pendientes.
                    </p>
                <?php else: ?>
                    <ul class="space-y-4">
                        <?php $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li
                                class="flex items-start justify-between gap-4 p-4 rounded-lg border <?php echo e(!$notificacion->read_at ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200'); ?>">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <i data-feather="mail"
                                            class="w-5 h-5 <?php echo e(!$notificacion->read_at ? 'text-blue-600' : 'text-gray-400'); ?>"></i>
                                        <span class="font-medium text-gray-800">
                                            <?php echo e($notificacion->data['mensaje'] ?? 'Sin mensaje'); ?>

                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        <?php echo e($notificacion->created_at->format('d/m/Y H:i')); ?>

                                    </p>
                                </div>
                                <div>
                                    <?php if(!$notificacion->read_at): ?>
                                        <form
                                            action="<?php echo e(route('perfil.notificaciones.marcarLeida', $notificacion->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                class="text-sm text-blue-600 hover:underline hover:text-blue-800">
                                                Marcar como leída
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="inline-block text-xs bg-gray-300 text-white px-2 py-1 rounded">
                                            Leída
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>




        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            feather.replace();

            function closeModal() {
                document.getElementById('profile-modal').style.display = 'none';
            }
        </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\xampp\htdocs\jonathan\gimnasio\resources\views/dashboard.blade.php ENDPATH**/ ?>