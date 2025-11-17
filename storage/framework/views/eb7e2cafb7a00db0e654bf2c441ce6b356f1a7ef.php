<?php $__env->startSection('title',__('Login')); ?>

<?php $__env->startSection('content'); ?>

    <!-- login_signup_area_start -->
    <section class="login_signup_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-5">
                    <div class="login_signup_banner">
                        <div class="image_area animation1">
                            <img src="<?php echo e(asset('/assets/images/login-bg.jpg')); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-7">
                    <div class="login_signup_form p-4">
                        <div class="section_header text-center">

                            <h4 class="pt-30 pb-30"><?php echo app('translator')->get('login your account'); ?></h4>
                        </div>
                        <form action="<?php echo e(route('login')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <p><?php echo app('translator')->get('Email Address'); ?></p>
                            <div class="input-group mb-3">
                                <input type="text"
                                       name="username"
                                       class="form-control"
                                       id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="<?php echo app('translator')->get('Username or Email'); ?>">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-envelope"></i></span>
                            </div>
                            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger float-left"><?php echo app('translator')->get($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger float-left"><?php echo app('translator')->get($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <p><?php echo app('translator')->get('Password'); ?></p>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                       placeholder="<?php echo app('translator')->get('Password'); ?>">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <?php if(basicControl()->reCaptcha_status_login): ?>
                                <div class="box mb-4 form-group">
                                    <?php echo NoCaptcha::renderJs(session()->get('trans')); ?>

                                    <?php echo NoCaptcha::display($basic->theme == 'deepblack' ? ['data-theme' => 'dark'] : []); ?>

                                    <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3 form-check d-flex justify-content-between">
                                <div class="check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="exampleCheck1"><?php echo app('translator')->get('Remember me'); ?></label>
                                </div>
                                <div class="forgot">
                                    <a href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->get('Forgot password?'); ?></a>
                                </div>
                            </div>
                            <button type="submit" class="btn custom_btn mt-30 w-100"><?php echo app('translator')->get('Log In'); ?></button>

                            
                            <?php echo $__env->first([$theme.'partials.social'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="pt-5 d-flex">
                                <?php echo app('translator')->get("Don't have an account?"); ?>
                                <br>
                                <h6 class="ms-2 mt-1"><a href="<?php echo e(route('register')); ?>"><?php echo app('translator')->get('Register'); ?></a></h6>
                            </div>
                            <input type="hidden" name="redirect_uri" value="<?php echo e(request()->query('redirect_uri')); ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login_signup_area_end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\ribano\resources\views/themes/lightpink/auth/login.blade.php ENDPATH**/ ?>