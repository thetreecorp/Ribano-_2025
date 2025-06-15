<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('confirm_withdraw');?></h4>
                </div>
            </div>
            <?php 
                $data = json_decode($v->data);
            ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="border_preview">
                        <?php   $att = array('name'=>'verify');
                         echo form_open('#',html_escape($att));
                        ?>
                        <?php echo form_hidden('confirm_id',html_escape($v->id)); ?>
                            <div class="table-responsive">
                                 
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th><?php echo display('amount');?></th>
                                            <td><?php echo html_escape($coininfo->pair_with)." ".html_escape($data->amount);?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('payment_method');?></th>
                                            <td><?php echo html_escape($data->method);?></td>
                                        </tr>
                                       
                                         <tr>
                                            <th><?php echo display('enter_verify_code');?></th>
                                            <td><input class="form-control" type="text" name="code" id="code"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-right">
                                <button type="button" id="confirm_withdraw_btn" class="btn btn-success w-md m-b-5"><?php echo display('confirm'); ?></button>
                                <button type="button" class="btn btn-danger w-md m-b-5"><?php echo display('cancel'); ?></button>
                            </div>
                            <?php echo form_close();?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>