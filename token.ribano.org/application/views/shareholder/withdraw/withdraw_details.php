<?php
$settings = $this->db->select("*")
    ->get('setting')
    ->row();
        

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">
            <div class="panel-body"  id="printableArea">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo base_url(!empty($settings->logo)?html_escape($settings->logo):"assets/images/icons/logo.png"); ?>" class="img-responsive" alt="">
                        <br>
                        <address>
                            <strong><?php echo html_escape($settings->title) ?></strong><br>
                            <?php echo html_escape($settings->description);?><br>
                            
                        </address>
                        
                    </div>
                    <div class="col-sm-6 text-right">
                        <h1 class="m-t-0"><?php echo display('withdraw_no'); ?> : <?php echo $this->uri->segment(4)?></h1>
                        <div><?php echo html_escape($withdraw->request_date);?></div>
                        <address>
                            <strong><?php echo html_escape($my_info->first_name).' '.html_escape($my_info->last_name);?></strong><br>
                            <?php echo html_escape($my_info->email);?><br>
                            <?php echo html_escape($my_info->phone);?><br>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
                    <table class="table table-border table-bordered ">
                        <thead>
                            <tr>
                                <th><?php echo display('payment_method')?></th>
                                <th><?php echo display('wallet_id')?></th>
                                <th><?php echo display('amount')?></th>
                                <th><?php echo display('status')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div><strong><?php echo html_escape($withdraw->method);?></strong></div>
                                <td><?php echo html_escape($withdraw->wallet_id);?></td>
                                <td><?php echo html_escape($coininfo->pair_with)." ".html_escape($withdraw->amount);?></td>
                                <td>
                                    <?php 
                                        if($withdraw->status==0){
                                            echo ('<b class="text-danger">'.display('cancel').'</b>');
                                        }else if($withdraw->status==1){
                                            echo ('<b class="text-success">'.display('success').'</b>');
                                        }else if($withdraw->status==2){
                                            echo ('<b class="text-warning">'.display('pending').'</b>');
                                        }
                                        ?>
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-footer text-right">
               <button type="button" class="btn btn-info print"><span class="fa fa-print"></span></button>
            </div>
        </div>
    </div>
</div>