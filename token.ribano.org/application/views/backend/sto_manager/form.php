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
                        <?php echo form_open_multipart("backend/sto_settings/sto_manager/index/".html_escape(@$sto_manager->id)) ?>
                    <?php } }else{ ?>
                        <?php echo form_open_multipart("backend/sto_settings/sto_manager/index/".html_escape(@$sto_manager->id)) ?>
                    <?php } ?>
                <?php echo form_hidden('id', html_escape(@$sto_manager->id)) ?> 

                    <div class="form-group row">
                        <label for="total_sto" class="col-sm-4 col-form-label"><?php echo display('total_sto')?></label>
                        <div class="col-sm-8">
                            <input name="total_sto" value="0" class="form-control" type="text" id="total_sto" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="secured_sto" class="col-sm-4 col-form-label"><?php echo display('secured_sto')?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input name="secured_sto" value="<?php echo html_escape(@$sto_manager->secured) ?>" class="form-control sto" placeholder="15000" type="number" id="secured_sto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="non_secured_sto" class="col-sm-4 col-form-label"><?php echo display('non_secured_sto')?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input name="non_secured_sto" value="<?php echo html_escape(@$sto_manager->non_secured) ?>" class="form-control sto" placeholder="15000" type="number" id="non_secured_sto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="guaranteed_sto" class="col-sm-4 col-form-label"><?php echo display('guaranteed_sto')?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input name="guaranteed_sto" value="<?php echo html_escape(@$sto_manager->guaranteed) ?>" class="form-control sto" placeholder="15000" type="number" id="guaranteed_sto">
                        </div>
                    </div>
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo @$sto_manager->id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
            <?php } }else{ ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo @$sto_manager->id?display("update"):display("create") ?></button>
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