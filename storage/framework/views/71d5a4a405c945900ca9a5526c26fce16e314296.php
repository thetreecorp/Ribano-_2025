<div data-swiper-parallax="400" class="slide-text">
    <?php if(isset($desc) && $desc): ?>
        <div><?php echo @$data->description->description; ?></div>
        <?php else: ?>
            <p><?php echo e(@translate("Partnership with investors is not just about securing funding, it's about building trust, aligning
            goals, and working together to achieve success. The right investors can bring valuable expertise, networks, and
            resources to the table, and can help take your business to new heights", null, false)); ?>.</p>
        
    <?php endif; ?>
    

    <div class="d-flex justify-content-center mt-4">


        <div class="p-2 bd-highlight text-center">

            <div style="font-weight: bolder; font-size: 28px; color: white"><?php echo e(translate("I'm looking to", null, false)); ?>...</div>

        </div>


        <div class="p-2 bd-highlight text-center select-slider">

            <select class="form-select form-select-lg">
                <option selected="" value=""><?php echo e(translate("Fundraise")); ?></option>
                <option value=""><?php echo e(translate("Invest")); ?></option>
            </select>

        </div>

    </div>
    <?php if(Auth::guest()): ?>
        <a href="<?php echo e(url('/register')); ?>" class="btn btn-success mt-4 text-white-hover"><?php echo e(translate("Get Started")); ?></a>
    <?php else: ?>
        <a class="btn btn-success mt-4 text-white-hover" href="<?php echo e(route('user.home')); ?>"><?php echo e(translate("Get Started")); ?></a>
    <?php endif; ?>
    
</div><?php /**PATH D:\project\ribano-new-look\resources\views/themes/lightpink/partials/slider-box-text.blade.php ENDPATH**/ ?>