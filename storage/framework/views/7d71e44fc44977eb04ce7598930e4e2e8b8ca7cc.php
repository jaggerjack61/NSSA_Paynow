

<?php $__env->startSection('title'); ?>
    Reports
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo \Livewire\Livewire::styles(); ?>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('reports', [])->html();
} elseif ($_instance->childHasBeenRendered('QSEI64L')) {
    $componentId = $_instance->getRenderedChildComponentId('QSEI64L');
    $componentTag = $_instance->getRenderedChildComponentTagName('QSEI64L');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('QSEI64L');
} else {
    $response = \Livewire\Livewire::mount('reports', []);
    $html = $response->html();
    $_instance->logRenderedChild('QSEI64L', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php echo \Livewire\Livewire::scripts(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\LENOVO\Documents\github\NSSA_Paynow\resources\views/pages/reports.blade.php ENDPATH**/ ?>