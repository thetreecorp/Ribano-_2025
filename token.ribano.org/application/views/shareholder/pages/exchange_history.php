<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">                
                <?php if (!empty($exchange)) { ?>
                <table class="table table-bordered table-hover font-size-12">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('exchange'); ?></th>
                            <th><?php echo display('source'); ?></th>
                            <th><?php echo display('crypto_qty'); ?></th>
                            <th><?php echo display('crypto_rate'); ?>(<?php echo html_escape($stoinfo->pair_with); ?>)</th>
                            <th><?php echo display('complete_qty'); ?></th>
                            <th><?php echo display('available_qty'); ?></th>
                            <th><?php echo display('date_time'); ?></th>
                            <th><?php echo display('status'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl=1;  foreach ($exchange as $key => $value) { ?>
                        <tr>
                            <td><?php echo html_escape($sl) ?></td>
                            <td><?php echo html_escape($value->exchange_type) ?></td>
                            <td><?php echo html_escape($value->source_wallet) ?></td>
                            <td><?php echo html_escape($value->crypto_qty) ?></td>
                            <td><?php echo html_escape($value->crypto_rate) ?></td>
                            <td><?php echo html_escape($value->complete_qty) ?></td>
                            <td><?php echo html_escape($value->available_qty) ?></td>
                            <td><?php echo html_escape($value->datetime) ?></td>
                            <td><?php echo $value->status==0?"<p class='btn btn-danger btn-xs'>Canceled</p>":($value->status==1?"<p class='btn btn-success btn-xs'>Completed</p>":"<p class='btn btn-primary btn-xs'>Running</p>") ?></td>
                        </tr>
                        <?php html_escape($sl++); } ?>                    
                    </tbody>
                </table>
                <?php  }else{ ?>
                    <center><h3 class="text-danger">No Data Available</h3></center>
                <?php } ?>

            </div> 
        </div>
    </div>
</div>