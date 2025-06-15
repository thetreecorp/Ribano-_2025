<div class="authenticator">
    <?php echo form_open('shareholder/twoauthentication','id="twoauthentication" '); ?>
        <h2 class="m-t0-b45">Two-factor Authentication</h2>
        <div class="form-group">
            <label class="form-label">Authenticator <i class="text-danger">*</i></label>
            <select class="form-control" name="twoauthentication" id="twoauthentication">
                <option value=""><?php echo display('select_option'); ?></option>
                
                    <?php if(!empty($get_auth_getway_email->authentication)){ ?>
                    
                        <option value="googleauthenticator" <?php echo !empty($select_auth->googleauth)?'selected':null; ?>>Google Authenticator</option>
                        
                    <?php }
                    if(!empty($get_auth_getway_sms->authentication)){ ?>
                    
                        <option value="smsauthenticator" <?php echo !empty($select_auth->smsauth)?'selected':null; ?>>SMS Authenticator</option>
                        
                    <?php } ?>
                    
            </select>
        </div>
        <div class="form-group">
            <label class="form-label"><?php echo display('password'); ?> <i class="text-danger">*</i></label>
            <input type="password" class="form-control" placeholder="Enter Your Password" name="password" id="password" />
        </div>
        <button type="submit" class="btn btn-success"><?php echo display('submit'); ?></button>
    <?php echo form_close();?>
</div>
<!-- /.End of authenticator -->