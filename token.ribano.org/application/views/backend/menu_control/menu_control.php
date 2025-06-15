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
                            <?php echo form_open_multipart("backend/sto_settings/menu_control/save") ?>
                <?php } }else{ ?>
                            <?php echo form_open_multipart("backend/sto_settings/menu_control/save") ?>
                <?php } ?>
                    
                    <div class="col-md-8 col-md-offset-2">
                        <fieldset>
                            <legend> <?php echo display('menu_control_settings'); ?> </legend>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox1" type="checkbox" name="isto" <?php echo $control->isto==1?"checked":""; ?>>
                                <label for="checkbox1"><?php echo display('isto'); ?></label>
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="exchange" <?php echo $control->exchange==1?"checked":""; ?>>
                                <label for="checkbox2"><?php echo display('exchange'); ?></label>
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox3" type="checkbox" name="package"  <?php echo $control->package==1?"checked":""; ?>>
                                <label for="checkbox3"><?php echo display('package'); ?></label>
                            </div>
                        </fieldset>
                    </div>
                <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div class="col-md-8 col-md-offset-5">
                        <div class="mt-20">
                        <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                <?php } }else{ ?>
                        <div class="col-md-8 col-md-offset-5">
                            <div class="mt-20">
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                            </div>
                        </div>
                <?php } ?>
                </div> 
            </div>
        </div>
    </div>
</div>




 