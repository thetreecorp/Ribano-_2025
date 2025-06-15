<?php $common = app('App\Http\Controllers\ProjectController'); ?>
<?php
    $currency_code = Session::get('currency_code');
    $currencies = $common->getCurrencies();
    $lang_code = $lang = Session::get('trans');
    
    
    
    $get_currency = (Session::get('currency')) ? (Session::get('currency')) : 'USD';
   
    $languageArray = json_decode($languages, true) ? json_decode($languages, true) : array();
    if(array_key_exists( $lang, $languageArray))
    $lang = $languageArray[$lang];
    

?>
<!-- Header_area_start -->
<div class="header_area fixed-to" id="header_top">
    <!-- Header_top_area_start -->
    <div class="header_top_area">
        <div class="container">
            
            <div class="custom-top-head">
                <div class="col-md-12">
                    <div class="header_top_right d-flex justify-content-md-end justify-content-center align-items-center">
                        
                        <div class="currencies-select">
                        
                        
                            <?php if($currencies): ?>
                            <select class="form-control">
                                <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($currency->code); ?>" <?php if($currency->code == $get_currency): ?> selected
                                    <?php endif; ?>
                        
                                    data-currency="<?php echo e($currency->code); ?>"><?php echo e($currency->name); ?>

                                    (<?php echo e($currency->symbol); ?>)
                        
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php endif; ?>
                        </div>
                        
                        <div class="language_select_area">
                            <div class="dropdown">
                                <button class="custom_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <?php echo $lang ? $lang : 'Eng' ?>
                                </button>
                
                                <ul class="dropdown-menu">
                                    <?php $__currentLoopData = $languageArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a class="dropdown-item" href="<?php echo e(route('language',$key)); ?>"><span
                                                class="flag-icon flag-icon-<?php echo e(strtolower($key)); ?>"></span> <?php echo e($lang); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header_top_area_end -->

    <!-- Nav_area_start -->

    <div class="nav_area">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
            <div class="container custom_nav">
                <a class="logo" href="<?php echo e(url('/')); ?>"><img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>"
                        alt="<?php echo e(config('basic.site_title')); ?>"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="bars"><i class="fa-solid fa-bars-staggered"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="menus navbar-nav ms-auto text-center align-items-center align-items-center">
                        <?php echo $__env->make($theme.'partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        
                       
                        
                        
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- Nav_area_end -->
    
    <div class="mobile">
        <div class="hamburger-menu">
            <div class="bar"></div>	
        </div>
    </div>  
    <div class="mobile-nav hide">
        <ul>
            <?php echo $__env->make($theme.'partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </ul>
      </div>
    
</div>

<!-- Header_area_end --><?php /**PATH D:\project\ribano\resources\views/themes/lightpink/partials/topbar.blade.php ENDPATH**/ ?>