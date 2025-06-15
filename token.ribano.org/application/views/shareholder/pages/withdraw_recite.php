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
                            <strong><?php echo  html_escape($settings->title) ?></strong><br>
                            <?php echo html_escape($settings->description);?><br>
                            
                        </address>
                        
                    </div>
                    <div class="col-sm-6 text-right">
                        <h1 class="m-t-0">Withdraw No : <?php echo $this->uri->segment(4)?></h1>
                        <div><?php echo date('d-M-Y');?></div>
                        <address>
                            <strong><?php echo html_escape(html_escape($my_info->first_name)).' '.html_escape($my_info->first_name);?></strong><br>
                            <?php echo html_escape($my_info->email);?><br>
                            <?php echo html_escape($my_info->phone);?><br>
                            <abbr title="Phone"><?php echo display('account')?> :</abbr> <?php echo html_escape($my_info->user_id); ?>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
                    <table class="table table-border table-bordered ">
                        <thead>
                            <tr>
                                <th><?php echo display('payment_method')?></th>
                                <th><?php echo display('amount')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div><strong><?php echo html_escape($data->method);?></strong></div>
                                <td>$<?php echo html_escape($data->amount);?></td>
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