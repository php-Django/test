<!DOCTYPE html>
<html>
<head>
    <title><?php echo $__env->yieldContent('title', 'User Portal'); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">
            User Portal
        </a>

        <?php if(auth()->guard()->check()): ?>
            <div class="d-flex align-items-center gap-3">

                <a href="<?php echo e(route('profile')); ?>" class="text-white">
                    Profile
                </a>

                <a href="<?php echo e(route('education.index')); ?>" class="text-white">
                    Education
                </a>

                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-danger btn-sm">
                        Logout
                    </button>
                </form>

            </div>
        <?php endif; ?>

    </div>
</nav>

<div class="container py-4">

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

</div>

</body>
</html><?php /**PATH C:\Users\gagan\Downloads\user-portal\resources\views/layouts/app.blade.php ENDPATH**/ ?>