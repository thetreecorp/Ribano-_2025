<?php $__env->startPush('style'); ?>
    <?php echo \Livewire\Livewire::styles(); ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

<?php $__env->stopPush(); ?>
<?php $__env->startSection('title', translate($title)); ?>

<?php $__env->startSection('content'); ?>

    <div class="card-body">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('wizard', [])->html();
} elseif ($_instance->childHasBeenRendered('1QFUl4j')) {
    $componentId = $_instance->getRenderedChildComponentId('1QFUl4j');
    $componentTag = $_instance->getRenderedChildComponentTagName('1QFUl4j');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('1QFUl4j');
} else {
    $response = \Livewire\Livewire::mount('wizard', []);
    $html = $response->html();
    $_instance->logRenderedChild('1QFUl4j', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
     </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\ribano\resources\views/project/create.blade.php ENDPATH**/ ?>