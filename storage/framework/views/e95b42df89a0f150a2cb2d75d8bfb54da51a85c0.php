<?php $__env->startSection('title',__('Register')); ?>

<?php $__env->startSection('content'); ?>
    <!-- login_signup_area_start -->
    <section class="login_signup_area">
        <div class="container">
            <div class="row align-items-center">

                
                <div class="col-lg-8 mx-auto col-md-8">
                    <div class="login_signup_form p-4">
                        <div class="section_header text-center">
                            <h4 class="pt-30 pb-30"><?php echo app('translator')->get('Create New Account'); ?></h4>
                        </div>
                        <form action="<?php echo e(route('register')); ?>" method="post">
                            <?php echo csrf_field(); ?>

                            <?php if(session()->get('sponsor') != null): ?>
                                <div class="col-md-12">
                                    <div class="form-group mb-30">
                                        <label><?php echo app('translator')->get('Sponsor Name'); ?></label>
                                        <input type="text" name="sponsor" class="form-control" id="sponsor"
                                               placeholder="<?php echo e(trans('Sponsor By')); ?>"
                                               value="<?php echo e(session()->get('sponsor')); ?>" readonly>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="register-intro">
                                <p><?php echo e(trans("It's easy to create a pitch using our online form. Your pitch can be in front of our investors before you know it.")); ?></p>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" value="investor" name="role" type="radio" id="investor">
                                        <label class="form-check-label" for="investor">
                                            <?php echo e(trans("I'm an Investor")); ?>

                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" value="capital-agents" name="role" type="radio" id="capital-agents">
                                        <label class="form-check-label" for="capital-agents">
                                            <?php echo e(trans("I'm an Capital Agents ")); ?>

                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" value="founder" type="radio" name="role" id="enerpreuner" checked>
                                        <label class="form-check-label" for="founder">
                                            <?php echo e(trans("I'm an Entrepreneur")); ?>

                                        </label>
                                    </div>
                                </div>

                            </div>



                            <p><?php echo app('translator')->get('First Name'); ?></p>
                            <div class="input-group mb-3">
                                <input type="text" name="firstname" class="form-control" value="<?php echo e(old('firstname')); ?>" placeholder="<?php echo app('translator')->get('First Name'); ?>">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-pen-to-square"></i></span>
                            </div>
                            <?php $__errorArgs = ['firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <p><?php echo app('translator')->get('Last Name'); ?></p>
                            <div class="input-group mb-3">
                                <input type="text" name="lastname" class="form-control" value="<?php echo e(old('lastname')); ?>" placeholder="<?php echo app('translator')->get('Last Name'); ?>">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-pen-to-square"></i></span>
                            </div>
                            <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <p><?php echo app('translator')->get('Username'); ?></p>
                            <div class="input-group mb-3">
                                <input type="text" name="username" class="form-control" value="<?php echo e(old('username')); ?>" placeholder="<?php echo app('translator')->get('User Name'); ?>">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-pen-to-square"></i></span>
                            </div>
                            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <p><?php echo app('translator')->get('Email Address'); ?></p>
                            <div class="input-group mb-3">
                                <input type="text" name="email" class="form-control" value="<?php echo e(old('email')); ?>" placeholder="<?php echo app('translator')->get('Email Address'); ?>">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-envelope"></i></span>
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                            <div class="input-group mb-3">
                                <?php
                                    $country_code = (string) @getIpInfo()['code'] ?: null;
                                    $myCollection = collect(config('country'))->map(function($row) {
                                        return collect($row);
                                    });
                                    $countries = $myCollection->sortBy('code');
                                ?>

                                <select name="phone_code" class="form-control country_code dialCode-change register_phone_select">
                                    <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value['phone_code']); ?>"
                                                data-name="<?php echo e($value['name']); ?>"
                                                data-code="<?php echo e($value['code']); ?>"
                                            <?php echo e($country_code == $value['code'] ? 'selected' : ''); ?>

                                        > <?php echo e($value['name']); ?> (<?php echo e($value['phone_code']); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-globe-americas"></i></span>

                                <input type="text" name="phone" class="form-control dialcode-set" value="<?php echo e(old('phone')); ?>" placeholder="<?php echo app('translator')->get('Phone Number'); ?>">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone"></i></span>

                            </div>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <input type="hidden" name="country_code" value="<?php echo e(old('country_code')); ?>" class="text-dark">

                            <p><?php echo app('translator')->get('Password'); ?></p>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control" placeholder="<?php echo app('translator')->get('Password'); ?>">
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

                            <p><?php echo app('translator')->get('Confirm password'); ?></p>
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="<?php echo app('translator')->get('Confirm Password'); ?>">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                            </div>
                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <?php if(basicControl()->reCaptcha_status_registration): ?>
                                <div class="col-md-6 box mb-4 form-group">
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


                            
                            <div id="section-investor" class="role-section  mb-4">
                                <h5><?php echo app('translator')->get('Partner / Investor Details'); ?></h5>
                                <p class="text-muted"><?php echo app('translator')->get('Invest in diversified opportunities and participate in profit-share across curated portfolios.'); ?></p>

                                <div class="accordion" id="investorAccordion">

                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingProfile">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfile" aria-expanded="true" style="color:#6777ef">
                                                <?php echo app('translator')->get('A.1 Profile'); ?>
                                            </button>
                                        </h2>
                                        <div id="collapseProfile" class="accordion-collapse collapse show" aria-labelledby="headingProfile" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">
                                                <div>
                                                    <p><?php echo app('translator')->get('Full Name'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="investor_fullname" class="form-control mb-2" placeholder="<?php echo app('translator')->get('Full Name'); ?>" value="<?php echo e(old('investor_fullname')); ?>" required>
                                                        <span class="input-group-text" id="basic-addon3"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_fullname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>


                                                <div>
                                                    <p><?php echo app('translator')->get('Date of Birth'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <input type="date" name="investor_dob" class="form-control mb-2" value="<?php echo e(old('investor_dob')); ?>" required>
                                                        <span class="input-group-text" id="basic-addon4"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>


                                                <div>
                                                    <p><?php echo app('translator')->get('Nationality'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_nationality" class="form-control mb-2" required>
                                                            <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($value['code']); ?>" <?php echo e(old('investor_nationality') == $value['code'] ? 'selected' : ''); ?>>
                                                                    <?php echo e($value['name']); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon5"><i class="fa fa-globe-americas"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_nationality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div>
                                                    <p><?php echo app('translator')->get('Residential Address'); ?></p>

                                                    <div class="input-group mb-3">
                                                        <textarea name="investor_address" class="form-control mb-2" required><?php echo e(old('investor_address')); ?></textarea>

                                                        <span class="input-group-text" id="basic-addon6"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div>
                                                    <p><?php echo app('translator')->get('Tax Residency'); ?></p>

                                                    <div class="input-group mb-3">
                                                        <select name="investor_tax_residency" class="form-control mb-2" required>
                                                            <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($value['code']); ?>" <?php echo e(old('investor_tax_residency') == $value['code'] ? 'selected' : ''); ?>>
                                                                    <?php echo e($value['name']); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon7"><i class="fa fa-globe-americas"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_tax_residency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>


                                                <div>
                                                    <p><?php echo app('translator')->get('ID Type & Number'); ?></p>

                                                    <div class="d-flex gap-2 mb-2">
                                                        <div class="w-50">
                                                            <div class="input-group mb-3">
                                                                <select name="investor_id_type" class="form-control" required>
                                                                    <option value="passport" <?php echo e(old('investor_id_type') == 'passport' ? 'selected' : ''); ?>><?php echo app('translator')->get('Passport'); ?></option>
                                                                    <option value="national_id" <?php echo e(old('investor_id_type') == 'national_id' ? 'selected' : ''); ?>><?php echo app('translator')->get('National ID'); ?></option>
                                                                    <option value="driver_license" <?php echo e(old('investor_id_type') == 'driver_license' ? 'selected' : ''); ?>><?php echo app('translator')->get('Driver\'s License'); ?></option>
                                                                </select>
                                                                <span class="input-group-text" id="basic-addon8"><i class="fa fa-globe-americas"></i></span>
                                                            </div>
                                                            <?php $__errorArgs = ['investor_id_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>

                                                        <div class="w-50">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="investor_id_number" class="form-control" placeholder="<?php echo app('translator')->get('ID Number'); ?>" value="<?php echo e(old('investor_id_number')); ?>" required>
                                                                <span class="input-group-text" id="basic-addon9"><i class="fa-regular fa-pen-to-square"></i></span>

                                                            </div>
                                                            <?php $__errorArgs = ['investor_id_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div>
                                                    <p><?php echo app('translator')->get('ID Document Upload'); ?></p>

                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_id_document" accept=".jpg,.jpeg,.png,.pdf" class="form-control mb-2" required>

                                                        <span class="input-group-text" id="basic-addon10"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_id_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div>
                                                    <p><?php echo app('translator')->get('Selfie / Liveness Check'); ?></p>

                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_selfie" accept=".jpg,.jpeg,.png" class="form-control mb-2" required>

                                                        <span class="input-group-text" id="basic-addon11"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_selfie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>


                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn  btn-primary btn-next" data-next="#collapseCategory" style="background-color: #ff5400;border:1px solid #ff5400"><?php echo app('translator')->get('Next'); ?></button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingCategory">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false" style="color:#6777ef">
                                                <?php echo app('translator')->get('A.2 Investor Category'); ?>
                                            </button>
                                        </h2>
                                        <div id="collapseCategory" class="accordion-collapse collapse" aria-labelledby="headingCategory" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">

                                                 <div>
                                                    <p><?php echo app('translator')->get('Type of User'); ?></p>
                                                    <div class="input-group mb-3">
                                                       <select name="investor_type" class="form-control mb-2" required>
                                                            <option value="individual"><?php echo app('translator')->get('Individual'); ?></option>
                                                            <option value="investment_firm"><?php echo app('translator')->get('Investment Firm'); ?></option>
                                                            <option value="family_office"><?php echo app('translator')->get('Family Office'); ?></option>
                                                            <option value="institutional"><?php echo app('translator')->get('Institutional Fund Manager'); ?></option>
                                                            <option value="charity"><?php echo app('translator')->get('Charitable Organization'); ?></option>
                                                            <option value="endowment"><?php echo app('translator')->get('Endowment'); ?></option>
                                                            <option value="digital_agency"><?php echo app('translator')->get('Digital Marketing Agency'); ?></option>
                                                            <option value="service_provider"><?php echo app('translator')->get('Service Provider'); ?></option>
                                                            <option value="pension_fund"><?php echo app('translator')->get('Pension Fund'); ?></option>
                                                            <option value="insurance_fund"><?php echo app('translator')->get('Insurance Fund'); ?></option>
                                                            <option value="sovereign_wealth"><?php echo app('translator')->get('Sovereign Wealth Fund (SWF)'); ?></option>
                                                            <option value="investment_authority"><?php echo app('translator')->get('Investment Authority'); ?></option>
                                                            <option value="foundation"><?php echo app('translator')->get('Foundation/Charitable'); ?></option>
                                                            <option value="non_profit"><?php echo app('translator')->get('Non-Profit'); ?></option>
                                                            <option value="private_equity"><?php echo app('translator')->get('Private Equity Fund'); ?></option>
                                                            <option value="venture_capital"><?php echo app('translator')->get('Venture Capital'); ?></option>
                                                            <option value="hedge_fund"><?php echo app('translator')->get('Hedge Fund'); ?></option>
                                                            <option value="real_estate"><?php echo app('translator')->get('Real Estate Fund'); ?></option>
                                                            <option value="reit"><?php echo app('translator')->get('REIT'); ?></option>
                                                            <option value="infrastructure"><?php echo app('translator')->get('Infrastructure Fund'); ?></option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon13"><i class="fa fa-globe-americas"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div class="mb-2">
                                                    <p><?php echo app('translator')->get('Accredited / Qualified Investor Status'); ?></p>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="investor_accredited" id="investor_yes" value="yes" <?php echo e(old('investor_accredited') == 'yes' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="investor_yes"><?php echo app('translator')->get('Yes'); ?></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="investor_accredited" id="investor_no" value="no" <?php echo e(old('investor_accredited') == 'no' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="investor_no"><?php echo app('translator')->get('No'); ?></label>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_accredited'];
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

                                                <div>
                                                    <p><?php echo app('translator')->get('Proof of Status (if Yes)'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_proof_status" accept=".jpg,.jpeg,.png,.pdf" class="form-control mb-2">
                                                        <span class="input-group-text" id="basic-addon14"> <i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_proof_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div>
                                                    <p><?php echo app('translator')->get('Investment Horizon'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_horizon" class="form-control mb-2">
                                                            <option value=""><?php echo app('translator')->get('Select'); ?></option>
                                                            <option value="short"><?php echo app('translator')->get('Short'); ?></option>
                                                            <option value="medium"><?php echo app('translator')->get('Medium'); ?></option>
                                                            <option value="long"><?php echo app('translator')->get('Long'); ?></option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon14"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    <?php $__errorArgs = ['investor_horizon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div>
                                                    <p><?php echo app('translator')->get('Risk Appetite'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_risk" class="form-control mb-2">
                                                            <option value=""><?php echo app('translator')->get('Select'); ?></option>
                                                            <option value="low"><?php echo app('translator')->get('Low'); ?></option>
                                                            <option value="moderate"><?php echo app('translator')->get('Moderate'); ?></option>
                                                            <option value="high"><?php echo app('translator')->get('High'); ?></option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon15"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    <?php $__errorArgs = ['investor_risk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>


                                                <div>
                                                    <p><?php echo app('translator')->get('Ticket Size Preference'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_risk" class="form-control mb-2">
                                                            <option value=""><?php echo app('translator')->get('Select'); ?></option>
                                                            <option value="low"><?php echo app('translator')->get('Low'); ?></option>
                                                            <option value="moderate"><?php echo app('translator')->get('Moderate'); ?></option>
                                                            <option value="high"><?php echo app('translator')->get('High'); ?></option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon16"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    <?php $__errorArgs = ['investor_risk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div>
                                                    <p><?php echo app('translator')->get('Typical Ticket Size'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_ticket" class="form-control mb-2">
                                                            <option value=""><?php echo app('translator')->get('Select'); ?></option>
                                                            <option value="10k"><?php echo app('translator')->get('<$10k'); ?></option>
                                                            <option value="10-50k"><?php echo app('translator')->get('$10–50k'); ?></option>
                                                            <option value="50-250k"><?php echo app('translator')->get('$50–250k'); ?></option>
                                                            <option value="250k+"><?php echo app('translator')->get('$250k+'); ?></option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon17"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    <?php $__errorArgs = ['investor_ticket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>


                                                <div>
                                                    <p><?php echo app('translator')->get('Sectors of Interest'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_sectors[]" class="form-control mb-2" multiple>
                                                            <?php
                                                                $sectors = ['Real Estate', 'REITs', 'Infrastructure', 'Fintech', 'Sukuk (Mudarabah)', 'Other'];
                                                            ?>
                                                            <?php $__currentLoopData = $sectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($sector); ?>" <?php echo e(is_array(old('investor_sectors')) && in_array($sector, old('investor_sectors')) ? 'selected' : ''); ?>><?php echo e($sector); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon18"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    <?php $__errorArgs = ['investor_sectors[]'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div>
                                                   <p><?php echo app('translator')->get('Geographies of Interest'); ?></p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_geographies[]" class="form-control mb-2" multiple>
                                                            <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($value['code']); ?>" <?php echo e(is_array(old('investor_geographies')) && in_array($value['code'], old('investor_geographies')) ? 'selected' : ''); ?>>
                                                                    <?php echo e($value['name']); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon19"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    <?php $__errorArgs = ['investor_geographies[]'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger mt-1 mb-2"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>




                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary btn-prev" data-prev="#collapseProfile"  style="background-color:#008000;border:1px solid #008000 "><?php echo app('translator')->get('Previous'); ?></button>
                                                    <button type="button" class="btn btn-primary btn-next" data-next="#collapseCompliance" style="background-color:#f51414;border:1px solid #f51414 "><?php echo app('translator')->get('Next'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingCompliance">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCompliance" style="color:#6777ef">
                                                <?php echo app('translator')->get('A.3 Compliance'); ?>
                                            </button>
                                        </h2>
                                        <div id="collapseCompliance" class="accordion-collapse collapse" aria-labelledby="headingCompliance" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">

                                                <div class="mb-2">
                                                    <p><?php echo app('translator')->get('PEP Exposure'); ?></p>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="investor_pep" value="yes" class="form-check-input" <?php echo e(old('investor_pep') == 'yes' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="investor_yes"><?php echo app('translator')->get('Yes'); ?></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="investor_pep" value="no" class="form-check-input" <?php echo e(old('investor_pep') == 'no' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="investor_no"><?php echo app('translator')->get('No'); ?></label>
                                                    </div>
                                                    <?php $__errorArgs = ['investor_pep'];
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


                                                <textarea name="investor_pep_details" class="form-control mb-2" placeholder="<?php echo app('translator')->get('If Yes, explain details'); ?>"><?php echo e(old('investor_pep_details')); ?></textarea>

                                                <p><?php echo app('translator')->get('Source of Funds'); ?></p>
                                                <select name="investor_source_of_funds[]" class="form-control mb-2" multiple required>
                                                    <?php
                                                        $sources = ['Income', 'Savings', 'Asset Sale', 'Corporate Profits', 'Investment/Portfolio Management Funds', 'Other'];
                                                    ?>
                                                    <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($source); ?>" <?php echo e(is_array(old('investor_source_of_funds')) && in_array($source, old('investor_source_of_funds')) ? 'selected' : ''); ?>><?php echo e($source); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <p><?php echo app('translator')->get('Proof of Address'); ?></p>
                                                <input type="file" name="investor_proof_address" accept=".jpg,.jpeg,.png,.pdf" class="form-control mb-2" required>

                                                <p><?php echo app('translator')->get('Tax ID / TIN'); ?></p>
                                                <input type="text" name="investor_tax_id" class="form-control mb-2" value="<?php echo e(old('investor_tax_id')); ?>">

                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary btn-prev" data-prev="#collapseCategory"><?php echo app('translator')->get('Previous'); ?></button>
                                                    <button type="button" class="btn btn-primary btn-next" data-next="#collapseEntity"><?php echo app('translator')->get('Next'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="accordion-item" id="collapseEntityWrapper">
                                        <h2 class="accordion-header" id="headingEntity">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEntity" style="color:#6777ef">
                                                <?php echo app('translator')->get('A.4 Entity Add-On'); ?>
                                            </button>
                                        </h2>
                                        <div id="collapseEntity" class="accordion-collapse collapse" aria-labelledby="headingEntity" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">
                                                <p><?php echo app('translator')->get('Legal Entity Name'); ?></p>
                                                <input type="text" name="investor_entity_name" class="form-control mb-2" value="<?php echo e(old('investor_entity_name')); ?>">

                                                <p><?php echo app('translator')->get('Registration Country'); ?></p>
                                                <select name="investor_entity_country" class="form-control mb-2">
                                                    <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value['code']); ?>" <?php echo e(old('investor_entity_country') == $value['code'] ? 'selected' : ''); ?>><?php echo e($value['name']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <p><?php echo app('translator')->get('Registration Number'); ?></p>
                                                <input type="text" name="investor_entity_number" class="form-control mb-2" value="<?php echo e(old('investor_entity_number')); ?>">

                                                <p><?php echo app('translator')->get('Incorporation Certificate'); ?></p>
                                                <input type="file" name="investor_entity_cert" class="form-control mb-2">

                                                <p><?php echo app('translator')->get('Directors / UBOs'); ?></p>
                                                <div id="investor_ubos" class="mb-2">
                                                    <input type="text" name="investor_ubo_name[]" placeholder="<?php echo app('translator')->get('Full Name'); ?>" class="form-control mb-1">
                                                    <input type="date" name="investor_ubo_dob[]" class="form-control mb-1">
                                                    <input type="text" name="investor_ubo_nationality[]" placeholder="<?php echo app('translator')->get('Nationality'); ?>" class="form-control mb-1">
                                                    <input type="number" name="investor_ubo_ownership[]" placeholder="<?php echo app('translator')->get('Ownership %'); ?>" class="form-control mb-1">
                                                    <input type="file" name="investor_ubo_id[]" class="form-control mb-1">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mb-2" id="add-investor-ubo"><?php echo app('translator')->get('Add Another UBO'); ?></button>

                                                <p><?php echo app('translator')->get('Authorised Signatory Letter'); ?></p>
                                                <input type="file" name="investor_signatory_letter" class="form-control mb-2">

                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary btn-prev" data-prev="#collapseCompliance"><?php echo app('translator')->get('Previous'); ?></button>
                                                    <button type="button" class="btn btn-primary btn-next" data-next="#collapsePreferences"><?php echo app('translator')->get('Next'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingPreferences">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePreferences" style="color:#6777ef">
                                                <?php echo app('translator')->get('A.5 Preferences'); ?>
                                            </button>
                                        </h2>
                                        <div id="collapsePreferences" class="accordion-collapse collapse" aria-labelledby="headingPreferences" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">
                                                <p><?php echo app('translator')->get('Communication Channels'); ?></p>
                                                <div class="form-check">
                                                    <input type="checkbox" name="investor_comm_email" class="form-check-input"> <?php echo app('translator')->get('Email'); ?>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="investor_comm_sms" class="form-check-input"> <?php echo app('translator')->get('SMS'); ?>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="investor_comm_whatsapp" class="form-check-input"> <?php echo app('translator')->get('WhatsApp'); ?>
                                                </div>

                                                <p><?php echo app('translator')->get('Notification Frequency'); ?></p>
                                                <select name="investor_notification_freq" class="form-control mb-2">
                                                    <option value=""><?php echo app('translator')->get('Select'); ?></option>
                                                    <option value="daily"><?php echo app('translator')->get('Daily'); ?></option>
                                                    <option value="weekly"><?php echo app('translator')->get('Weekly'); ?></option>
                                                    <option value="monthly"><?php echo app('translator')->get('Monthly'); ?></option>
                                                </select>

                                                <div class="form-check mb-2">
                                                    <input type="checkbox" name="investor_accept_electronic_sign" class="form-check-input" required> <?php echo app('translator')->get('Accept Electronic Signatures'); ?>
                                                </div>

                                                <div class="d-flex justify-content-start">
                                                    <button type="button" class="btn btn-secondary btn-prev" data-prev="#collapseEntity"><?php echo app('translator')->get('Previous'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="mb-3 form-check d-flex justify-content-between">
                                <div class="check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1"><?php echo app('translator')->get('I agree to the terms and
                                    conditions.'); ?></label>
                                </div>
                            </div>

                            <button type="submit" class="btn custom_btn mt-30 w-100"><?php echo app('translator')->get('Register'); ?></button>
                            
                            <?php echo $__env->first([$theme.'partials.social'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="pt-5 d-flex">
                                <?php echo app('translator')->get('Already have an account?'); ?>
                                <br>
                                <h6 class="ms-2 mt-1"><a href="<?php echo e(route('login')); ?>"><?php echo app('translator')->get('Login'); ?></a></h6>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login_signup_area_end -->
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                setDialCode();
            });
            function setDialCode() {
                let currency = $('.dialCode-change').val();
                $('.dialcode-set').val(currency);
            }
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\ribano\resources\views/themes/lightpink/auth/register.blade.php ENDPATH**/ ?>