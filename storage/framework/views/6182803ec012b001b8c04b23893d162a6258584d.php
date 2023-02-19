<?php $__env->startSection('content'); ?>

<div class="p-5">
    <form action="<?php echo e(route('save-settings')); ?>" method="post">
        <?php echo csrf_field(); ?>

    <h6 class="section-secondary-title">Transaction Fee Amounts</h6>
        <p>Check SSN</p>
    <div class="form-group">
        <input type="number" step="0.01" name="amount_check" class="form-control" id="exampleFormControlInput1" value="<?php echo e($settings->amount_check); ?>">
    </div>
        <p>Register</p>
    <div class="form-group">
        <input type="number" step="0.01" name="amount_register" class="form-control" id="exampleFormControlInput1" value="<?php echo e($settings->amount_register); ?>">
    </div>
        <p>Pension Card</p>
        <div class="form-group">
            <input type="number" step="0.01" name="amount_card" class="form-control" id="exampleFormControlInput1" value="<?php echo e($settings->amount_card); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\LENOVO\Documents\github\NSSA_Paynow\resources\views/pages/settings.blade.php ENDPATH**/ ?>