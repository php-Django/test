

<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Login</h4>
            </div>

            <div class="card-body">

                <form method="POST" action="<?php echo e(route('login.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email"
                               value="<?php echo e(old('email')); ?>"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <input type="checkbox" name="remember" value="1">
                        Remember Me
                    </div>

                    <button class="btn btn-primary w-100">
                        Login
                    </button>

                </form>

                <p class="mt-3 text-center">
                    New user?
                    <a href="<?php echo e(route('register')); ?>">Register</a>
                </p>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gagan\Downloads\user-portal\resources\views/auth/login.blade.php ENDPATH**/ ?>