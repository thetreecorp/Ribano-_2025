<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="border_preview">
                    <div class="profile-verify">
                        <?php
                            if($verify_status->verified==0){
                        ?>
                            <?php echo form_open_multipart("shareholder/verify_account") ?>
                            <div class="form-group row">
                                <label for="verify_type" class="col-sm-4 col-form-label"><?php echo display('verify_type'); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control basic-single" name="verify_type" required id="verify_type">
                                        <option selected><?php echo display('select_option'); ?></option>
                                        <option value="passport"><?php echo display('passport'); ?></option>
                                        <option value="driving_license"><?php echo display('drivers_license'); ?></option>
                                        <option value="nid"><?php echo display('government_issued_id_card'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label"><?php echo display('given_name'); ?> <i class="text-danger">*</i></label>
                                <div class="col-md-8">
                                    <input name="first_name" type="text" class="form-control" id="first_name" placeholder="" value="" required="">
                                </div>
                            </div>                        
                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label"><?php echo display('surname'); ?> <i class="text-danger">*</i></label>
                                <div class="col-md-8">
                                    <input name="last_name" type="text" class="form-control" id="last_name" placeholder="" value="" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_number" class="col-md-4 col-form-label"><?php echo display('passport_nid_license_number'); ?> <i class="text-danger">*</i></label>
                                <div class="col-md-8">
                                    <input name="id_number" type="text" class="form-control" id="id_number" placeholder="<?php echo display('passport_nid_license_number'); ?>" value="" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4 pt-0"><?php echo display('gender'); ?> <span><i class="text-danger">*</i></span></label>
                                <div class="col-sm-8">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline1" name="gender" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline1"><?php echo display('male'); ?></label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="gender" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline2"><?php echo display('female'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <span id="verify_field"></span>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-success"><?php echo display('submit'); ?></button>
                                </div>
                            </div>
                            <?php echo form_close();?>
                        <?php
                            }else{
                        ?>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php if($verify_status->verified==1){ ?>
                                            <center>
                                                <font color="green" size="+2"><?php echo display('profile_is_verified'); ?></font>
                                            </center>
                                        <?php } else if($verify_status->verified==2){ ?>
                                            <center>
                                                <font color="red" size="+2"><?php echo display('verification_cancel'); ?></font>
                                            </center>
                                        <?php } else{ ?>
                                            <center><font color="brown" size="+2"><?php echo display('verification_is_processing'); ?></font></center>
                                        <?php } ?>
                                    </div>
                                </div>

                            <?php } ?>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>