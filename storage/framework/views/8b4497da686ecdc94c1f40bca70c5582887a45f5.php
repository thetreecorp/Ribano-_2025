

    <?php if(array_key_exists('home-slider', $contentDetails->toArray())): ?>
    <section class="hero-slider hero-style container">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $contentDetails['home-slider']->take(5)->sortDesc(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <div class="swiper-slide">
                        <div class="slide-inner slide-bg-image" data-background="<?php echo e(getFile(config('location.content.path').@$data->content->contentMedia->description->image)); ?>">
                            <div class="container" >
                                <div data-swiper-parallax="300" class="slide-title">
                                    <h2><?php echo e($data->description->title); ?></h2>
                                </div>
                                <?php echo $__env->make($theme.'partials.slider-box-text', ['desc' => $data->description->description], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end slide-inner -->
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php else: ?>
        <section class="hero-slider hero-style container">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-inner slide-bg-image" data-background="<?php echo e(asset('assets/images/bg-for-all.jpg')); ?>">
                            <div class="container">
                                <div data-swiper-parallax="300" class="slide-title">
                                    <h2><?php echo e(@translate("Establish the right partnership according to Islamic principles")); ?></h2>
                                </div>
                                <?php echo $__env->make($theme.'partials.slider-box-text', ['desc' => ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="clearfix"></div>
                                
                            </div>
                        </div>
                        <!-- end slide-inner -->
                    </div>
                    <!-- end swiper-slide -->

                    <div class="swiper-slide">
                        <div class="slide-inner slide-bg-image" data-background="<?php echo e(asset('assets/images/bg-for-all.jpg')); ?>">
                            <div class="container">
                                <div data-swiper-parallax="300" class="slide-title">
                                    <h2>@translate("Socially responsible Investing")</h2>
                                </div>
                                <?php echo $__env->make($theme.'partials.slider-box-text', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end slide-inner -->
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-inner slide-bg-image" data-background="<?php echo e(asset('assets/images/bg-for-all.jpg')); ?>">
                            <div class="container">
                                <div data-swiper-parallax="300" class="slide-title">
                                    <h2><?php echo e(@translate("Here's where the right investor meets the right founder")); ?></h2>
                                </div>
                                <?php echo $__env->make($theme.'partials.slider-box-text', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end slide-inner -->
                    </div>
                    <!-- end swiper-slide -->
                </div>
                <!-- end swiper-wrapper -->

                <!-- swipper controls -->
                
            </div>
        </section>
    <?php endif; ?>
<?php /**PATH D:\project\ribano\resources\views/themes/lightpink/partials/banner-slider.blade.php ENDPATH**/ ?>