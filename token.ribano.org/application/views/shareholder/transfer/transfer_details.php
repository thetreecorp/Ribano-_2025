<?php
$settings = $this->db->select("*")
    ->get('setting')
    ->row();

    $data = json_decode($v->data);
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
                        <h1 class="m-t-0"><?php echo display('transfer_no'); ?> : <?php echo $this->uri->segment(4)?></h1>
                        <div><?php echo date('d-M-Y');?></div>
                        <address>
                            <strong><?php echo html_escape($my_info->first_name).' '.html_escape($my_info->last_name);?></strong><br>
                            <?php echo html_escape($my_info->email);?><br>
                            <?php echo html_escape($my_info->phone);?><br>
                            <abbr title="Phone"><?php echo display('account'); ?> :</abbr> <?php echo html_escape($my_info->user_id);?>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th><?php echo display('receiver_name')?></th>
                                <td><?php echo html_escape($u->first_name).' '. html_escape($u->last_name);?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('email');?></th>
                                <td><?php echo html_escape($u->email);?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('user_id');?></th>
                                <td><?php echo html_escape($u->user_id);?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('transfer_amount');?></th>
                                <td><?php echo html_escape($coininfo->pair_with)." ".html_escape($data->amount);?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('fees');?></th>
                                <td><?php echo html_escape($coininfo->pair_with)." ".html_escape($data->fees);?></td>
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
