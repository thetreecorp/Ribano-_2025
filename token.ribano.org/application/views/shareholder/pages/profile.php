<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open_multipart("shareholder/profile/update") ?>
                <?php echo form_hidden('uid', html_escape($profile->id)) ?>
  
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label><?php echo display("shareholder_user_name") ?></label>
                            <input type="text" value="<?php echo html_escape($profile->username) ?>" class="form-control" name="username" placeholder="<?php echo display("username") ?>" disabled>
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("referral_id") ?></label>
                            <input type="text" value="<?php echo html_escape($profile->referral_id) ?>" class="form-control" name="referral_id" placeholder="<?php echo display("sponsor_name") ?>" disabled>
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("firstname") ?> <span class="text-danger">*</span></label>
                            <input type="text" value="<?php echo html_escape($profile->first_name) ?>" class="form-control" name="first_name" placeholder="<?php echo display("firstname") ?>" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("lastname") ?> </label>
                            <input type="text" value="<?php echo html_escape($profile->last_name) ?>" class="form-control" name="last_name" placeholder="<?php echo display("lastname") ?>">
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("email") ?> <span class="text-danger">*</span></label>
                            <input type="email" value="<?php echo html_escape($profile->email) ?>" class="form-control" name="email" placeholder="<?php echo display("email") ?>" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("mobile") ?></label>
                            <input type="text" value="<?php echo html_escape($profile->phone) ?>" id="mobile" class="form-control" name="mobile" placeholder="<?php echo display("mobile") ?>">
                        </div>

                        <div class="form-group col-lg-6">
                                <label><?php echo display('language') ?></label>
                                
                                <select name="language" class="form-control">
                                    <?php 
                                        foreach($languageList as $key => $val){
                                            echo '<option '.($profile->language==$key?'selected':'').' value="'.html_escape($key).'">'.html_escape($val).'</option>';
                                        }
                                    ?>
                                </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Profile Picture(200 &times; 150) (MAX 2MB) <img class="profile-image" src="<?php echo !empty($profile->image)?base_url("$profile->image"):base_url("assets/images/icons/user.png"); ?>" /></label>
                            <input type="file" id="profile_picture" class="form-control" name="profile_picture" >
                        </div>
                        
                    </div> 

                    <div>
                        <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                    </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>