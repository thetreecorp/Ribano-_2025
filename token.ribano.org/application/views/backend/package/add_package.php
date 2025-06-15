<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="border_preview">
            <?php if(!empty($userrole)){ if($userrole->create_permission==1 || $userrole->edit_permission==1){ ?>
                <?php echo @$package->package_id?form_open_multipart("backend/package/add_package/index/$package->package_id"):form_open_multipart("backend/package/add_package/index"); ?>
            <?php } }else{ ?>
                <?php echo @$package->package_id?form_open_multipart("backend/package/add_package/index/$package->package_id"):form_open_multipart("backend/package/add_package/index"); ?>
            <?php } ?>
                <?php if(!empty($package)) echo form_hidden('package_id', html_escape($package->package_id)) ?> 

                    <div class="form-group row">
                        <label for="package_name" class="col-sm-3 col-form-label"><?php echo display('package_name') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input name="package_name" value="<?php if(!empty($package)) echo html_escape($package->package_name); ?>" class="form-control" placeholder="<?php echo display('package_name') ?>" type="text" id="package_name" data-toggle="tooltip" title="<?php echo display('tooltip_package_name') ?> " required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="package_period" class="col-sm-3 col-form-label"><?php echo display('period') ?>(Day) <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input name="package_period" value="<?php if(!empty($package)) echo html_escape($package->period); ?>" class="form-control" placeholder="<?php echo display('period') ?>" type="number" id="package_period" data-toggle="tooltip" title="<?php echo display('tooltip_package_period') ?>" min="7" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pack_type" class="col-sm-3 col-form-label"> <?php echo display('pak_type'); ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <select class="form-control" name="pack_type" id="pack_type">
                                <option value=""><?php echo display('select_type'); ?></option>
                                <option value="secured" <?php if(!empty($package)) echo $package->pack_type=="secured"?"selected":""; ?> ><?php echo display('secured'); ?></option>
                                <option value="guaranteed" <?php if(!empty($package)) echo $package->pack_type=="guaranteed"?"selected":""; ?>><?php echo display('guaranteed'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="num_share" class="col-sm-3 col-form-label"><?php echo display('num_share') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input name="num_share" value="<?php if(!empty($package)) echo html_escape($package->num_share); ?>" class="form-control" placeholder="<?php echo display('num_share') ?>" type="text" id="num_share" data-toggle="tooltip" title="<?php echo display('tooltip_num_share') ?> " required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="package_price" class="col-sm-3 col-form-label"><?php echo display('package_price') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input name="package_price" value="<?php if(!empty($package)) echo html_escape($package->package_price); ?>" class="form-control" placeholder="<?php echo display('package_price') ?>" type="text" id="package_price" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="package_term" class="col-sm-3 col-form-label"><?php echo display('package_term') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <textarea rows="5" name="package_term" class="form-control" placeholder="<?php echo display('package_term') ?>" id="package_term" required ><?php if(!empty($package)) echo html_escape($package->package_term); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="facility_type" class="col-sm-3 col-form-label"> Facilites Types <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <select class="form-control" name="facility_type" id="facility_type">
                                <option value="">Select type</option>
                                <?php if(!empty(@$package->facility_type) && @$package->facility_type==1){ ?>
                                        <option value="1" <?php echo @$package->facility_type==1?"selected":""; ?>>ROI</option>
                                <?php }else if(!empty(@$package->facility_type) && @$package->facility_type==2){ ?>
                                            <option value="2"<?php echo @$package->facility_type==2?"selected":""; ?>><?php echo display('others'); ?></option>
                                <?php }else{ ?>
                                        <option value="1"><?php echo display('roi'); ?></option>
                                        <option value="2"><?php echo display('others'); ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                <?php if(!empty(@$package->facility_type)){ 

                            if(@$package->facility_type==1){ ?>


                                <div class="form-group row">
                                    <label for="weekly_roi" class="col-sm-3 col-form-label"><?php echo display('weekly_roi') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="weekly_roi" value="<?php if(!empty($package)) echo html_escape($package->weekly_roi); ?>" class="form-control" placeholder="<?php echo display('weekly_roi') ?>" type="text" id="weekly_roi" data-toggle="tooltip" title="Who buy this package they will get weekly ROI in <?php echo html_escape($stoinfo->pair_with);?>. Example: 5. They will get every week 5 till them package period" disabled required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="monthly_roi" class="col-sm-3 col-form-label"><?php echo display('monthly_roi') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="monthly_roi" value="<?php if(!empty($package)) echo html_escape($package->monthly_roi) ?>" class="form-control" placeholder="<?php echo display('monthly_roi') ?>" type="text" id="monthly_roi" data-toggle="tooltip" title="<?php echo display('tooltip_package_monthly_roi') ?> " readonly required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="yearly_roi" class="col-sm-3 col-form-label"><?php echo display('yearly_roi') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="yearly_roi" value="<?php if(!empty($package)) echo $package->yearly_roi ?>" class="form-control" placeholder="<?php echo display('yearly_roi') ?>" type="text" id="yearly_roi" data-toggle="tooltip" title="<?php echo display('tooltip_package_yearly_roi') ?> " readonly required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total_percent" class="col-sm-3 col-form-label"><?php echo display('total_percent') ?> %<span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="total_percent" value="<?php if(!empty($package)) echo html_escape($package->total_percent) ?>" class="form-control" placeholder="<?php echo display('total_percent') ?>" type="text" id="total_percent" data-toggle="tooltip" title="<?php echo display('tooltip_package_total_percent_roi') ?> " readonly required>
                                    </div>
                                </div>

                        <?php } else{ ?>


                                <div class="form-group row">
                                    <label id="package_facilites" class="col-sm-3">Package Facilites</label>
                                    <label id="package_facilites_hidden" class="col-sm-7">&nbsp;</label>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><button id="add_facility" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Facility</button></label>
                                    <div id="add_facility_input" class="col-sm-7">
                                        <?php if(!empty($package)){ 

                                                $jsondata = $package->data?json_decode($package->data,true):"";
                                                if(!empty($jsondata)){
                                                    foreach ($jsondata as $key => $value) { 
                                        ?>
                                        <div class="facilityDifInput">
                                            <input name="facility[]" value="<?php echo html_escape($value); ?>" class="form-control facilityInputbox" placeholder="New Facility" type="text" >
                                            <span class="removeBtn">×</span>
                                        </div>
                                        <?php } } } ?>
                                    </div>
                                </div>
                        <?php } ?>



                <?php } else{ ?>

                            <div class="roi_type" id="roi_type">
                                <div class="form-group row">
                                    <label for="weekly_roi" class="col-sm-3 col-form-label"><?php echo display('weekly_roi') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="weekly_roi" value="<?php if(!empty($package)) echo html_escape($package->weekly_roi) ?>" class="form-control" placeholder="<?php echo display('weekly_roi') ?>" type="text" id="weekly_roi" data-toggle="tooltip" title="Who buy this package they will get weekly ROI in <?php echo html_escape($stoinfo->pair_with);?>. Example: 5. They will get every week 5 till them package period" disabled required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="monthly_roi" class="col-sm-3 col-form-label"><?php echo display('monthly_roi') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="monthly_roi" value="<?php if(!empty($package)) echo html_escape($package->monthly_roi) ?>" class="form-control" placeholder="<?php echo display('monthly_roi') ?>" type="text" id="monthly_roi" data-toggle="tooltip" title="<?php echo display('tooltip_package_monthly_roi') ?> " readonly required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="yearly_roi" class="col-sm-3 col-form-label"><?php echo display('yearly_roi') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="yearly_roi" value="<?php if(!empty($package)) echo html_escape($package->yearly_roi) ?>" class="form-control" placeholder="<?php echo display('yearly_roi') ?>" type="text" id="yearly_roi" data-toggle="tooltip" title="<?php echo display('tooltip_package_yearly_roi') ?> " readonly required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total_percent" class="col-sm-3 col-form-label"><?php echo display('total_percent') ?> %<span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="total_percent" value="<?php if(!empty($package)) echo html_escape($package->total_percent) ?>" class="form-control" placeholder="<?php echo display('total_percent') ?>" type="text" id="total_percent" data-toggle="tooltip" title="<?php echo display('tooltip_package_total_percent_roi') ?> " readonly required>
                                    </div>
                                </div>

                            </div>
                                
                            <div class="other_facilites_type" id="other_facilites_type">
                                <div class="form-group row">
                                    <label id="package_facilites" class="col-sm-3">Package Facilites</label>
                                    <label id="package_facilites_hidden" class="col-sm-7">&nbsp;</label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><button id="add_facility" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Facility</button></label>
                                    <div id="add_facility_input" class="col-sm-7">
                                        <?php if(!empty($package)){ 

                                                $jsondata = $package->data?json_decode($package->data,true):"";
                                                if(!empty($jsondata)){
                                                    foreach ($jsondata as $key => $value) { 
                                        ?>
                                        <div class="facilityDifInput">
                                            <input name="facility[]" value="<?php echo html_escape($value); ?>" class="form-control facilityInputbox" placeholder="New Facility" type="text" >
                                            <span class="removeBtn">×</span>
                                        </div>
                                        <?php } } } ?>
                                    </div>
                                </div>
                            
                            </div>
                <?php } ?>

                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status') ?> <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <label class="radio-inline">
                            <?php echo form_radio('status', '1', ((@$package->status==1 || @$package->status==null)?true:false)); ?><?php echo display('active') ?>
                         </label>
                        <label class="radio-inline">
                            <?php echo form_radio('status', '0', ((@$package->status=="0")?true:false) ); ?><?php echo display('inactive') ?>
                         </label> 
                    </div>
                </div>

            <?php if(!empty($userrole)){ if($userrole->create_permission==1 || $userrole->edit_permission==1){ ?>

                    <div class="form-group row">
                        <div class="col-md-7 col-md-offset-3">

                            <?php if(!empty($package)){ ?>

                                    <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display('update'); ?></button>

                            <?php }else{ ?>

                                <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display('add_package'); ?></button>

                            <?php }?>

                        </div>
                    </div>

            <?php } }else{ ?>

                    <div class="form-group row">
                        <div class="col-md-7 col-md-offset-3">

                            <?php if(!empty($package)){ ?>

                                    <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display('update'); ?></button>

                            <?php }else{ ?>

                                <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display('add_package'); ?></button>

                            <?php }?>

                        </div>
                    </div>

                <?php echo form_close() ?>
            <?php } ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>