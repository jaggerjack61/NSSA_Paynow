<?php $__env->startSection('title'); ?>
    Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>First Names</th>
                <th>Lastname</th>
                <th>DOB</th>
                <th>ID No</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Position</th>
                <th>Start-End</th>
                <th>Salary</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($reg->first_names); ?></td>
                <td><?php echo e($reg->last_name); ?></td>
                <td><?php echo e($reg->dob); ?></td>
                <td><?php echo e($reg->id_number); ?></td>
                <td><?php echo e($reg->email); ?></td>
                <td><?php echo e($reg->phone); ?></td>
                <td><?php echo e($reg->company); ?></td>
                <td><?php echo e($reg->occupation); ?></td>
                <td><?php echo e($reg->start_date); ?>-<?php echo e($reg->end_date); ?></td>
                <td><?php echo e($reg->salary); ?></td>
                <?php if($reg->status=='complete'): ?>
                <td>Not Registered</td>
                <?php elseif($reg->status=='registered'): ?>
                <td>Registered</td>
                <?php else: ?>
                <td>Unknown Status</td>
                <?php endif; ?>
                <?php if($reg->status=='complete'): ?>
                    <td><a class="btn btn-primary" href="<?php echo e(route('register',[$reg->id])); ?>">Register</a></td>
                <?php elseif($reg->status=='registered'): ?>
                    <td><a class="btn btn-secondary" href="<?php echo e(route('unregister',[$reg->id])); ?>">unRegister</a></td>
                <?php else: ?>
                    <td>Unknown Status</td>
                <?php endif; ?>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($registrations->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\LENOVO\Documents\github\NSSA_Paynow\resources\views/pages/registrations.blade.php ENDPATH**/ ?>