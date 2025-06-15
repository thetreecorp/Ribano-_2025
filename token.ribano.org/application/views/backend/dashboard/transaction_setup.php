<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="border_preview">
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                        <?php echo form_open_multipart("backend/setting/transaction_setup/transaction_setup_save") ?>
            <?php } }else{ ?>
                        <?php echo form_open_multipart("backend/setting/transaction_setup/transaction_setup_save") ?>
            <?php } ?>
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label><?php echo display('transaction_type'); ?> <i class="text-danger">*</i></label>
                           <select class="form-control" name="trntype" required >
                               <option value="">--<?php echo display("select_option") ?>--</option>
                               <option value="WITHDRAW"><?php echo display('withdraw'); ?></option>
                               <option value="TRANSFER"><?php echo display('transfer'); ?></option>
                           </select>
                        </div>                      
                    </div>
                    <div class="row">                    
                        <div class="form-group col-lg-6">
                            <label><?php echo display('account_type'); ?> <i class="text-danger">*</i></label>
                           <select class="form-control" name="acctype" required >
                               <option value="">--<?php echo display("select_option") ?>--</option>
                               <option value="VERIFIED"><?php echo display('verified'); ?></option>
                               <option value="UNVERIFIED"><?php echo display('unverified'); ?></option>
                           </select>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label><?php echo display('limit_amount'); ?>(Weekly) <i class="text-danger">*</i></label>
                            <input type="number" class="form-control" name="upper" required >
                        </div>
                    </div>
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div>
                        <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                    </div>
                <?php echo form_close() ?>
            <?php } }else{ ?>
                        <div>
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                            <?php echo form_close() ?>
            <?php } ?>
                    
            </div>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " >
        <div class="panel panel-bd">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('setting');?></h4>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        
                        <thead>
                            <tr>
                                <th><?php echo display('transaction_type'); ?></th>
                                <th><?php echo display('account_type'); ?></th>
                                <th class="text-right"><?php echo display('weekly_limit'); ?></th>
                                <th class="text-right"><?php echo display('monthly_limit'); ?></th>
                                <th class="text-right"><?php echo display('yearly_limit'); ?></th>
                               <th><?php echo display('action');?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($transaction_setup)){ 
                                foreach ($transaction_setup as $key => $value) {  
                            ?>
                            <tr>
                                <td><?php echo html_escape($value->trntype);?></td>
                                <td><?php echo html_escape($value->acctype);?></td>
                                <td class="text-right"><?php echo html_escape($value->upper)*1;?></td>
                                <td class="text-right"><?php echo html_escape($value->upper)*4.33;?></td>
                                <td class="text-right"><?php echo html_escape($value->upper)*52;?></td>
                                <td>
                                    
                                <?php if(!empty($userrole)){ if($userrole->delete_permission==1){ ?>
                                        <a href="<?php echo base_url('backend/setting/transaction_setup/delete_transaction_setup/'.html_escape($value->id)) ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>  
                                <?php } }else{ ?>
                                        <a href="<?php echo base_url('backend/setting/transaction_setup/delete_transaction_setup/'.html_escape($value->id)) ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php } ?>

                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

 