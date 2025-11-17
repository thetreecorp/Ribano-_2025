<?php if(isset($templates['about-us'][0]) && $aboutUs = $templates['about-us'][0]): ?>
    <!-- about_area_start -->
    <section id="about_area" class="about_area">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="section_content">
                        <div class="section_header">
                            <div class="section_subtitle"><?php echo app('translator')->get(@$aboutUs->description->title); ?></div>
                            
                            <div class="short_description"><?php echo app('translator')->get(@$aboutUs->description->short_description); ?></div>
                        </div>
                        <div class="button_area">
                            <a class="custom_btn mt-30 top-right-radius-0" href="<?php echo e(route('investmentStrategies')); ?>"><?php echo app('translator')->get('Learn more'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="image_area animation1">
                        <img class="img-fluid" src="<?php echo e(getFile(config('location.content.path').@$aboutUs->templateMedia()->image)); ?>" width="576px" height="384px" alt="<?php echo app('translator')->get('about image'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about_area_end -->
<?php endif; ?>

<?php /**PATH D:\project\ribano\resources\views/themes/lightpink/sections/about-us.blade.php ENDPATH**/ ?>