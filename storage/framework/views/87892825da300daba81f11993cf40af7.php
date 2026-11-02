

<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Create Account</h4>
            </div>

            <div class="card-body">

                <form method="POST" action="<?php echo e(route('register.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name"
                               value="<?php echo e(old('name')); ?>"
                               class="form-control" required>
                    </div>

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
                        <label>Confirm Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100">
                        Register
                    </button>

                </form>

                <p class="mt-3 text-center">
                    Already registered?
                    <a href="<?php echo e(route('login')); ?>">Login</a>
                </p>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gagan\Downloads\user-portal\resources\views/auth/register.blade.php ENDPATH**/ ?>