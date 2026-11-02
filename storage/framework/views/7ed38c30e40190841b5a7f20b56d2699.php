

<?php $__env->startSection('title', 'Education'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h4>Add Education Qualification</h4>
    </div>

    <div class="card-body">

        <form method="POST" action="<?php echo e(route('education.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Degree</label>
                    <input type="text" name="degree"
                           class="form-control" required
                           placeholder="B.Tech, MCA, MBA">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Institution</label>
                    <input type="text" name="institution"
                           class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Field of Study</label>
                    <input type="text" name="field_of_study"
                           class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Start Year</label>
                    <input type="number" name="start_year"
                           class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label>End Year</label>
                    <input type="number" name="end_year"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Grade / Percentage</label>
                    <input type="text" name="grade"
                           class="form-control">
                </div>

            </div>

            <button class="btn btn-primary">
                Add Qualification
            </button>

        </form>

    </div>
</div>

<div class="card shadow-sm">

    <div class="card-header">
        <h4>My Qualifications</h4>
    </div>

    <div class="card-body">

        <?php $__empty_1 = true; $__currentLoopData = $educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <div class="border rounded p-3 mb-3">

                <h5><?php echo e($education->degree); ?></h5>

                <p class="mb-1">
                    <?php echo e($education->institution); ?>

                </p>

                <p class="text-muted mb-2">
                    <?php echo e($education->field_of_study); ?>

                    |
                    <?php echo e($education->start_year); ?> -
                    <?php echo e($education->end_year); ?>

                </p>

                <p>Grade: <?php echo e($education->grade); ?></p>

                <form method="POST"
                      action="<?php echo e(route('education.destroy', $education->id)); ?>"
                      onsubmit="return confirm('Delete this qualification?')">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>

                    <button class="btn btn-danger btn-sm">
                        Delete
                    </button>

                </form>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <p class="text-muted">
                No education qualifications added yet.
            </p>

        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gagan\Downloads\user-portal\resources\views/profile/education.blade.php ENDPATH**/ ?>