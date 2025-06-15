<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('my_payout');?></h4>
                </div>
            </div>
            
            <div class="panel-body">
                <?php if($my_payout){ ?>
                    <div class="border_preview">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered table-hover">
                                
                                <thead>
                                    <tr>
                                        <th><?php echo display('date');?></th>
                                        <th><?php echo display('amount');?> (<?php echo html_escape($stoinfo->pair_with); ?>)</th>
                                        <th><?php echo display('action');?></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                        foreach ($my_payout as $key => $value) {
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo html_escape($value->date);?></td>
                                        <td><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->amount);?></td>
                                        <td><a href="<?php echo base_url()?>shareholder/package/payout_receipt/<?php echo html_escape($value->earning_id);?>" class="btn btn-success btn-xs"><?php echo display('view')?></a></td>
                                    </tr>

                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                            <?php echo htmlspecialchars_decode($links); ?>
                        </div>
                    </div>
                <?php }else{ ?>
                    <center><h3 class="text-danger">No Data Available</h3></center>
                <?php } ?>
            </div>
        </div>
    </div>
</div>