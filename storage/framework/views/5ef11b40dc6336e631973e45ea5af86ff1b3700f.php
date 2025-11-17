<?php if(count($data)): ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4 wow fadeInUp col-box">

        <?php echo $__env->make('project.project_box' , compact('project'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
<p class="no-result"><?php echo e(trans('No project found')); ?></p>
<?php endif; ?>

<?php /**PATH D:\project\ribano\resources\views/project/ajax/ajax_search_content.blade.php ENDPATH**/ ?>