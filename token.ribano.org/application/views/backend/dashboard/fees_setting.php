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
                        <?php echo form_open_multipart("backend/setting/fees_setting/fees_setting_save") ?>
            <?php } }else{ ?>
                        <?php echo form_open_multipart("backend/setting/fees_setting/fees_setting_save") ?>
            <?php } ?>
                    <div class="row">                     
                        <div class="form-group col-lg-4">
                            <label><?php echo display("select_level") ?> <span class="text-danger">*</span></label>
                            <div class="">
                               <select class="form-control" name="level" required >
                                   <option value="">--<?php echo display("select_level") ?>--</option>
                                   <option value="BUY"><?php echo display("buy") ?></option>
                                   <option value="SELL"><?php echo display("sell") ?></option>
                                   <option value="DEPOSIT"><?php echo display("deposit") ?></option>
                                   <option value="TRANSFER"><?php echo display("transfer") ?></option>
                                   <option value="WITHDRAW"><?php echo display("withdraw") ?></option>
                               </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Fees% <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="fees" required >
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
                                    <th><?php echo display('Level');?></th>
                                    <th><?php echo display('fees');?></th>
                                   <th><?php echo display('action');?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if(isset($fees_data)){ 
                                    foreach ($fees_data as $key => $value) {  
                                ?>
                                <tr>
                                    <td><?php echo html_escape($value->level);?></td>
                                    <td class="text-right"><?php echo html_escape($value->fees);?>%</td>
                                    <td>
                                    <?php if(!empty($userrole)){ if($userrole->delete_permission==1){ ?>
                                        <a href="<?php echo base_url('backend/setting/fees_setting/delete_fees_setting/'.html_escape($value->id)) ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php } }else{ ?>
                                        <a href="<?php echo base_url('backend/setting/fees_setting/delete_fees_setting/'.html_escape($value->id)) ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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