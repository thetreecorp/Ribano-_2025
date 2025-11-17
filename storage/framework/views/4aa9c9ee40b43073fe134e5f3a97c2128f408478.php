<?php if(isset($templates['why-chose-us'][0]) && $whyChoseUs = $templates['why-chose-us'][0]): ?>
    <section class="why_choose_investment shape1">
        <div class="container">
            <div class="row">
                <div class="section_header mb-50 text-center">
                    <h4><?php echo app('translator')->get($whyChoseUs->description->title); ?></h4>
                    <h5><?php echo app('translator')->get($whyChoseUs->description->sub_title); ?></h5>
                    <p class="para_text"><?php echo app('translator')->get($whyChoseUs->description->short_details); ?></p>
                </div>
            </div>
            <?php if(isset($contentDetails['why-chose-us'])): ?>
                <div class="row g-5 align-items-center">
                    
                    <?php $__currentLoopData = $contentDetails['why-chose-us']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-md-3 text-center">
                            
                            <div class="image_area">
                                <img src="<?php echo e(getFile(config('location.content.path').@$item->content->contentMedia->description->image)); ?>" alt="<?php echo app('translator')->get('why-choose-us image'); ?>">
                            </div>
                            <div class="text_area">
                                <h5><?php echo app('translator')->get(@$item->description->title); ?></h5>
                                <p><?php echo app('translator')->get(@$item->description->information); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<!-- why_choose_investment_plan_area_end -->
<?php /**PATH D:\project\ribano-new-look\resources\views/themes/lightpink/sections/why-chose-us.blade.php ENDPATH**/ ?>