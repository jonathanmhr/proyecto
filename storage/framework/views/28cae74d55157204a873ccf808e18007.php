<aside x-data="{ open: false, hasNewNotification: false }"
    class="fixed top-4 left-4 h-[calc(100vh-2rem)] transition-all duration-300 bg-gray-100 rounded-xl shadow-md flex flex-col items-center py-4 z-50"
    :class="open ? 'w-64 items-start' : 'w-20 items-center'" @mouseenter="open = true" @mouseleave="open = false">

    <!-- Logo -->
    <div class="mb-6">
        <a href="<?php echo e(route('dashboard')); ?>">
            <?php if (isset($component)) { $__componentOriginaldaff26d4e64b9d6b339909684d09d478 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldaff26d4e64b9d6b339909684d09d478 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-mark','data' => ['class' => 'h-8 w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-auto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldaff26d4e64b9d6b339909684d09d478)): ?>
<?php $attributes = $__attributesOriginaldaff26d4e64b9d6b339909684d09d478; ?>
<?php unset($__attributesOriginaldaff26d4e64b9d6b339909684d09d478); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldaff26d4e64b9d6b339909684d09d478)): ?>
<?php $component = $__componentOriginaldaff26d4e64b9d6b339909684d09d478; ?>
<?php unset($__componentOriginaldaff26d4e64b9d6b339909684d09d478); ?>
<?php endif; ?>
        </a>
    </div>

    <!-- Navegación principal -->
    <nav class="flex-1 w-full space-y-2 px-2 text-gray-700">

        <?php if (isset($component)) { $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $attributes; } ?>
<?php $component = App\View\Components\SidebarLink::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SidebarLink::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'user','route' => 'dashboard','label' => 'Mi Perfil']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $attributes = $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $component = $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-access')): ?>
            <?php if (isset($component)) { $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $attributes; } ?>
<?php $component = App\View\Components\SidebarLink::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SidebarLink::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'shield','route' => 'admin.dashboard','label' => 'Panel de Admin']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $attributes = $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $component = $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin_entrenador')): ?>
            <div x-data="{ openAdminEntrenador: false }" class="w-full">
                <button @click="openAdminEntrenador = !openAdminEntrenador"
                    class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all"
                    :class="open ? 'justify-start' : 'justify-center'">
                    <i data-feather="briefcase" class="w-5 h-5"></i>
                    <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Admin Entrenador</span>
                    <i data-feather="chevron-down" class="ml-auto" x-show="open"></i>
                </button>

                <div x-show="open && openAdminEntrenador" x-cloak x-transition class="ml-6 mt-1 space-y-1">
                    <?php if (isset($component)) { $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $attributes; } ?>
<?php $component = App\View\Components\SidebarLink::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SidebarLink::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'layout','route' => 'admin-entrenador.dashboard','label' => 'Panel General']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $attributes = $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $component = $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('entrenador-access')): ?>
            <div x-data="{ openEntrenador: false }" class="w-full">
                <button @click="openEntrenador = !openEntrenador"
                    class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all"
                    :class="open ? 'justify-start' : 'justify-center'">
                    <i data-feather="briefcase" class="w-5 h-5"></i>
                    <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Entrenador</span>
                    <i data-feather="chevron-down" class="ml-auto" x-show="open"></i>
                </button>

                <div x-show="open && openEntrenador" x-cloak x-transition class="ml-6 mt-1 space-y-1 text-gray-600">
                    <?php if (isset($component)) { $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $attributes; } ?>
<?php $component = App\View\Components\SidebarLink::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SidebarLink::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'layout','route' => 'entrenador.dashboard','label' => 'Panel General']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $attributes = $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $component = $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cliente-access')): ?>
            <?php if (isset($component)) { $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $attributes; } ?>
<?php $component = App\View\Components\SidebarLink::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SidebarLink::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'shopping-bag','route' => 'entrenador.clases.index','label' => 'Mis Suscripciones']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $attributes = $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $component = $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['cliente-access', 'entrenador-access', 'admin_entrenador'])): ?>
            <?php if (isset($component)) { $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $attributes; } ?>
<?php $component = App\View\Components\SidebarLink::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SidebarLink::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'calendar','route' => 'cliente.dashboard','label' => 'Clases Disponibles']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $attributes = $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $component = $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3 = $attributes; } ?>
<?php $component = App\View\Components\SidebarLink::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SidebarLink::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'message-circle','route' => 'cliente.clases.index','label' => 'Comunidad']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $attributes = $__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__attributesOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3)): ?>
<?php $component = $__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3; ?>
<?php unset($__componentOriginal1fd94b5e42443fcea5156cbe1201dbc3); ?>
<?php endif; ?>
        <?php endif; ?>
    </nav>

    <?php
        $notificacionesNoLeidas = auth()->user()->unreadNotifications()->count();
        $badgeCount = $notificacionesNoLeidas > 9 ? '+9' : $notificacionesNoLeidas;
    ?>

    <div class="w-full px-2 mb-4" x-data="{ notificaciones: <?php echo e($notificacionesNoLeidas); ?> }">
        <!-- Mostrar campana solo si hay notificaciones -->
        <template x-if="notificaciones > 0">
            <a href="<?php echo e(route('entrenador.dashboard')); ?>"
                class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all relative"
                :class="open ? 'justify-start' : 'justify-center'" title="Notificaciones">
                <div class="relative">
                    <i data-feather="bell" class="w-5 h-5"></i>

                    <span
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full"
                        style="min-width: 1.25rem; height: 1.25rem; line-height: 1.25rem;">
                        <?php echo e($badgeCount); ?>

                    </span>
                </div>

                <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Notificaciones</span>
            </a>
        </template>
    </div>



    <!-- Ajustes de perfil -->
    <div class="w-full px-2">
        <a href="<?php echo e(route('profile.show')); ?>"
            class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all"
            :class="open ? 'justify-start' : 'justify-center'">
            <i data-feather="settings" class="w-5 h-5"></i>
            <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Ajustes</span>
        </a>

        <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
            <?php echo csrf_field(); ?>
            <button type="submit"
                class="flex items-center gap-3 w-full text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-2 rounded-lg text-sm transition-all"
                :class="open ? 'justify-start' : 'justify-center'">
                <i data-feather="log-out" class="w-5 h-5"></i>
                <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Cerrar sesión</span>
            </button>
        </form>
    </div>

</aside>
<?php /**PATH /var/www/gimnasio/resources/views/components/sidebar.blade.php ENDPATH**/ ?>