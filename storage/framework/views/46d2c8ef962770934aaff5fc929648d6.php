

<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm">

    <div class="card-header">
        <h4>Update Profile</h4>
    </div>

    <div class="card-body">

        <form action="<?php echo e(route('profile.update')); ?>" method="POST">

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name"
                       value="<?php echo e(old('name', $user->name)); ?>"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" value="<?php echo e($user->email); ?>"
                       class="form-control" disabled>
                <small class="text-muted">
                    Email cannot be changed here.
                </small>
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone"
                       value="<?php echo e(old('phone', $user->phone)); ?>"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth"
                       value="<?php echo e(old('date_of_birth', $user->date_of_birth)); ?>"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address"
                          class="form-control"><?php echo e(old('address', $user->address)); ?></textarea>
            </div>

            <button class="btn btn-primary">
                Update Profile
            </button>

        </form>

    </div>
</div>

<div class="mt-3">
    <a href="<?php echo e(route('education.index')); ?>" class="btn btn-success">
        Manage Education Qualifications
    </a>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gagan\Downloads\user-portal\resources\views/profile/index.blade.php ENDPATH**/ ?>