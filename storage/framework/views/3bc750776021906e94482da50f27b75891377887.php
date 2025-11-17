<!-- newsletter_area_start -->
<?php if(isset($templates['news-letter'][0]) && $newsLetter = $templates['news-letter'][0]): ?>
<section class="newsletter_area">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <h3 class="text-center text-lg-start"><i class="fa-regular fa-paper-plane"></i> <?php echo app('translator')->get(@$newsLetter->description->title); ?> </h3>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <form class="subscribe_form" action="<?php echo e(route('subscribe')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="email" name="email" class="form-control" placeholder="<?php echo app('translator')->get('Email Address'); ?>" />
                    <button><?php echo e(trans('Subscribe')); ?></button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- newsletter_area_end -->
<?php /**PATH D:\project\ribano\resources\views/themes/lightpink/sections/news-letter.blade.php ENDPATH**/ ?>