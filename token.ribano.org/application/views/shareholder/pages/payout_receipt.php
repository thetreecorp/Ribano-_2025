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
                        <h1 class="m-t-0">Payout No : <?php echo $this->uri->segment(4)?></h1>
                        <div><?php echo date('d-M-Y');?></div>
                        <address>
                            <strong><?php echo html_escape($my_info->first_name).' '.html_escape($my_info->last_name);?></strong><br>
                            <?php echo html_escape($my_info->email);?><br>
                            <?php echo html_escape($my_info->phone);?><br>
                            <abbr title="Phone">Account :</abbr> <?php echo html_escape($my_info->user_id);?>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
                    <table class="table table-border table-bordered ">
                        <thead>
                            <tr>
                                <th><?php echo display('package_name')?></th>
                                <th><?php echo display('details')?></th>
                                <th><?php echo display('amount')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo html_escape($my_payout->package_name);?></td>
                                <td><div><strong><?php echo html_escape($my_payout->package_deatils);?></strong></div>
                                <td><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($my_payout->amount);?></td>
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