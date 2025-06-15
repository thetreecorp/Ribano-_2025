<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 lobipanel-parent-sortable ui-sortable" data-lobipanel-child-inner-id="zvTmPK6RKK">
        <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable" data-inner-id="zvTmPK6RKK" data-index="0">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('transfer_list');?></h4>
                </div>
            </div>
            <div class="panel-body">
                <div class="border_preview">
                    <div class="table-responsive">
                        <table class="datatable2 table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo display('name');?></th>
                                    <th><?php echo display('type');?></th>
                                    <th><?php echo display('amount');?></th>
                                    <th><?php echo display('date');?></th>
                                    <th><?php echo display('mobile');?></th>
                                    <th><?php echo display('action');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($transfer!=NULL){ 
                                    $user_id = $this->session->userdata('user_id');
                                    foreach ($transfer as $key => $value) {  

                                ?>
                                <tr>
                                    <td><?php echo html_escape($value->first_name).' '.html_escape($value->last_name);?></td>
                                    <td><?php echo ($value->receiver_user_id==$user_id?'<b class="text-success">'.display('receive').'</b>':'<b class="text-danger">'.display('send').'</b>');?></td>
                                    <td><?php echo html_escape($value->amount);?></td>
                                    <td><?php echo html_escape($value->date);?></td>
                                    <td><?php echo html_escape($value->phone);?></td>
                                    <td>
                                        <a class="btn btn-success" href="<?php echo base_url()?>shareholder/transfer/<?php echo ($value->receiver_user_id==$user_id?'receive_details':'send_details');?>/<?php echo html_escape($value->transfer_id);?>"><?php echo display('details')?></a>
                                    </td>
                                </tr>
                                <?php } } ?>

                            </tbody>
                        </table>
                        <?php echo htmlspecialchars_decode($links); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>