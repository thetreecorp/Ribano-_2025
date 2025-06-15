<div class="row">
	<div class="col-sm-7 col-md-7">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display('upload_document_for_profile_verification'); ?></h2>
                </div>
            </div>

            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                <?php echo form_open_multipart("backend/shareholders/shareholder/pending_user_verification/".html_escape(@$user->user_id)) ?>
            <?php } }else{ ?>
                <?php echo form_open_multipart("backend/shareholders/shareholder/pending_user_verification/".html_escape(@$user->user_id)) ?>
            <?php } ?>
				<?php echo form_hidden('user_id', html_escape(@$user->user_id)) ?>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('verification_type'); ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->verify_type) ?>
                        </div>
                    </div>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('name'); ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->first_name) ?></span>
                        </div>
                    </div>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('surname'); ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->last_name) ?></span>
                        </div>
                    </div>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('gender'); ?></label>
                        <div class="col-sm-8">
                            <?php echo (@$user->gender==1)?'Male':'Female' ?></span>
                        </div>
                    </div>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label">
                            <?php if(@$user->verify_type=="passport"){ ?>
                                Passport No.
                            <?php }else if(@$user->verify_type=="driving_license"){ ?>
                                Driving License
                            <?php }else{ ?>
                                <?php echo display('nid'); ?>
                            <?php } ?>
                            
                        </label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->id_number) ?>
                        </div>
                    </div>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label">Doc I</label>
                        <div class="col-sm-8">
                        <?php if (@$user->document1) { ?>
                            <img src="<?php echo base_url(html_escape(@$user->document1)); ?>" class="img-responsive"/>
                            <a href="<?php echo base_url(html_escape(@$user->document1)); ?>" class="btn btn-success" download="<?php echo html_escape(@$user->first_name)."_".html_escape(@$user->user_id)."_1"; ?>"><?php echo display('download_file'); ?></a>
                        <?php } ?>
                        </div>
                    </div>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label">Doc II</label>
                        <div class="col-sm-8">
                        <?php if (@$user->document2) { ?>
                            <img src="<?php echo base_url(html_escape(@$user->document2)); ?>" class="img-responsive"/>
                            <a href="<?php echo base_url(html_escape(@$user->document2)); ?>" class="btn btn-success" download="<?php echo html_escape(@$user->first_name)."_".html_escape(@$user->user_id)."_2"; ?>"><?php echo display('download_file'); ?></a>	
                        <?php } ?>
                        </div>
                    </div>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('upload_document'); ?></label>
                        <div class="col-sm-8">
                            <?php 
                                $date=date_create(@$user->date);
                                echo date_format(@$date,"jS F Y");  
                            ?>
                        </div>
                    </div>
                	<div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('status'); ?></label>
                        <div class="col-sm-8">
                        	<h3>
                            <?php if (@$user->verified==0) { echo "Not Submited"; } ?>
                            <?php if (@$user->verified==1) { echo "Verified"; } ?>
                            <?php if (@$user->verified==2) { echo "Cancel"; } ?>
                            <?php if (@$user->verified==3) { echo "Processing"; } ?>
                            </h3>
                        </div>
                    </div>

            <?php if (@$user->verified==3) { ?>
                <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
					<div>
                        <button type="submit" name="cancel" class="btn btn-primary" ><?php echo display("cancel") ?></button>
                        <button type="submit" name="approve" class="btn btn-success"><?php echo display('approve'); ?></button>
                    </div>
                <?php } }else{ ?>
                    <div>
                        <button type="submit" name="cancel" class="btn btn-primary" ><?php echo display("cancel") ?></button>
                        <button type="submit" name="approve" class="btn btn-success"><?php echo display('approve'); ?></button>
                    </div> 
                <?php } ?>
            <?php } ?>
                <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <?php echo form_close() ?>
                <?php } }else{ ?>
                    <?php echo form_close() ?>
                <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5 col-md-5">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display('user_info') ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('user_id') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->user_id) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('username') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->username) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('referral_id') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->referral_id) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('language') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->language) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('firstname') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->first_name) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('lastname') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->last_name) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('email') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->email) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('mobile') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->phone) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('registered_ip') ?></label>
                        <div class="col-sm-8">
                            <?php echo html_escape(@$user->ip) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('status') ?></label>
                        <div class="col-sm-8">
                            <?php echo (@$user->status==1)?display('active'):display('inactive'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('registered_date'); ?></label>
                        <div class="col-sm-8">
                            <?php 
                                $date=date_create(@$user->created);
                                echo date_format(@$date,"jS F Y");  
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>