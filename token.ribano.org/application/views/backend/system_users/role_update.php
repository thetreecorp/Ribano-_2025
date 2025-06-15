<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
            <?php if(!empty($userrole)){ if($userrole->edit_permission==1){ ?>
                <?php echo form_open_multipart("backend/system_users/add_role/role_update/$role->role_id") ?>
            <?php } }else{ ?>
                <?php echo form_open_multipart("backend/system_users/add_role/role_update/$role->role_id") ?>
            <?php } ?>    
                    <div class="form-group row">
                        <label for="role_new_name" class="col-sm-2 col-form-label"><?php echo display('role_name'); ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input name="role_new_name" class="form-control" type="text" id="role_new_name" value="<?php echo html_escape($role->role_name);?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role_new_name" class="col-sm-2 col-form-label"><?php echo display('role_permission'); ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('main_menu'); ?></th>
                                            <th class="text-center"><?php echo display('create'); ?></th>
                                            <th class="text-center"><?php echo display('read'); ?></th>
                                            <th class="text-center"><?php echo display('edit'); ?></th>
                                            <th class="text-center"><?php echo display('delete'); ?></th>
                                            <th class="text-center"><?php echo display('all'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($backend_main_menu as $key => $main_menu) { 
                                            $checkboxname = strtolower($main_menu->menu_name);
                                    ?>

                                    <?php if($main_menu->id==1 || $main_menu->id==10 || $main_menu->id==11){
	                                    	foreach ($role_permission as $key => $rolePer) {

	                                          	if($main_menu->id==$rolePer->main_menu_id){

	                                          		$create = $rolePer->create_permission==1?'checked':null;
	                                          		$read 	= $rolePer->read_permission==1?'checked':null;
	                                          		$edit 	= $rolePer->edit_permission==1?'checked':null;
	                                          		$delete = $rolePer->delete_permission==1?'checked':null;
	                                          		$all 	= $rolePer->all_permission==1?'checked':null;

	                                          		break;
	                                          	}
	                                        }
                                    ?>

                                            <tr>
                                                <td class="w-35"><?php echo html_escape($main_menu->menu_name); ?></td>
                                                <td class="text-center"><input type="checkbox" name="<?php echo html_escape($checkboxname); ?>_create" <?php echo html_escape($create); ?>></td>
                                                <td class="text-center"><input type="checkbox" name="<?php echo html_escape($checkboxname); ?>_read" <?php echo html_escape($read); ?>></td>
                                                <td class="text-center"><input type="checkbox" name="<?php echo html_escape($checkboxname); ?>_edit" <?php echo html_escape($edit); ?>></td>
                                                <td class="text-center"><input type="checkbox" name="<?php echo html_escape($checkboxname); ?>_delete" <?php echo html_escape($delete); ?>></td>
                                                <td class="text-center"><input  class="allcheck" type="checkbox" name="<?php echo html_escape($checkboxname); ?>_allcheck" <?php echo html_escape($all); ?>></td>
                                            </tr>

                                    <?php }else{ 

                                            if(strpos($main_menu->menu_name," ")){

                                                $checkboxclass = strtolower(str_replace(" ","_",$main_menu->menu_name));
                                            }else{

                                                $checkboxclass = strtolower($main_menu->menu_name);
                                            }
                                    ?>
                                            <tr>
                                                <td class="main_row" column_id="<?php echo html_escape($checkboxclass); ?>"><i id="<?php echo html_escape($checkboxclass); ?>_icon" class="fa fa-plus"></i> <?php echo html_escape($main_menu->menu_name); ?></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                        
                                        
                                    <?php foreach ($backend_sub_menu as $key => $sub_menu) { ?>

                                            <?php if($main_menu->id==$sub_menu->parent_id){

                                            		foreach ($role_permission as $key => $rolePer) {

			                                          	if($sub_menu->id==$rolePer->sub_menu_id){

			                                          		$create = $rolePer->create_permission==1?'checked':null;
			                                          		$read 	= $rolePer->read_permission==1?'checked':null;
			                                          		$edit 	= $rolePer->edit_permission==1?'checked':null;
			                                          		$delete = $rolePer->delete_permission==1?'checked':null;
			                                          		$all 	= $rolePer->all_permission==1?'checked':null;

			                                          		break;
			                                          	}
			                                        }

                                                        if(strpos($sub_menu->menu_name," ")){

                                                            $allcheckbox = strtolower(str_replace(" ","_",$sub_menu->menu_name));
                                                        }else{

                                                            $allcheckbox = strtolower($sub_menu->menu_name);
                                                        }
                                            ?>
                                                
                                                        <tr class="display-none  <?php echo html_escape($checkboxclass);?>_sub_role">
                                                            <td><span class="ml-20">-<?php echo html_escape($sub_menu->menu_name); ?></span></td>
                                                            <td class="text-center"><input type="checkbox" name="<?php echo html_escape($allcheckbox);?>_create" <?php echo html_escape($create); ?>></td>
                                                            <td class="text-center"><input type="checkbox" name="<?php echo html_escape($allcheckbox);?>_read" <?php echo html_escape($read); ?>></td>
                                                            <td class="text-center"><input type="checkbox" name="<?php echo html_escape($allcheckbox);?>_edit" <?php echo html_escape($edit); ?>></td>
                                                            <td class="text-center"><input type="checkbox" name="<?php echo html_escape($allcheckbox);?>_delete" <?php echo html_escape($delete); ?>></td>
                                                            <td class="text-center"><input class="allcheck" type="checkbox" name="<?php echo html_escape($allcheckbox);?>_allcheck" <?php echo html_escape($all); ?>></td>
                                                        </tr>

                                            <?php } ?>
	                                	<?php } ?>

	                                            

	                                <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            <?php if(!empty($userrole)){ if($userrole->edit_permission==1){ ?>
                    <div class="row">
                        <div class="col-sm-9 col-md-offset-2">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("update"); ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>

            <?php } }else{ ?>
                <div class="row">
                        <div class="col-sm-9 col-md-offset-2">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("update"); ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
                
            <?php } ?>

            </div>
        </div>
    </div>
</div>