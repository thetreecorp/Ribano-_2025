
<?php if(isset($contentDetails['feature'])): ?>
    <?php if(0 < count($contentDetails['feature'])): ?>
        <!-- Feature_area_start -->
        <section class="feature_area mt-5 mt-lg-0">
            <div class="container">
                <div class="row g-5 justify-content-center">
                    <?php $__currentLoopData = $contentDetails['feature']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-6 col-md-6 mb-5">
                        <div class="cmn_box box1 text-center custom_zindex shadow2">
                            <div class="cmn_icon icon1">
                                <img src="<?php echo e(getFile(config('location.content.path').@$feature->content->contentMedia->description->image)); ?>" alt="<?php echo app('translator')->get('feature image'); ?>">
                            </div>
                            <h4 class="pt-50"><?php echo app('translator')->get(@$feature->description->information); ?></h4>
                            <h5 class=""><?php echo app('translator')->get(@$feature->description->title); ?></h5>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\project\ribano-new-look\resources\views/themes/lightpink/sections/feature.blade.php ENDPATH**/ ?>