

<?php $__env->startSection('title'); ?>
    Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <?php echo \Livewire\Livewire::styles(); ?>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('dashboard', [])->html();
} elseif ($_instance->childHasBeenRendered('qPgMB6C')) {
    $componentId = $_instance->getRenderedChildComponentId('qPgMB6C');
    $componentTag = $_instance->getRenderedChildComponentTagName('qPgMB6C');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('qPgMB6C');
} else {
    $response = \Livewire\Livewire::mount('dashboard', []);
    $html = $response->html();
    $_instance->logRenderedChild('qPgMB6C', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
 <?php echo \Livewire\Livewire::scripts(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\LENOVO\Documents\github\NSSA_Paynow\resources\views/pages/dashboard.blade.php ENDPATH**/ ?>