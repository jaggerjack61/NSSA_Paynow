<div>
    <div class="p-4">
    <h2>Transactions</h2>
    <table  class="table table-striped">
        <thead>
            <tr>
                <th>Phone</th>
                <th>Paynow Reference</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Name</th>
                <th>SSN</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(str_replace('r','',str_replace('c','',$payment->reference))); ?></td>
                <td><?php echo e($payment->unique_id); ?></td>
                <td><?php echo e($payment->status); ?></td>
                <td><?php echo e($payment->amount); ?></td>
                <?php if($payment->details_id=='reg'): ?>
                    <td>Registration</td>
                    <td>Registration</td>
                <?php elseif($payment->details_id=='app'): ?>
                    <td>Portal Registration</td>
                    <td>Portal</td>
                <?php else: ?>
                    <td><?php echo e($payment->details->firstname.' '.$payment->details->lastname); ?></td>
                    <td><?php echo e($payment->details->ssn); ?></td>
                <?php endif; ?>

            <td><?php echo e($payment->created_at->diffForHumans()); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($payments->links()); ?>

    </div>
</div>
<?php /**PATH C:\Users\LENOVO\Documents\github\NSSA_Paynow\resources\views/livewire/dashboard.blade.php ENDPATH**/ ?>