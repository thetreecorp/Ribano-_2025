<?php if(isset($templates['we-accept'][0]) && $weAccept = $templates['we-accept'][0]): ?>
    <section class="payment_area shape2">
        <div class="container">
            <div class="row">
                <div class="section_header text-center mb-50">
                    <div class="section_subtitle mx-auto">PAYMENTS</div>
                    <h1>You can pay with all payment methods</h1>
                </div>
                <div class="owl-carousel owl-theme payment_slider text-center <?php echo e((session()->get('rtl') == 1) ? 'partners-rtl': 'partners'); ?>">
                    <div class="item">
                        <div class="image_area">
                            <img src="<?php echo e(asset('assets/images/x-wallet.png')); ?>" alt="X wallet">
                        </div>
                    </div>
                    <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <div class="image_area">
                                <img src="<?php echo e(getFile(config('location.gateway.path').@$gateway->image)); ?>" alt="<?php echo e(@$gateway->name); ?>">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH D:\project\ribano-new-look\resources\views/themes/lightpink/sections/we-accept.blade.php ENDPATH**/ ?>