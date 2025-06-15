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
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                <?php echo form_open_multipart("backend/sto_settings/sto_setup") ?>
            <?php } }else{ ?>
                <?php echo form_open_multipart("backend/sto_settings/sto_setup") ?>
            <?php } ?>
                    <div class="form-group row">
                        <label for="sto_name" class="col-sm-3 col-form-label"><?php echo display('name'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-6">
                            <input name="sto_name" class="form-control" value="<?php echo html_escape($sto_setup->name) ?>" type="text" id="sto_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sto_symbol" class="col-sm-3 col-form-label">Symbol<i class="text-danger">*</i></label>
                        <div class="col-sm-6">
                            <input name="sto_symbol" class="form-control"  value="<?php echo html_escape($sto_setup->symbol) ?>" type="text" id="sto_symbol">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pair_with" class="col-sm-3 col-form-label"><?php echo display('pair_with'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-6">
                            <select class="form-control basic-single" name="pair_with" id="pair_with">
                                <option value=""><?php echo display('select_option') ?></option>
                                <?php
                                    if($check_system_run>0){
                                ?>
                                        <option value="<?php echo html_escape($sto_setup->pair_with); ?>" selected><?php echo html_escape($sto_setup->pair_with); ?></option>

                                <?php } else{ foreach ($currency as $key => $value) { ?>
                                        <option <?php echo $sto_setup->pair_with==$value->symbol? "selected":null ?> value="<?php echo html_escape($value->symbol); ?>"><?php echo html_escape($value->symbol); ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display('submit')?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
            <?php } }else{ ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display('submit')?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
            <?php } ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="notice-board">
                                <p>Note: Please don't change pairing currency, when system (or Bussines) start. Change it before start Bussines.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="notice-board">
                                <p>Note: If you want to add multiple currency based deposit system, you will need to customize the payment system. or you can use the single currency. <br>contact-at: business@bdtask.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
