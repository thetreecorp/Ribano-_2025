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
                <?php echo form_open('backend/finance/add_credit/send_credit','class="form-inner"') ?>
        <?php } }else{ ?>
                <?php echo form_open('backend/finance/add_credit/send_credit','class="form-inner"') ?>
        <?php } ?>

                    <div class="row">
                        <div class="col-xs-7 col-md-offset-2">

                            <div class="form-group row">
                                <label for="user_id" class="col-xs-3 col-form-label"><?php echo display('user_id') ?> <span class="text-danger">*</span></label>
                                <div class="col-xs-9">
                                    <input name="user_id"  type="text" class="form-control" id="user_id" placeholder="<?php echo display('user_id') ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-xs-3 col-form-label"><?php echo display('amount') ?>(<?php echo html_escape($coininfo->pair_with); ?>) <span class="text-danger">*</span></label>
                                <div class="col-xs-9">
                                    <input name="amount" type="text" class="form-control" id="amount" placeholder="<?php echo display('amount') ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="notes" class="col-xs-3 col-form-label"><?php echo display('notes') ?> <span class="text-danger">*</span></label>
                                <div class="col-xs-9">
                                    <textarea name="note" class="form-control" placeholder="<?php echo display('notes') ?>"  rows="4" required></textarea>
                                </div>
                            </div>  
                            
                <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                            <div class="form-group  text-right">
                                <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('send') ?></button>
                            </div>
                <?php } }else{ ?>
                            <div class="form-group  text-right">
                                <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('send') ?></button>
                            </div>
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