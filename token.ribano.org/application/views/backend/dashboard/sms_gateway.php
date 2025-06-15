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
                            <?php echo form_open_multipart("backend/setting/sms_gateway/update_sms_gateway") ?>
                <?php } }else{ ?>
                            <?php echo form_open_multipart("backend/setting/sms_gateway/update_sms_gateway") ?>
                <?php } ?>
                    
                    <?php echo form_hidden('es_id',html_escape($sms->es_id)) ?>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="gatewayname" class="col-xs-3 col-form-label">Gateway <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <select class="form-control basic-single" name="gatewayname" id="gatewayname" required>
                                    <option><?php echo display('select_option'); ?></option>
                                    <option value="smsrank" <?php echo ($sms->gatewayname=="smsrank")?'Selected':'' ?>>SMSRank</option>
                                    <option value="budgetsms" <?php echo ($sms->gatewayname=="budgetsms")?'Selected':'' ?> >BudgetSMS</option>
                                    <option value="infobip" <?php echo ($sms->gatewayname=="infobip")?'Selected':'' ?>>Infobip</option>
                                    <option value="nexmo" <?php echo ($sms->gatewayname=="nexmo")?'Selected':'' ?>>Nexmo</option>
                                </select>
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <label for="title" class="col-xs-3 col-form-label"><?php echo display('title') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="title" type="text" class="form-control" id="title" placeholder="<?php echo display('title') ?>" value="<?php echo html_escape($sms->title) ?>" required>
                            </div>
                        </div>
                        <span id="sms_field">
                            

                        </span>
                    <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                        <div>
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    <?php } }else{ ?>
                                <div>
                                    <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                                </div>
                                <?php echo form_close(); ?>
                    <?php } ?>

                        <div class="form-group row">
                            <div class="col-xs-12">
                            <br>
                            <br>
                                <p>For SMS Gateway Use <a href="http://www.smsrank.com/" target="_blank"><b>SMSRank</b></a>/<a href="https://www.budgetsms.net" target="_blank"><b>budgetsms</b></a>/<a href="https://www.infobip.com" target="_blank"><b>infobip</b></a>/<a href="https://www.nexmo.com" target="_blank"><b>nexmo</b></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-xs-12">
                                <h3 class="text-center">SMS TEST</h3>
                            </div>
                        </div>
                        <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                            <?php echo form_open_multipart("backend/setting/sms_gateway/test_sms") ?>
                        <?php } }else{ ?>
                                    <?php echo form_open_multipart("backend/setting/sms_gateway/test_sms") ?>
                        <?php } ?>
                        <div class="form-group row">
                            <label for="mobile_num" class="col-xs-3 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="mobile_num" id="mobile_num" placeholder="e. 88xxxxxxxx">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="test_message" class="col-xs-3 col-form-label">Message <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <textarea rows="5" class="form-control" name="test_message" id="test_message" placeholder="Test Message"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success"><?php echo display("send") ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>