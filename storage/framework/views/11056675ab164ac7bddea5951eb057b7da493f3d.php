<?php $common = app('App\Http\Controllers\ProjectController'); ?>
<section class="project_submit_area">
    <div class="container">
        <div class="row">
            <?php if(!empty($successMessage)): ?>
                <div class="alert alert-success">
                   <?php echo e($successMessage); ?>

                </div>
            <?php endif; ?>
            <?php if(!empty($errorMessage)): ?>
                <div id="errorDiv" class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errorMessage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-circle <?php echo e(($currentStep === 1) ? 'active' : (1 < $currentStep ? 'btn-primary' : 'btn-default')); ?>">1</a>
                        <p><?php echo e(translate('Company Info')); ?></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-circle <?php echo e(($currentStep === 2) ? 'active' : (2 < $currentStep ? 'btn-primary' : 'btn-default')); ?>">2</a>
                        <p><?php echo e(translate('Pitch')); ?></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" type="button" class="btn btn-circle <?php echo e(($currentStep === 3) ? 'active' : (3 < $currentStep ? 'btn-primary' : 'btn-default')); ?>">3</a>
                        <p><?php echo e(translate('Deal')); ?></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-4" type="button" class="btn btn-circle <?php echo e(($currentStep === 4) ? 'active' : (4 < $currentStep ? 'btn-primary' : 'btn-default')); ?>" disabled="disabled">4</a>
                        <p><?php echo e(translate('Team')); ?></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-5" type="button" class="btn btn-circle <?php echo e(($currentStep === 5) ? 'active' : (5 < $currentStep ? 'btn-primary' : 'btn-default')); ?>" disabled="disabled">5</a>
                        <p><?php echo e(translate('Image & Video')); ?></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-6" type="button" class="btn btn-circle <?php echo e(($currentStep === 6) ? 'active' : (6 < $currentStep ? 'btn-primary' : 'btn-default')); ?>" disabled="disabled">6</a>
                        <p><?php echo e(translate('Document')); ?></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-7" type="button" class="btn btn-circle <?php echo e(($currentStep === 7) ? 'active' : (7 < $currentStep ? 'btn-primary' : 'btn-default')); ?>" disabled="disabled">7</a>
                        <p><?php echo e(translate('Question')); ?></p>
                    </div>

                </div>
            </div>

                <div class="row setup-content <?php echo e($currentStep != 1 ? 'displayNone' : ''); ?>" id="step-1">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="title"><?php echo e(translate('Pitch Title')); ?>:</label>
                                    <input type="text" wire:model="title" class="form-control">
                                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-sm-6">
                                    <label for="webiste"><?php echo e(translate('Website (Optional)')); ?>:</label>
                                    <input type="text" wire:model="website" class="form-control" value="https://" />

                                </div>

                            </div>


                            <?php
                                $country_code = (string) @getIpInfo()['code'] ?: null;
                                $myCollection = collect(config('country'))->map(function($row) {
                                    return collect($row);
                                });
                                $countries = $myCollection->sortBy('code');
                            ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for=""><?php echo e(translate('Management located')); ?>:</label>
                                    <select class="form-control" wire:model="located" id="form_management_locations">
                                        <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value['name']); ?>"
                                                    data-name="<?php echo e($value['name']); ?>"
                                                    data-code="<?php echo e($value['code']); ?>"
                                                <?php echo e($country_code == $value['code'] ? 'selected' : ''); ?>

                                            > <?php echo e($value['name']); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for=""><?php echo e(translate('Project operation in')); ?>:</label>
                                    <select wire:model="country" name="country" class="form-control">
                                        <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value['name']); ?>"
                                                    data-name="<?php echo e($value['name']); ?>"
                                                    data-code="<?php echo e($value['code']); ?>"
                                                <?php echo e($country_code == $value['code'] ? 'selected' : ''); ?>

                                            > <?php echo e($value['name']); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for=""><?php echo e(translate('Mobile Number')); ?>:</label>
                                <div class="input-group mb-3">

                                    <select wire:model="phone_code" name="phone_code" class="form-control country_code dialCode-change register_phone_select">
                                        <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value['phone_code']); ?>"
                                                    data-name="<?php echo e($value['name']); ?>"
                                                    data-code="<?php echo e($value['code']); ?>"
                                                <?php echo e($country_code == $value['code'] ? 'selected' : ''); ?>

                                            > <?php echo e($value['name']); ?> <?php echo e($value['phone_code'] ? '(' . $value['phone_code'] .')' : ''); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-globe-americas"></i></span>

                                    <input wire:model="mobile_number" type="text" name="mobile_number" class="form-control dialcode-set" value="" placeholder="<?php echo app('translator')->get('Phone Number'); ?>">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone"></i></span>
                                    <?php $__errorArgs = ['mobile_number'];
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
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="webiste"><?php echo e(translate('Industry 1')); ?>:</label>
                                    <select class="select form-control" wire:model="industry_1" name="industry_1">
                                        <option value="">Please Select</option>
                                        <?php $__currentLoopData = $common->getIndustries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>


                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>
                                <div class="col-sm-6">
                                    <label for="webiste"><?php echo e(translate('Industry 2')); ?>:</label>
                                    <select class="select form-control" wire:model="industry_2" name="industry_2">
                                        <option value="">Please Select</option>
                                        <?php $__currentLoopData = $common->getIndustries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>


                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="webiste"><?php echo e(translate('Stage')); ?>:</label>
                                    <select class="select form-control"  wire:model="stage" name="stage">
                                        <?php $__currentLoopData = $common->getStages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value->id); ?>"><?php echo e(htmlspecialchars_decode($value->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </select>

                                </div>
                                <div class="col-sm-6">
                                    <label for="webiste"><?php echo e(translate('Ideal Investor Role')); ?>:</label>
                                    <select class="select form-control"  wire:model="ideal_investor_role" name="ideal_investor_role">
                                        
                                        <?php $__currentLoopData = $common->getInvestorRole(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>

                                </div>

                            </div>



                            <button class="btn btn-primary nextBtn btn-lg pull-right mrt-10" wire:click="companySubmit" type="button" >Next</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content <?php echo e($currentStep != 2 ? 'displayNone' : ''); ?>" id="step-2">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3><?php echo e(translate('Pitch')); ?></h3>

                            <div class="row">
                                <div class="col-sm-6" wire:ignore>
                                    

                                    <div class="input-group mb-3">
                                        <input type="text" wire:model="summary_title"  class="form-control" value="" placeholder="Short Summary">
                                    </div>


                                    <textarea type="text" wire:model="short_summary" class="form-control" id="short_summary"></textarea>
                                    <?php $__errorArgs = ['short_summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-sm-6" wire:ignore>
                                    
                                    <div class="input-group mb-3">
                                        <input type="text" wire:model="business_title"  class="form-control" value="" placeholder="The Business">
                                    </div>
                                    <textarea type="text" wire:model="the_business" class="form-control" id="the_business"></textarea>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6" wire:ignore>
                                    

                                    <div class="input-group mb-3">
                                        <input type="text" wire:model="the_market_title"  class="form-control" value="" placeholder="The Market">
                                    </div>

                                    <textarea type="text" wire:model="the_market" class="form-control" id="the_market"></textarea>

                                </div>
                                <div class="col-sm-6" wire:ignore>
                                    

                                    <div class="input-group mb-3">
                                        <input type="text" wire:model="progress_proof_title"  class="form-control" value="" placeholder="Progress/Proof">
                                    </div>

                                    <textarea type="text" wire:model="progress_proof" class="form-control" id="progress_proof"></textarea>

                                </div>
                            </div>


                            <div class="form-group" wire:ignore>
                                

                                <div class="input-group mb-3">
                                    <input type="text" wire:model="objectives_future_title"  class="form-control" value="" placeholder="Objectives/Future">
                                </div>

                                <textarea type="text" wire:model="objectives_future" class="form-control" id="objectives_future"></textarea>

                            </div>
                            <div class="form-group">
                                <div class="ico-alert">
                                <span class="editableLabel">
                                    <?php echo e(translate('Got more to say? That is great! Our investors love detail. You can add one more section if there is something else you really want investors to know')); ?>.
                                </span>
                                </div>
                            </div>
                            <div class="new-section">

                                <?php $__currentLoopData = $new_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="add-input">
                                        <div class="form-group">
                                            <input type="text" wire:model="name_section.<?php echo e($value); ?>" class="form-control mr-bt10" value="" placeholder="<?php echo app('translator')->get('section title'); ?>">
                                            <textarea id="content_section<?php echo e($value); ?>" placeholder="<?php echo app('translator')->get('section description'); ?>" type="text" wire:model="content_section.<?php echo e($value); ?>"  class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-danger btn-sm" wire:click.prevent="removeSection(<?php echo e($key); ?>)">Remove</button>
                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-group">
                                <div class="ico-buton">
                                    <span wire:click.prevent="addSection(<?php echo e($section); ?>)" id="add-new-section" class="btn btn-primary">
                                        <?php echo e(translate('Add New Section')); ?>

                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label for=""><?php echo e(translate('Highlights')); ?></label>
                                </div>
                                <?php for($count = 1; $count <= 5; $count++): ?>
                                    <div class="form-group input-group">
                                        <span class="span-border"><?php echo e($count); ?></span>
                                        <input type="text" wire:model="highlights.<?php echo e($count); ?>"  class="form-control" value="" placeholder="">
                                    </div>
                                <?php endfor; ?>
                            </div>



                            <div class="form-group">
                                <label for=""><?php echo e(translate('Tags')); ?></label>
                                <div class="ico-alert mr-bt10">
                                    <span class="editableLabel ">
                                        <?php echo e(translate('Enter 5 to 10 relevant keywords. These are really important to help investors find your pitch in our search engine. We always suggest using short and obvious tags that you think investors would actually search for. - (Press the Return key after each keyword to enter it)')); ?>.
                                    </span>
                                </div>


                                <div>
                                    <input type="text" class="form-control" wire:model="tagInput" wire:keydown.enter="addTag" placeholder="Input tag and press enter">
                                </div>

                                <div class="tags-input-wrapper">
                                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <span class="tag">
                                                <?php echo e($tag); ?>

                                                <a wire:click="removeTag('<?php echo e($tag); ?>')" class="remove-tag">&times;</a>
                                            </span>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                            </div>



                            <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(1)">Back</button>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="pitchSubmit">Next</button>

                        </div>
                    </div>
                </div>

                <div class="row setup-content <?php echo e($currentStep != 3 ? 'displayNone' : ''); ?>" id="step-3">
                    <div class="form-row">
                        <label for=""><?php echo e(translate('The Deal')); ?>:</label>


                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <label>
                                        <span class="adding-bg checked">
                                            <input wire:click="$toggle('show_equity')" wire:model="equity_checked" type="checkbox" value="1" <?php echo e($equity_checked == '1' ? "checked" : ""); ?>>
                                        </span>Equity
                                    </label>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p>
                                    <label>
                                        <span class="adding-bg checked">
                                        <input  wire:click="$toggle('show_convertible')" wire:model="convertible_notes_checked" type="checkbox" value="1" <?php echo e($convertible_notes_checked == '1' ? "checked" : ""); ?>>
                                        </span>SAFE convertible notes
                                    </label>
                                    <i class="fa fa-question-circle show-help" aria-hidden="true"></i>
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if($show_equity): ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""><?php echo e(translate('How much are you raising in total in this round')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="raising"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('How much equity do you give for this amount of investment')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">%</span>
                                                <input type="text" wire:model="amount_of_investment"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('What will you do with that amount of investment')); ?>?</label>
                                            <select class="select form-control" wire:model="investment_type">
                                                <option value="" selected="selected"><?php echo e(translate("Select")); ?></option>
                                                <?php $__currentLoopData = $common->getAddInvestment(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Amount spent in this selector')); ?></label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="as_investments"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">

                                        <div class="form-group">
                                            <div class="ico-buton mt-4">
                                                <span wire:click.prevent="addInvestment(<?php echo e($c_investment); ?>)" id="add-new-investment" class="btn btn-primary">
                                                    <?php echo e(translate('Add New')); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>



                                </div>


                                <div class="new-section-investment">

                                    <?php $__currentLoopData = $add_investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="add-input">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group ">
                                                        <label for=""><?php echo e(translate('What will you do with that amount of investment')); ?>?</label>
                                                        <select class="select form-control" wire:model="add_investments_title.<?php echo e($key); ?>">
                                                            <option value="" selected="selected"><?php echo e(translate("Select")); ?></option>
                                                            <?php $__currentLoopData = $common->getAddInvestment(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group ">
                                                        <label for=""><?php echo e(translate('Amount spent in this selector')); ?></label>
                                                        <div class="input-group mb-3 ">

                                                            <input type="text" wire:model="add_investments_value.<?php echo e($key); ?>" class="form-control" value=""
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end btn-sm-cs">
                                            <button class="btn btn-danger btn-sm" wire:click.prevent="removeInvestment(<?php echo e($key); ?>)">Remove</button>
                                        </div>


                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>



                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Total shares of the company')); ?></label>
                                            <div class="input-group mb-3">

                                                <input type="text" wire:model="total_share"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Price of share')); ?></label>
                                            <div class="input-group mb-3">

                                                <input type="text" wire:model="price_of_share"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Shares granted for this investment')); ?></label>
                                            <div class="input-group mb-3">

                                                <input type="text" wire:model="shares_granted"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p style="color:red"><?php echo e(translate('Total of investment needed Sum of all:')); ?> <?php echo e($total_investment); ?></p>




                                <div class="form-group accept-wrap">
                                    <label for=""><?php echo e(translate('I can accept')); ?>:</label>
                                    <label>
                                        <span class="adding-bg checked">
                                            <input class="form-check-input" wire:model="accept_goods" type="checkbox" value="Goods" <?php echo e($accept_goods == 'Goods' ? "checked" : ""); ?>>
                                        </span>Goods
                                    </label>
                                    <label>
                                        <span class="adding-bg checked">
                                        <input class="form-check-input" wire:model="fixed_assets" type="checkbox" value="Fixed assets" <?php echo e($fixed_assets == 'Fixed assets' ? "checked" : ""); ?>>
                                        </span>Fixed assets
                                    </label>
                                    <label>
                                        <span class="adding-bg checked">
                                        <input class="form-check-input" wire:model="accept_hires" type="checkbox" value="Hires" <?php echo e($accept_hires == '1' ? "checked" : ""); ?>>
                                        </span>Hires
                                    </label>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""><?php echo e(translate('Previous rounds raise the amount')); ?></label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="investment_equity_previous_rounds"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""><?php echo e(translate('Investment already granted')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="investment_equity_grand"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Investor numbers')); ?>?</label>
                                            <div class="input-group mb-3">

                                                <input type="text" wire:model="investor_equity_numbers"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('What is the minimum investment per investor')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="minimum_equity_investment"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('What is the maximum investment per investor')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="maximum_equity_investment"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>

                                </div>



                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6">
                            <?php if($show_convertible): ?>
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""><?php echo e(translate('Target')); ?></label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="safe_target" class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Purchase price')); ?></label>
                                            <input type="text" wire:model="purchase_price"  class="form-control" value="" placeholder="">
                                        </div>


                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Date of issuance')); ?></label>
                                            <input
                                                wire:model="date_of_issuance"
                                                type="text" class="form-control datepicker" placeholder="Due Date"
                                                autocomplete="off"
                                                data-provide="datepicker" data-date-autoclose="true"
                                                data-date-format="mm/dd/yyyy" data-date-today-highlight="true"
                                                onchange="this.dispatchEvent(new InputEvent('input'))"
                                            >
                                            
                                        </div>

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Exercise price')); ?></label>
                                            <input type="text" wire:model="exercise_price"  class="form-control" value="" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Exercise date')); ?></label>
                                            <input
                                                wire:model="exercise_date"
                                                type="text" class="form-control datepicker" placeholder="Due Date"
                                                autocomplete="off"
                                                data-provide="datepicker" data-date-autoclose="true"
                                                data-date-format="mm/dd/yyyy" data-date-today-highlight="true"
                                                onchange="this.dispatchEvent(new InputEvent('input'))"
                                            >
                                            
                                        </div>

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Discount')); ?></label>
                                            <input type="text" wire:model="discount"  class="form-control" value="" placeholder="">
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Maturity Date')); ?></label>
                                            <input
                                                wire:model="maturity_date"
                                                type="text" class="form-control datepicker" placeholder="Due Date"
                                                autocomplete="off"
                                                data-provide="datepicker" data-date-autoclose="true"
                                                data-date-format="mm/dd/yyyy" data-date-today-highlight="true"
                                                onchange="this.dispatchEvent(new InputEvent('input'))"
                                            >
                                            
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Valuation cap')); ?></label>
                                            <input type="text" wire:model="valuation_cap"  class="form-control" value="" placeholder="">
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('If you did a previous round, how much did you raise')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="previous_round_raise"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('How much of this total have you raised')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="have_you_raised"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""><?php echo e(translate('Investment already granted')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="investment_grand"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('Investor numbers')); ?>?</label>
                                            <div class="input-group mb-3">

                                                <input type="text" wire:model="investor_numbers"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('What is the minimum investment per investor')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="minimum_investment"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label for=""><?php echo e(translate('What is the maximum investment per investor')); ?>?</label>
                                            <div class="input-group mb-3">
                                                <span class="span-border">US$</span>
                                                <input type="text" wire:model="maximum_investment"  class="form-control" value="" placeholder="">
                                            </div>
                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="ico-alert">
                                    <span class="editableLabel">
                                        <?php echo e(translate('You can add financials if you wish but this is not required')); ?>.
                                    </span>
                                    </div>
                                </div>
                                <div class="financial-section">
                                    <?php $__currentLoopData = $financial_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="add-input">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" wire:model="finance_year.<?php echo e($value); ?>" class="form-control mr-bt10" value="" placeholder="<?php echo app('translator')->get('Year'); ?>">


                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group mb-3">
                                                        <span class="span-border">US$</span>
                                                        <input type="text" wire:model="finance_turnove.<?php echo e($value); ?>" class="form-control" value="" placeholder="<?php echo app('translator')->get('Turnove'); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group mb-3">
                                                        <span class="span-border">US$</span>
                                                        <input type="text" wire:model="finance_profit.<?php echo e($value); ?>" class="form-control" value="" placeholder="<?php echo app('translator')->get('Profit'); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <button class="btn btn-danger btn-sm" wire:click.prevent="removeFinancial(<?php echo e($key); ?>)">Remove</button>
                                            </div>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <div class="form-group">
                                    <div class="ico-button">
                                    <span wire:click.prevent="addFinancial(<?php echo e($i); ?>)" class="btn btn-primary">
                                        <?php echo e(translate('Add New Financial')); ?>

                                    </span>
                                    </div>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>







                    <div class="button-wrap">
                        <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(2)">Back</button>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="dealSubmit">Next</button>
                    </div>


                </div>

                <div class="row setup-content <?php echo e($currentStep != 4 ? 'displayNone' : ''); ?>" id="step-4">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3><?php echo e(translate('Team')); ?></h3>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label for=""><?php echo e(translate('Team Overview')); ?></label>
                                </div>
                                <textarea type="text" wire:model="team_overview" class="form-control" id="team_overview"></textarea>

                            </div>
                            <div class="team-wrap">
                                <label for=""><?php echo e(translate('Team Members')); ?></label>
                                <?php $__currentLoopData = $team_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="add-input">
                                        <div class="form-group">
                                            <input type="file" wire:model="avatar.<?php echo e($value); ?>" class="form-control mr-bt10" value="">
                                            <?php if(is_array($avatar) && array_key_exists($value, $avatar)): ?>
                                                <?php if(!is_string($avatar[$value]) && $avatar[$value] != NULL): ?>
                                                    <img class="team_image" src="<?php echo e($avatar[$value]->temporaryUrl()); ?>" alt="team image" />
                                                <?php else: ?>

                                                    <?php if($common->checkImageType($avatar[$value])): ?>
                                                        <img class="team_image" src="<?php echo e($common->getLinkIdrive($avatar[$value])); ?>" alt="team image" />
                                                    <?php else: ?>
                                                        <span><?php echo e($avatar[$value]); ?></span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <div wire:loading wire:target="avatar.<?php echo e($value); ?>">Uploading...</div>
                                            <input type="text" wire:model="team_name.<?php echo e($value); ?>" class="form-control mr-bt10" value="" placeholder="<?php echo app('translator')->get('Team name'); ?>">
                                            <input type="text" wire:model="linkedin.<?php echo e($value); ?>" class="form-control mr-bt10" value="" placeholder="<?php echo app('translator')->get('Linkedin'); ?>">
                                            <input type="text" wire:model="position.<?php echo e($value); ?>" class="form-control mr-bt10" value="" placeholder="<?php echo app('translator')->get('Position'); ?>">

                                            <textarea type="text" wire:model="bio.<?php echo e($value); ?>" class="form-control mr-bt10" placeholder="<?php echo app('translator')->get('Bio'); ?>"></textarea>


                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-danger btn-sm" wire:click.prevent="removeMember(<?php echo e($key); ?>)">Remove</button>
                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="form-group">
                                <div class="ico-button">
                                <span wire:click.prevent="addMember(<?php echo e($j); ?>)" class="btn btn-primary mb-5">
                                    <?php echo e(translate('Add Team Member')); ?>

                                </span>
                                </div>
                            </div>

                            <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(3)">Back</button>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" wire:click="teamSubmit" type="button">Next</button>

                        </div>
                    </div>
                </div>
                <div class="row setup-content <?php echo e($currentStep != 5 ? 'displayNone' : ''); ?>" id="step-5">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3><?php echo e(translate('Images & Videos')); ?></h3>

                            <div class="form-group">

                                <div class="ico-alert mr-bt10">
                                    <span class="editableLabel ">
                                        "<?php echo e(translate('Nearly there! Images and videos are often the difference for the most successful pitches on our site. Investors, like everyone, respond really well to visuals. So give your pitch the best chance to stand out and drop in some relevant images')); ?>."
                                    </span>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label for=""><?php echo e(translate('Logo')); ?> <span>(Square image, preferably 82x82)</span></label>
                                <input accept="image/*" type="file" wire:model="logo" class="form-control" value="">
                                <div wire:loading wire:target="logo">Uploading...</div>
                                <?php if(!is_string($logo) && $logo != NULL): ?>
                                    <div class="image-preview">
                                        <img src="<?php echo e($logo->temporaryUrl()); ?>" alt="banner">

                                    </div>
                                    <?php else: ?>
                                        <?php if($logo): ?>

                                            <div class="image-preview">
                                                <img src="<?php echo e($common->getLinkIdrive($logo)); ?>" alt="banner">
                                            </div>

                                        <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="form-group ">
                                <label for=""><?php echo e(translate('Banner image')); ?> <span>(best size 1600x600)</span></label>
                                <input type="file" accept="image/*" wire:model="banner" class="form-control" value="">
                                <div wire:loading wire:target="banner">Uploading...</div>
                                <?php if(!is_string($banner) && $banner != NULL): ?>
                                    <div class="image-preview">
                                        <img src="<?php echo e($banner->temporaryUrl()); ?>" alt="banner">

                                    </div>
                                    <?php else: ?>
                                        <?php if($banner): ?>

                                            <div class="image-preview">
                                                <img src="<?php echo e($common->getLinkIdrive($banner)); ?>" alt="banner">
                                            </div>

                                        <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="form-group ">
                                <label for=""><?php echo e(translate('Images')); ?> (<?php echo e(translate("To select multiple files you need to press the Ctrl key and click on the files you want to add")); ?>)</label>
                                <input type="file" accept="image/*" wire:model="images" multiple class="form-control" value="">
                                <div wire:loading wire:target="images">Uploading...</div>
                                    <?php if(!is_string($images) && $images != NULL): ?>
                                        <div class="image-preview mt-4">

                                            <div class="row">
                                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-3 center-div card mb-1">
                                                        <img alt="image" src="<?php echo e($image->temporaryUrl()); ?>">
                                                        <span wire:click="deleteTempImage(<?php echo e($key); ?>)">Delete</span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php if($images): ?>
                                            <div class="row image-preview mt-4">
                                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-3 center-div card mb-1">
                                                    <img alt="image" src="<?php echo e($common->getLinkIdrive($image)); ?>">
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>


                                        <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="video-wrap">
                                <div class="form-group ">
                                    <label for=""><?php echo e(translate('Video url')); ?></label>
                                    <input placeholder="<?php echo e(translate('Video url')); ?>" type="text" wire:model="video_url" class="form-control" value="">
                                </div>
                                <div class="form-group ">
                                    <label for=""><?php echo e(translate('Video title')); ?></label>
                                    <input placeholder="<?php echo e(translate('Video title')); ?>" type="text" wire:model="video_title" class="form-control" value="">
                                </div>
                                <div class="form-group ">
                                    <label for=""><?php echo e(translate('Video description')); ?></label>
                                    <textarea placeholder="<?php echo e(translate('Video description')); ?>" wire:model="video_description" class="form-control" value=""></textarea>
                                </div>

                            </div>

                            <!-- custom video -->
                            <div class="form-group">
                                <div class="ico-button">
                                    <span wire:click.prevent="addVideo(<?php echo e($c_video); ?>)" class="btn btn-primary mb-2">
                                        <?php echo e(translate('Add Video Url')); ?>

                                    </span>
                                </div>
                            </div>
                            <div class="video-wrap row">

                                <?php $__currentLoopData = $list_videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="add-input col-sm-6 row">
                                        <div class="col-sm-9">

                                            <input type="text" wire:model="video_item.<?php echo e($value); ?>" class="form-control mr-bt10" value=""
                                            placeholder="<?php echo e(translate('Video Url')); ?>">
                                        </div>
                                        <div class="col-sm-3 text-end">
                                            <button class="btn btn-danger btn-rm-url" wire:click.prevent="removeVideo(<?php echo e($key); ?>)">Remove</button>
                                        </div>

                                        <div class="col-sm-12">

                                            <input type="text" wire:model="v_title.<?php echo e($value); ?>" class="form-control mr-bt10" value=""
                                            placeholder="<?php echo e(translate('Video title')); ?>">
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea placeholder="<?php echo e(translate('Video description')); ?>"  wire:model="v_description.<?php echo e($value); ?>" class="form-control" value=""></textarea>
                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>



                            <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(4)">Back</button>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" wire:click="imageSubmit" type="button">Next</button>

                        </div>
                    </div>
                </div>
                <div class="row setup-content <?php echo e($currentStep != 6 ? 'displayNone' : ''); ?>" id="step-6">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3><?php echo e(translate('Document')); ?></h3>

                            <div class="form-group">
                                <div class="ico-alert mr-bt10">
                                    <p class="editableLabel ">
                                        <?php echo e(translate('Do you have any business documents? Do not worry if not, as we will send you advice on how to make them once you have submitted your pitch. If you do have some, make sure you upload them as they will make your pitch look super professional.')); ?>.
                                    </p>
                                    <p class="editableLabel ">
                                        <strong><?php echo e(translate('Please note:')); ?></strong>
                                        <?php echo e(translate('If an investor downloads one of your documents, you will then be able to message them directly. So make sure you upload at least one document!')); ?>.
                                    </p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for=""><?php echo e(translate('Business Plan')); ?></label>
                                <input type="file" wire:model="business_plan" class="form-control" value="">
                                <div><em><?php echo e(translate('Files: Word, Excel, PowerPoint & PDF. Max file size: 50MB')); ?></em></div>
                                <div wire:loading wire:target="business_plan">Uploading...</div>
                                <?php if(!is_string($business_plan) && $business_plan != NULL): ?>
                                    <div class="file_name">
                                        <a href="<?php echo e($business_plan->temporaryUrl()); ?>"><?php echo e(translate('View file')); ?></a>

                                    </div>
                                <?php else: ?>
                                    <?php if($business_plan): ?>
                                        <div class="file_name">
                                            <a href="<?php echo e($common->getLinkIdrive($business_plan)); ?>"><?php echo e(translate('View file')); ?></a>
                                        </div>

                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="form-group ">
                                <label for=""><?php echo e(translate('Financials')); ?></label>
                                <input type="file" wire:model="financials" class="form-control" value="">
                                <div><em><?php echo e(translate('Files: Word, Excel, PowerPoint & PDF. Max file size: 50MB')); ?></em></div>
                                <div wire:loading wire:target="financials">Uploading...</div>
                                <?php if(!is_string($financials) && $financials != NULL): ?>
                                    <div class="file_name">
                                        <a href="<?php echo e($financials->temporaryUrl()); ?>"><?php echo e(translate('View file')); ?></a>

                                    </div>
                                <?php else: ?>
                                    <?php if($financials): ?>
                                        <div class="file_name">
                                            <a href="<?php echo e($common->getLinkIdrive($financials)); ?>"><?php echo e(translate('View file')); ?></a>
                                        </div>

                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="form-group ">
                                <label for=""><?php echo e(translate('Pitch Deck')); ?></label>
                                <input type="file" wire:model="pitch_deck" class="form-control" value="">
                                <div><em><?php echo e(translate('Files: Word, Excel, PowerPoint & PDF. Max file size: 50MB')); ?></em></div>
                                <div wire:loading wire:target="pitch_deck">Uploading...</div>
                                <?php if(!is_string($pitch_deck) && $pitch_deck != NULL): ?>
                                    <div class="file_name">
                                        <a href="<?php echo e($pitch_deck->temporaryUrl()); ?>"><?php echo e(translate('View file')); ?></a>

                                    </div>
                                <?php else: ?>
                                    <?php if($pitch_deck): ?>
                                        <div class="file_name">
                                            <a href="<?php echo e($common->getLinkIdrive($pitch_deck)); ?>"><?php echo e(translate('View file')); ?></a>
                                        </div>

                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="form-group ">
                                <label for=""><?php echo e(translate('Executive Summary')); ?></label>
                                <input type="file" wire:model="executive_summary" class="form-control" value="">
                                <div><em><?php echo e(translate('Files: Word, Excel, PowerPoint & PDF. Max file size: 50MB')); ?></em></div>
                                <div wire:loading wire:target="executive_summary">Uploading...</div>
                                <?php if(!is_string($executive_summary) && $executive_summary != NULL): ?>
                                    <div class="file_name">
                                        <a href="<?php echo e($executive_summary->temporaryUrl()); ?>"><?php echo e(translate('View file')); ?></a>

                                    </div>
                                <?php else: ?>
                                    <?php if($executive_summary): ?>
                                        <div class="file_name">
                                            <a href="<?php echo e($common->getLinkIdrive($executive_summary)); ?>"><?php echo e(translate('View file')); ?></a>
                                        </div>

                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="form-group ">
                                <label for=""><?php echo e(translate('Additional Documents')); ?></label>
                                <input type="text" wire:model="additional_documents_name" class="form-control mr-bt10" value="" placeholder="<?php echo e(translate('Documents name')); ?>">
                                <input type="file" wire:model="additional_documents" class="form-control" value="">
                                <div><em><?php echo e(translate('Files: Word, Excel, PowerPoint & PDF. Max file size: 50MB')); ?></em></div>
                                <div wire:loading wire:target="additional_documents">Uploading...</div>
                                <?php if(!is_string($additional_documents) && $additional_documents != NULL): ?>
                                    <div class="file_name">
                                        <a href="<?php echo e($additional_documents->temporaryUrl()); ?>"><?php echo e(translate('View file')); ?></a>

                                    </div>
                                <?php else: ?>
                                    <?php if($additional_documents): ?>
                                        <div class="file_name">
                                            <a href="<?php echo e($common->getLinkIdrive($additional_documents)); ?>"><?php echo e(translate('View file')); ?></a>
                                        </div>

                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>

                            <div class="document-wrap">

                                <?php $__currentLoopData = $add_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="add-input">
                                        <div class="form-group">

                                            <input type="text" wire:model="add_document_name.<?php echo e($value); ?>" class="form-control mr-bt10" value=""
                                                placeholder="<?php echo app('translator')->get('Document title'); ?>">


                                            <input type="file" wire:model="add_document_file.<?php echo e($value); ?>" class="form-control" value="">
                                            <div><em><?php echo e(translate('Files: Word, Excel, PowerPoint & PDF. Max file size: 50MB')); ?></em></div>
                                            <div wire:loading wire:target="add_document_file.<?php echo e($value); ?>">Uploading...</div>

                                            <?php if(is_array($add_document_file) && array_key_exists($value, $add_document_file)): ?>
                                                <div class="file_name">
                                                    <?php if(!is_string($add_document_file[$value]) && $add_document_file[$value] != NULL): ?>

                                                        <a target="_blank" target="_blank" href="<?php echo e($add_document_file[$value]->temporaryUrl()); ?>"><?php echo e(translate('View file')); ?></a>
                                                    <?php else: ?>
                                                        <a target="_blank" target="_blank" href="<?php echo e($common->getLinkIdrive($add_document_file[$value])); ?>"><?php echo e(translate('View file')); ?></a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>



                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-danger btn-sm" wire:click.prevent="removeDocument(<?php echo e($key); ?>)">Remove</button>
                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-group">
                                <div class="ico-button">
                                    <span wire:click.prevent="addDocument(<?php echo e($c_document); ?>)" class="btn btn-primary mb-5">
                                        <?php echo e(translate('Add Document')); ?>

                                    </span>
                                </div>
                            </div>


                            <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(5)">Back</button>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" wire:click="documentSubmit" type="button">Next</button>
                            
                        </div>
                    </div>
                </div>

                <div class="row setup-content <?php echo e($currentStep != 7 ? 'displayNone' : ''); ?>" id="step-7">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3><?php echo e(translate('Questions and answers')); ?></h3>

                            <div class="question-wrap">
                                
                                <?php $__currentLoopData = $question_answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="add-input">
                                        <div class="form-group">

                                            <input type="text" wire:model="question.<?php echo e($value); ?>" class="form-control mr-bt10" value=""
                                                placeholder="<?php echo app('translator')->get('Question'); ?>">


                                            <textarea type="text" wire:model="answer.<?php echo e($value); ?>" class="form-control mr-bt10"
                                                placeholder="<?php echo app('translator')->get('Answer'); ?>"></textarea>


                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-danger btn-sm" wire:click.prevent="removeQuestion(<?php echo e($key); ?>)">Remove</button>
                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="form-group">
                                <div class="ico-button">
                                    <span wire:click.prevent="addQuestion(<?php echo e($c_question); ?>)" class="btn btn-primary mb-5">
                                        <?php echo e(translate('Add Question')); ?>

                                    </span>
                                </div>
                            </div>

                            <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(6)">Back</button>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" wire:click="submitForm" type="button">Finish!</button>

                        </div>
                    </div>
                </div>



        </div>
    </div>

</section>
<style>

</style>
<?php $__env->startPush('script'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        "use strict";

        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                $('.dialcode-set').attr('value', $(this).val());
            });
            function setDialCode() {
                let currency = $('.dialCode-change').val();
                $('.dialcode-set').attr('value', currency);
            }


            function createSummernote($id) {
                $('#' + $id).summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['insert', ['link']],
                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            window.livewire.find('<?php echo e($_instance->id); ?>').set($id, contents);
                        }
                    }
                });

            }

            createSummernote('short_summary');
            createSummernote('the_business');
            createSummernote('the_market');
            createSummernote('progress_proof');
            createSummernote('objectives_future');

        });





    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\project\ribano\resources\views/livewire/wizard.blade.php ENDPATH**/ ?>