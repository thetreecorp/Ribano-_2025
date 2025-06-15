<div class="reg-wrapper">
    <div class="container">
        <div class="col-sm-7 col-md-6">
            <div class="">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h2 class="mb-4"><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <!-- alert message -->
                        <?php if ($this->session->flashdata('message') != null) {  ?>
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('message'); ?>
                        </div> 
                        <?php } ?>
                            
                        <?php if ($this->session->flashdata('exception') != null) {  ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('exception'); ?>
                        </div>
                        <?php } ?>
                            
                        <?php if (validation_errors()) {  ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo validation_errors(); ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php echo form_open('resetPassword'); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input">
                            <input class="input__field" type="text"  name="verificationcode" id="verificationcode" value="" autocomplete="off" required>
                            <label class="input__label" for="f_name">
                                <span class="input__label-content" data-content="Verification Code">Verification Code</span>
                            </label>
                        </div>
                    </div> 
                </div>
                <div class="row">    
                    <div class="col-sm-12">
                        <div class="input">
                            <input class="input__field" type="password" name="rpass" id="pass" required>
                            <label class="input__label" for="pass">
                                <span class="input__label-content" data-content="<?php echo display('password'); ?>">New Password</span>
                            </label>
                            <div id="password_msg">
                              <p id="letter" class="invalid"><?php echo display('a_lowercase_letter') ?></p>
                              <p id="capital" class="invalid"><?php echo display('a_capital_uppercase_letter') ?></p>
                              <p id="special" class="invalid"><?php echo display('a_special') ?></p>
                              <p id="number" class="invalid"><?php echo display('a_number') ?></p>
                              <p id="length" class="invalid"><?php echo display('minimum_8_characters') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">    
                    <div class="col-sm-12">
                        <div class="input">
                            <input class="input__field" type="password" name="confirmpassword" id="r_pass" onkeyup="rePassword()" required>
                            <label class="input__label" for="r_pass">
                                <span class="input__label-content" data-content="<?php echo display('conf_password'); ?>"><?php echo display('conf_password'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-reg mb-3">Submit</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
                        