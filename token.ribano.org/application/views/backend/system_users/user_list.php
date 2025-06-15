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
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('role'); ?></th>
                                <th><?php echo display('image') ?></th>
                                <th><?php echo display('fullname') ?></th>
                                <th><?php echo display('email') ?></th>
                                <th><?php echo display('last_login') ?></th>
                                <th><?php echo display('ip_address') ?></th>
                                <th><?php echo display('status') ?></th>
                                <th><?php echo display('action') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($admin)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($admin as $value) { ?>
                            <tr>
                                <td><?php echo html_escape($sl++); ?></td>
                                <td><?php echo @$value->role_name?html_escape($value->role_name):($value->is_admin==1?display('admin'):display('sub_admin')); ?></td>
                                <td><img src="<?php echo base_url(!empty($value->image)?html_escape($value->image):'assets/images/icons/user.png'); ?>" alt="Image" height="64" ></td>
                                <td><?php echo html_escape($value->fullname); ?></td>
                                <td><?php echo html_escape($value->email); ?></td>
                                <td><?php echo html_escape($value->last_login); ?></td>
                                <td><?php echo html_escape($value->ip_address); ?></td>
                                <td><?php echo (($value->status==1)?display('active'):display('inactive')); ?></td>
                                <td>
                                    <?php if ($value->is_admin == 1) { ?>
                                    <button class="btn btn-info btn-sm" title="<?php echo display('admin') ?>"><?php echo display('admin') ?></button>
                                    <?php } else { ?>
                                                <button class="btn btn-info btn-sm" title="<?php echo display('sub_admin') ?>"><?php echo display('sub_admin') ?></button> <br><br>
                                    <?php if(!empty($userrole)){ if($userrole->edit_permission==1){ ?>
                                                
                                                <a href="<?php echo base_url("backend/system_users/add_user/index/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <?php }if($userrole->delete_permission==1){ ?>
                                                <a href="<?php echo base_url("backend/system_users/user_list/delete/$value->id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php } }else{ ?>

                                                <a href="<?php echo base_url("backend/system_users/add_user/index/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a href="<?php echo base_url("backend/system_users/user_list/delete/$value->id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php } ?>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>

 