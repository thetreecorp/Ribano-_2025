<?php $common = app('App\Http\Controllers\ProjectController'); ?>
<?php $projects = $common->getProjectFeatured(); ?>
<section class="featured-project">
        
    <div class="container">
        <div class="top-title-project text-center">
            <h6 class=""><?php echo e(translate("Find an investment opportunity that's right for you", null,false)); ?></h6>
           
        </div>

        
        
        <div class="column-sm" >
            <div class="row row-box" id="project-lists">
                <?php if(($projects)): ?>
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 wow fadeInUp col-box">
                            <?php echo $__env->make('project.project_box_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="no-result"><?php echo e(translate('No project found')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        
    </div>
    
    

</section><?php /**PATH D:\project\ribano\resources\views/themes/lightpink/partials/featured-project.blade.php ENDPATH**/ ?>