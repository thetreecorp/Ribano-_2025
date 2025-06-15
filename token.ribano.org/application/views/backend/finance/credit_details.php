
<?php
$settings = $this->db->select("*")
    ->get('setting')
    ->row();

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">
            <div class="panel-body" id="printableArea">
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
                        <h1 class="m-t-0"><?php echo display('credit_no'); ?> : <?php echo $this->uri->segment(5)?></h1>
                        <div><?php echo date('d-M-Y');?></div>
                        <address>
                            <strong><?php echo html_escape(@$credit_info->first_name).' '.html_escape(@$credit_info->last_name);?></strong><br>
                            <?php echo html_escape(@$credit_info->email);?><br>
                            <?php echo html_escape(@$credit_info->phone);?><br>
                            <abbr title="Phone"><?php echo display('account')?> :</abbr> <?php echo html_escape(@$credit_info->user_id);?>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
                    <table class="table table-border table-bordered ">
                        <thead>
                            <tr>
                                <th><?php echo display('user_id')?></th>
                                <th><?php echo display('amount')?></th>
                                <th><?php echo display('date')?></th>
                                <th><?php echo display('comments')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div><strong><?php echo html_escape(@$credit_info->user_id);?></strong></div>
                                <td><?php echo html_escape($coininfo->pair_with); ?> <?php echo html_escape(@$credit_info->amount);?></td>
                                <td><?php echo html_escape(@$credit_info->deposit_date);?></td>
                                <td><?php echo html_escape(@$credit_info->comment);?></td>
                            </tr>
                           
                        </tbody>
                    </table>
                    <?php 
                        if (!@$credit_info->user_id) {
                            echo "<h1 class='text-danger'>User Not Found !!!</h1>";
                        }  
                    ?>                 
                </div>
            </div>

            <div class="panel-footer text-right">
               <button type="button" class="btn btn-info print"><span class="fa fa-print"></span></button>
            </div>
        </div>
    </div>
</div>