<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('admin', $data);
	}

	public function read()
	{
		return $this->db->select("
				admin.*, 
				CONCAT_WS(' ', firstname, lastname) AS fullname,dbt_role.role_name 
			")
			->from('admin')
			->join('dbt_role','admin.role_id=dbt_role.role_id','left')
			->order_by('id', 'desc')
			->get()
			->result();
	}

	public function single($id = null)
	{
		return $this->db->select('*')
			->from('admin')
			->where('id', $id)
			->get()
			->row();
	}

	public function update($data = array())
	{
		return $this->db->where('id', $data["id"])
			->where_not_in('is_admin',1)
			->update("admin", $data);
	}

	public function delete($id = null)
	{
		return $this->db->where('id', $id)
			->where_not_in('is_admin',1)
			->delete("admin");
	}

	public function dropdown()
	{
		$data = $this->db->select("id, CONCAT_WS(' ', firstname, lastname) AS fullname")
			->from("admin")
			->where('status', 1)
			->where_not_in('is_admin', 1)
			->get()
			->result();
		$list[''] = display('select_option');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->id] = $value->fullname;
			return $list;
		} else {
			return false; 
		}
	}

	public function addRolePermission($data =array())
	{
		$role_main_menu 	= $this->db->select('*')->from('dbt_main_menu')->get()->result();
		$role_sub_menu 		= $this->db->select('*')->from('dbt_sub_menu')->get()->result();
		$role_new_name 		= $data['role_new_name'];

		$this->db->insert('dbt_role',array('role_name'=>$role_new_name,'date'=>date('Y-m-d H:i:s')));
		$roleId = $this->db->insert_id();

		foreach($role_main_menu as $key => $main_menu){

			$mainmenuId = $main_menu->id;
			if(strpos($main_menu->menu_name," ")){
                $mainmenuAttr = strtolower(str_replace(" ","_",$main_menu->menu_name));
            }else{
                $mainmenuAttr = strtolower($main_menu->menu_name);
            }

            if($mainmenuId==1 || $mainmenuId==10 || $mainmenuId==11){

            	$all = @$data[$mainmenuAttr.'_allcheck']?1:0;

				if($all == 1){

					$create = 1;
					$read 	= 1;
					$edit 	= 1;
					$delete = 1;
				}
				else{

					$create = @$data[$mainmenuAttr.'_create']?1:0;;
					$read 	= @$data[$mainmenuAttr.'_read']?1:0;;
					$edit 	= @$data[$mainmenuAttr.'_edit']?1:0;;
					$delete = @$data[$mainmenuAttr.'_delete']?1:0;;
				}

				$insertdata = array(

					'role_id'=>$roleId,
					'main_menu_id'=>$mainmenuId,
					'create_permission'=>$create,
					'read_permission'=>$read,
					'edit_permission'=>$edit,
					'delete_permission'=>$delete,
					'all_permission'=>$all
				);

				$this->db->insert('dbt_role_permission',$insertdata);
            }
            else{

            	foreach ($role_sub_menu as $key => $sub_menu) {

					if($main_menu->id==$sub_menu->parent_id){

						$submenuId = $sub_menu->id;

						if(strpos($sub_menu->menu_name," ")){
	                        $submenuAttr = strtolower(str_replace(" ","_",$sub_menu->menu_name));
	                    }else{
	                        $submenuAttr = strtolower($sub_menu->menu_name);
	                    }

						$all = @$data[$submenuAttr.'_allcheck']?1:0;

						if($all == 1){

							$create = 1;
							$read 	= 1;
							$edit 	= 1;
							$delete = 1;
						}
						else{

							$create = @$data[$submenuAttr.'_create']?1:0;;
							$read 	= @$data[$submenuAttr.'_read']?1:0;;
							$edit 	= @$data[$submenuAttr.'_edit']?1:0;;
							$delete = @$data[$submenuAttr.'_delete']?1:0;;
						}

						$insertdata = array(

							'role_id'=>$roleId,
							'main_menu_id'=>$mainmenuId,
							'sub_menu_id'=>$submenuId,
							'create_permission'=>$create,
							'read_permission'=>$read,
							'edit_permission'=>$edit,
							'delete_permission'=>$delete,
							'all_permission'=>$all
						);

						$this->db->insert('dbt_role_permission',$insertdata);

					}		
				}
            }

		}
		return $this->db->insert_id();
	}

	public function updateRolePermission($data =array(),$id="")
	{
		$role_main_menu 	= $this->db->select('*')->from('dbt_main_menu')->get()->result();
		$role_sub_menu 		= $this->db->select('*')->from('dbt_sub_menu')->get()->result();
		$role_new_name 		= $data['role_new_name'];

		$this->db->where('role_id',$id)->update('dbt_role',array('role_name'=>$role_new_name,'date'=>date('Y-m-d H:i:s')));
		$roleId = $id;

		foreach($role_main_menu as $key => $main_menu){

			$mainmenuId = $main_menu->id;
			if(strpos($main_menu->menu_name," ")){
                $mainmenuAttr = strtolower(str_replace(" ","_",$main_menu->menu_name));
            }else{
                $mainmenuAttr = strtolower($main_menu->menu_name);
            }

            if($mainmenuId==1 || $mainmenuId==10 || $mainmenuId==11){

            	$all = @$data[$mainmenuAttr.'_allcheck']?1:0;

				if($all == 1){

					$create = 1;
					$read 	= 1;
					$edit 	= 1;
					$delete = 1;
				}
				else{

					$create = @$data[$mainmenuAttr.'_create']?1:0;;
					$read 	= @$data[$mainmenuAttr.'_read']?1:0;;
					$edit 	= @$data[$mainmenuAttr.'_edit']?1:0;;
					$delete = @$data[$mainmenuAttr.'_delete']?1:0;;
				}

				$updatedata = array(

					'create_permission'=>$create,
					'read_permission'=>$read,
					'edit_permission'=>$edit,
					'delete_permission'=>$delete,
					'all_permission'=>$all
				);

				$this->db->where('role_id',$roleId)->where('main_menu_id',$mainmenuId)->update('dbt_role_permission',$updatedata);
            }
            else{

            	foreach ($role_sub_menu as $key => $sub_menu) {

					if($main_menu->id==$sub_menu->parent_id){

						$submenuId = $sub_menu->id;

						if(strpos($sub_menu->menu_name," ")){
	                        $submenuAttr = strtolower(str_replace(" ","_",$sub_menu->menu_name));
	                    }else{
	                        $submenuAttr = strtolower($sub_menu->menu_name);
	                    }

						$all = @$data[$submenuAttr.'_allcheck']?1:0;

						if($all == 1){

							$create = 1;
							$read 	= 1;
							$edit 	= 1;
							$delete = 1;
						}
						else{

							$create = @$data[$submenuAttr.'_create']?1:0;;
							$read 	= @$data[$submenuAttr.'_read']?1:0;;
							$edit 	= @$data[$submenuAttr.'_edit']?1:0;;
							$delete = @$data[$submenuAttr.'_delete']?1:0;;
						}

						$updatedata = array(
							
							'create_permission'=>$create,
							'read_permission'=>$read,
							'edit_permission'=>$edit,
							'delete_permission'=>$delete,
							'all_permission'=>$all
						);

						$this->db->where('role_id',$roleId)
							->where('main_menu_id',$mainmenuId)
							->where('sub_menu_id',$submenuId)
							->update('dbt_role_permission',$updatedata);

					}		
				}
            }

		}
		return $roleId;
	}

	public function getRole()
	{
		return $this->db->select('*')->from('dbt_role')->get()->result();
	}

	public function roleMainMenu()
	{
		return $this->db->select('*')
		        ->from('dbt_main_menu')
		        ->get()
		        ->result();
	}

	public function roleSubMenu()
	{
		return $this->db->select('*')
		        ->from('dbt_sub_menu')
		        ->get()
		        ->result();
	}

	public function roleSingel($id="")
	{
		return $this->db->select('*')
				->from('dbt_role')
				->where('role_id',$id)
				->get()
				->row();
	}

	public function rolePermissionSingel($id="")
	{
		return $this->db->select('*')
				->from('dbt_role_permission')
				->where('role_id',$id)
				->get()
				->result();
	}
 


}
