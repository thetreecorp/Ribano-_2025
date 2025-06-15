<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_role extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();	
 		
 		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
 		
		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');
		
		$this->load->model(array(
 			'backend/dashboard/admin_model',
 			'common_model'  
 		));
 	}

	public function index()
	{
		$data['title'] 		= display('add_new_role');
		$data['userrole'] 	= $this->common_model->getMenuSingelRoleInfo(37);
		$data['role_main_menu'] = $this->admin_model->roleMainMenu();
		$data['role_sub_menu'] 	= $this->admin_model->roleSubMenu();

		$data['content'] = $this->load->view("backend/system_users/role_form", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	public function role()
	{
		$this->form_validation->set_rules('role_new_name',display('role_name'),'required|xss_clean');

		if($this->form_validation->run()){

			$data 	= $this->input->post();
			if(!empty($data)){
				$result = $this->admin_model->addRolePermission($data);
				if(!empty($result)){

					$this->session->set_flashdata('message',display('role_add_successfully'));
				}
				else{

					$this->session->set_flashdata('exception',display('role_created_failed'));
				}
			}
			else{
				$this->session->set_flashdata('exception',display('the_role_permission_field_is_required'));
			}
		}
		else{
			$this->session->set_flashdata('exception',validation_errors());
		}
		redirect(base_url('backend/system_users/add_role'));
	}

	public function role_list()
	{
		$data['title'] 	 = display('role_list');
		$data['userrole']= $this->common_model->getMenuSingelRoleInfo(37);
		$data['role']	 = $this->admin_model->getRole();
		$data['content'] = $this->load->view("backend/system_users/role_list", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	public function role_update($id="")
	{
		$data['title'] 			 = display('edit_role');
		$data['userrole'] 		 = $this->common_model->getMenuSingelRoleInfo(37);
		$data['role_main_menu']  = $this->admin_model->roleMainMenu();
		$data['role_sub_menu'] 	 = $this->admin_model->roleSubMenu();
		$data['role']			 = $this->admin_model->roleSingel($id);
		$data['role_permission'] = $this->admin_model->rolePermissionSingel($id);

		$this->form_validation->set_rules('role_new_name',display('role_name'),'required|xss_clean');

		if($this->form_validation->run()){

			$data 	= $this->input->post();
			if(!empty($data)){
				$result = $this->admin_model->updateRolePermission($data,$id);
				if(!empty($result)){

					$this->session->set_flashdata('message',display('role_update_successfully'));
				}
				else{

					$this->session->set_flashdata('exception',display('update_failed'));
				}
			}
			else{
				$this->session->set_flashdata('exception',display('the_role_permission_field_is_required'));
			}

			redirect(base_url("backend/system_users/add_role/role_update/$id"));
		}

		$data['content'] = $this->load->view("backend/system_users/role_update", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	public function role_delete($id="")
	{
		$this->db->where('role_id',$id)->delete('dbt_role');
		$this->db->where('role_id',$id)->delete('dbt_role_permission');
		$this->session->set_flashdata("exception",display('delete_successfully'));

		redirect(base_url("backend/system_users/add_role/role_list"));
	}


}