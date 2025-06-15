<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                <?php echo form_open_multipart("backend/system_users/add_user/index/$admin->id") ?>
            <?php } }else{ ?>
                <?php echo form_open_multipart("backend/system_users/add_user/index/$admin->id") ?>
            <?php } ?>
                    
                    <?php echo form_hidden('id',html_escape($admin->id)) ?>
                    
                    <div class='form-group row'>
                        <label for='role' class='col-sm-3 col-form-label'><?php echo display('role'); ?> <i class="text-danger">*</i></label>
                        <div class='col-sm-9'>
                            <select class='form-control' name="role" id="role" required>

                                <option value="0"><?php echo display('all_permission'); ?></option>
                                
                                <?php
                                    $selected = "";
                                    foreach ($role as $key => $value) {
                                        
                                        if($admin->role_id==$value->role_id){
                                            $selected = "selected";
                                        }
                                        echo "<option value='".html_escape($value->role_id)."' $selected>$value->role_name</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="firstname" class="col-sm-3 col-form-label"><?php echo display('firstname') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="firstname" class="form-control" type="text" placeholder="<?php echo display('firstname') ?>" id="firstname"  value="<?php echo html_escape($admin->firstname) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lastname" class="col-sm-3 col-form-label"><?php echo display('lastname') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="lastname" class="form-control" type="text" placeholder="<?php echo display('lastname') ?>" id="lastname" value="<?php echo html_escape($admin->lastname) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="email" class="form-control" type="text" placeholder="<?php echo display('email') ?>" id="email" value="<?php echo html_escape($admin->email) ?>">
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="password" class="form-control" type="password" placeholder="<?php echo display('password') ?>" id="password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="about" class="col-sm-3 col-form-label"><?php echo display('about') ?></label>
                        <div class="col-sm-9">
                            <textarea name="about" placeholder="<?php echo display('about') ?>" class="form-control" id="about"><?php echo html_escape($admin->about) ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="preview" class="col-sm-3 col-form-label"><?php echo display('preview') ?></label>
                        <div class="col-sm-9">
                            <?php if (!empty($admin->image)) { ?>
                               <img src="<?php echo base_url(html_escape($admin->image)) ?>" class="img-thumbnail" width="125" height="100">
                            <?php } ?>
                            
                        </div>
                        <input type="hidden" name="old_image" value="<?php echo html_escape($admin->image) ?>">
                    </div> 

                    <div class="form-group row">
                        <label for="image" class="col-sm-3 col-form-label"><?php echo display('image') ?>(MAX 2MB) 115×90</label>
                        <div class="col-sm-9">
                            <input type="file" name="image" id="image" aria-describedby="fileHelp">
                            <small id="fileHelp" class="text-muted"></small>
                        </div>
                    </div> 

         
                    <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?> <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <?php echo form_radio('status', '1', (($admin->status==1 || $admin->status==null)?true:false), 'id="status"'); ?><?php echo display('active') ?>
                            </label>
                            <label class="radio-inline">
                                <?php echo form_radio('status', '0', (($admin->status=="0")?true:false) , 'id="status"'); ?><?php echo display('inactive') ?>
                            </label> 
                        </div>
                    </div>
         
         <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo $admin->id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
        <?php } }else{ ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo $admin->id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
            <?php } ?>

            </div>
        </div>
    </div>
</div>

 