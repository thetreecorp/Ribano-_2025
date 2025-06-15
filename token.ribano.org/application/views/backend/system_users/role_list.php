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
                    <table class="datatable2 table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo display('role_id'); ?></th>
                                <th><?php echo display('role_name'); ?></th>
                                <th><?php echo display('date'); ?></th>
                                <th><?php echo display('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php if(!empty($role)){?>
                        		<?php foreach($role as $key => $value){?>

                        			<tr>
		                            	<td><?php echo html_escape($value->role_id); ?></td>
		                            	<td><?php echo html_escape($value->role_name); ?></td>
		                            	<td><?php echo html_escape($value->date); ?></td>
		                            	<td>
                                        <?php if(!empty($userrole)){ if($userrole->edit_permission==1){ ?>
                                            <a href="<?php echo base_url("backend/system_users/add_role/role_update/$value->role_id"); ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-id="left" title="" data-original-title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <?php }if($userrole->delete_permission==1){ ?>
                                            <a href="<?php echo base_url("backend/system_users/add_role/role_delete/$value->role_id"); ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-id="left" title="" data-original-title="Delete"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                        <?php } }else{ ?>
                                                    <a href="<?php echo base_url("backend/system_users/add_role/role_update/$value->role_id"); ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-id="left" title="" data-original-title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                    <a href="<?php echo base_url("backend/system_users/add_role/role_delete/$value->role_id"); ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-id="left" title="" data-original-title="Delete"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                        <?php } ?>
                                        </td>
		                            </tr>

                        	<?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>

 