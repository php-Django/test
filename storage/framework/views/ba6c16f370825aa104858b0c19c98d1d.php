

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<h3>Welcome, <?php echo e($user->name); ?>!</h3>

<div class="row mt-4">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Account Email</h6>
                <h5><?php echo e($user->email); ?></h5>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Education Qualifications</h6>
                <h5><?php echo e($totalEducation); ?></h5>
            </div>
        </div>
    </div>

</div>

<div class="mt-4">
    <a href="<?php echo e(route('profile')); ?>" class="btn btn-primary">
        Update Profile
    </a>

    <a href="<?php echo e(route('education.index')); ?>" class="btn btn-success">
        Manage Education
    </a>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gagan\Downloads\user-portal\resources\views/dashboard.blade.php ENDPATH**/ ?>