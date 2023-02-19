<?php $__env->startSection('title'); ?>
    Messages
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session()->has('error')): ?>

        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php echo e(session()->get('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>


    <?php elseif(session()->has('success')): ?>


        <div class="alert alert-success alert-dismissible" role="alert">
            <?php echo e(session()->get('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>

    <?php endif; ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($reg->name); ?></td>
                <td><?php echo e($reg->email); ?></td>
                <td><?php echo e($reg->message); ?></td>
                <td><?php echo e($reg->created_at->diffForHumans()); ?></td>
                <td><?php echo e($reg->status); ?></td>
                <td><a href="<?php echo e(route('attended',[$reg->id])); ?>" class="btn btn-primary">Mark as Attended</a></td>


            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($messages->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\LENOVO\Documents\github\NSSA_Paynow\resources\views/pages/messages.blade.php ENDPATH**/ ?>