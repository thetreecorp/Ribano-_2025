<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
 
                <div class="">
                    <table id="ajaxtable" class="datatable2 table table-bordered table-hover">
                        <thead>
                            <tr> 
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('user_id') ?></th>
                                <th><?php echo display('fullname') ?></th>
                                <th><?php echo display('email') ?></th>
                                <th><?php echo display('mobile') ?></th>
                                <th><?php echo display('action') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; foreach ($users as $key => $value) { ?>
                             <tr>
                                 <td><?php echo html_escape($i++); ?></td>
                                 <td><?php echo html_escape($value->user_id) ?></td>
                                 <td><?php echo html_escape($value->first_name)." ".html_escape($value->last_name) ?></td>
                                 <td><?php echo html_escape($value->email) ?></td>
                                 <td><?php echo html_escape($value->phone) ?></td>
                                 <td>
                                <?php if(!empty($userrole)){ if($userrole->edit_permission==1){ ?>
                                    <a href="<?php echo base_url("backend/shareholders/shareholder/pending_user_verification/$value->user_id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-id="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                <?php } }else{ ?>
                                    <a href="<?php echo base_url("backend/shareholders/shareholder/pending_user_verification/$value->user_id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-id="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
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
</div>