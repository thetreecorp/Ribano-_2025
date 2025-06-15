<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd ">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                    <div class="row">
                    <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                            <?php echo form_open_multipart("backend/setting/email_sms_setting/update_sender") ?>
                     <?php } }else{ ?>
                                <?php echo form_open_multipart("backend/setting/email_sms_setting/update_sender") ?>
                    <?php } ?>
                        <div class="col-md-6">
                         <fieldset>
                            <legend> <?php echo display('email_notification_settings'); ?> </legend>
                             <div class="checkbox">
                                <input id="checkbox1" type="checkbox" <?php echo ($email->deposit!=NULL?'checked':'')?> name="deposit">
                                <label for="checkbox1"><?php echo display('deposit'); ?></label>
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" <?php echo ($email->transfer!=NULL?'checked':'')?> name="transfer">
                                <label for="checkbox2"><?php echo display('transfer'); ?></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox3" type="checkbox" <?php echo ($email->payout!=NULL?'checked':'')?>  name="payout">
                                <label for="checkbox3"><?php echo display('roi'); ?></label>
                            </div>
                            <div class="checkbox checkbox-danger">
                                <input id="checkbox6" type="checkbox" <?php echo ($email->withdraw!=NULL?'checked':'')?>  name="withdraw">
                                <label for="checkbox6"><?php echo display('withdraw'); ?></label>
                            </div>
                            <div class="checkbox checkbox-info">
                                <input id="checkbox7" type="checkbox" <?php echo ($email->sign_up!=NULL?'checked':'')?>  name="sign_up">
                                <label for="checkbox7"><?php echo display('sign_up'); ?></label>
                            </div>
                            <div class="checkbox checkbox-warning">
                                <input id="checkbox8" type="checkbox" <?php echo ($email->authentication!=NULL?'checked':'')?>  name="authentication">
                                <label for="checkbox8"><?php echo display('google_authentication'); ?></label>
                            </div>
                            <input type="hidden" name="email" value="email">
                            
                        </fieldset>
                <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div>
                        <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                    </div>
                <?php } }else{ ?>
                        <div>
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                <?php } ?>

                    </div>
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                        <?php echo form_close() ?>
                        <?php echo form_open_multipart("backend/setting/email_sms_setting/update_sender") ?>
             <?php } }else{ ?>
                        <?php echo form_close() ?>
                        <?php echo form_open_multipart("backend/setting/email_sms_setting/update_sender") ?>
            <?php } ?>
                    <div class="col-md-6">
                         <fieldset>
                            <legend> <?php echo display('sms_sending'); ?>  </legend>
                             <div class="checkbox">
                                <input id="checkbox9" type="checkbox" <?php echo ($sms->deposit!=NULL?'checked':'')?> name="deposit">
                                <label for="checkbox9"><?php echo display('deposit'); ?></label>
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox10" type="checkbox" <?php echo ($sms->transfer!=NULL?'checked':'')?> name="transfer">
                                <label for="checkbox10"><?php echo display('transfer'); ?></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox11" type="checkbox" <?php echo ($sms->payout!=NULL?'checked':'')?> name="payout">
                                <label for="checkbox11"><?php echo display('roi'); ?></label>
                            </div>
                            <div class="checkbox checkbox-danger">
                                <input id="checkbox12" type="checkbox" <?php echo ($sms->withdraw!=NULL?'checked':'')?> name="withdraw">
                                <label for="checkbox12"><?php echo display('withdraw'); ?></label>
                            </div>
                            <div class="checkbox checkbox-info">
                                <input id="checkbox13" type="checkbox" <?php echo ($sms->sign_up!=NULL?'checked':'')?>  name="sign_up">
                                <label for="checkbox13"><?php echo display('sign_up'); ?></label>
                            </div>
                            <div class="checkbox checkbox-warning">
                                <input id="checkbox14" type="checkbox" <?php echo ($sms->authentication!=NULL?'checked':'')?>  name="authentication">
                                <label for="checkbox14"><?php echo display('sms_authentication'); ?></label>
                            </div>
                            <input type="hidden" name="sms" value="sms">

                           
                        </fieldset>
                    <div>
                        <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                                <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        <?php } }else{ ?>
                                    <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        <?php } ?>
                    </div>

                    </div>
                        <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                                    <?php echo form_close() ?>
                         <?php } }else{ ?>
                                    <?php echo form_close() ?>
                        <?php } ?>
                    </div> 

            </div>
        </div>
    </div>
</div>




 