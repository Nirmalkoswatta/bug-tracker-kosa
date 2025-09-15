<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    .dropdown-item.logout-red {
    color: #dc3545 !important;
    font-weight: 600;
    background: transparent !important;
    }
    .dropdown-menu {
    background: #fff !important;
    }
    .dropdown-item.logout-red:hover, .dropdown-item.logout-red:focus {
    background: #ffeaea !important;
    color: #a71d2a !important;
    }
    <style>
        .navbar,
        .navbar * {
            color: #fff !important;
            font-size: 1.15rem;
        }

        .navbar .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar .nav-link,
        .navbar .dropdown-toggle {
            font-size: 1.15rem;
        }

        .btn-login,
        .btn-register,
        .btn-success {
            font-size: 1.15rem !important;
            background: #333333 !important;
            border: 1px solid #555555 !important;
            border-radius: 4px !important;
        }

        .btn-login:hover,
        .btn-register:hover,
        .btn-success:hover {
            background: #444444 !important;
            border-color: #666666 !important;
        }

        body {
            background: #000000;
            min-height: 100vh;
            overflow-x: hidden;
            color: #fff;
        }

        /* Remove all gradient overlays and animations */
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Bug Tracker</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <!-- Tailwind CDN (temporary until compiled) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css" rel="stylesheet" />
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body style="background: #000 !important; min-height: 100vh;">
    <div id="app" class="relative" style="z-index:1;">
        <nav class="navbar navbar-expand-md navbar-light fixed-top" style="background: #000000 !important; border-bottom: 1px solid #333333; z-index: 1040;">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    Bug Tracker
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>
                    <ul class="navbar-nav ms-auto align-items-center">
                        <?php if(auth()->guard()->guest()): ?>
                        
                        <?php else: ?>
                        <li class="nav-item me-3">
                            <span class="badge bg-primary px-3 py-2" style="font-size: 0.9rem; border-radius: 12px;">
                                <i class="fas fa-user"></i> <?php echo e(Auth::user()->role); ?>

                            </span>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo e(Auth::user()->name); ?>

                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php if(Auth::user()->isSuperAdmin()): ?>
                                <a class="dropdown-item" href="<?php echo e(route('superadmin.dashboard')); ?>">
                                    <i class="fas fa-crown"></i> Super Admin Dashboard
                                </a>
                                <div class="dropdown-divider"></div>
                                <?php elseif(Auth::user()->isAdmin()): ?>
                                <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                                    <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                                </a>
                                <div class="dropdown-divider"></div>
                                <?php endif; ?>
                                <a class="dropdown-item logout-red" href="<?php echo e(route('logout')); ?>"
                                    style="color: #dc3545 !important; font-weight: 600; background: transparent !important;"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> <?php echo e(__('Logout')); ?>

                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4" style="padding-top: 80px;">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/layouts/app.blade.php ENDPATH**/ ?>