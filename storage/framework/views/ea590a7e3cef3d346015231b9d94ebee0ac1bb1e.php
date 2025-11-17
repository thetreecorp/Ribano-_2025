<?php if(isset($templates['faq'][0]) && $faq = $templates['faq'][0]): ?>
    <?php if(0 < count($contentDetails['faq'])): ?>
        <section class="faq_area">
            <div class="container">
                <div class="row">
                    <div class="section_header text-center">
                        <div class="section_subtitle faq_section_subtitle"><?php echo app('translator')->get(@$faq->description->title); ?></div>
                        <h1><?php echo app('translator')->get(@$faq->description->sub_title); ?></h1>
                        <p class="m-auto para_text"><?php echo app('translator')->get(@$faq->description->short_details); ?></p>
                    </div>
                </div>
                <?php if(isset($contentDetails['faq'])): ?>
                    <div class="row">
                        <?php $__currentLoopData = $contentDetails['faq']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-12" data-aos="fade-left">
                                <div class="accordion_area mt-45">
                                    <div class="accordion_item shadow3">
                                        <button class="accordion_title"><?php echo app('translator')->get(@$data->description->title); ?><i
                                                class="<?php echo e(($k == 0) ? 'fa fa-minus': 'fa fa-plus'); ?>"></i></button>
                                        <div class="accordion_body <?php echo e(($k == 0) ? 'show' : ''); ?>">
                                            <?php echo app('translator')->get(@$data->description->description); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\project\ribano-new-look\resources\views/themes/lightpink/sections/faq.blade.php ENDPATH**/ ?>