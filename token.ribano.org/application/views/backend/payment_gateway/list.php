<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable2 table table-bordered table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('gateway_name') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($payment_gateway)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($payment_gateway as $value) { ?>
                        <tr>
                            <td><?php echo html_escape($sl++); ?></td> 
                            <td><?php echo html_escape($value->agent); ?></td>
                            <td><?php echo (($value->status==1)?display('active'):display('inactive')); ?></td>
                            <td>
                            <?php if(!empty($userrole)){ if($userrole->edit_permission==1){ ?>
                                        <a href="<?php echo base_url("backend/setting/payment_gateway/form/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo display('setup'); ?></a>
                             <?php } }else{ ?>
                                        <a href="<?php echo base_url("backend/setting/payment_gateway/form/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo display('setup'); ?></a>
                            <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo htmlspecialchars_decode($links); ?>
            </div> 
        </div>
    </div>
</div>