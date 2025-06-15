<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_list extends CI_Controller {
 	
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
		$data['title']      = display('admin_list');
		$data['userrole'] 	= $this->common_model->getMenuSingelRoleInfo(8);
		$data['admin'] 		= $this->admin_model->read();
		$data['content'] 	= $this->load->view("backend/system_users/user_list", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}
 

    public function email_check($email, $id)
    { 
        $emailExists = $this->db->select('email')
            ->where('email',$email) 
            ->where_not_in('id',$id) 
            ->get('admin')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} is already registered.');
            return false;
        } else {
            return true;
        }
    }

	public function delete($id = null)
	{ 
		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

		if ($this->admin_model->delete($id)) {
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect("backend/system_users/user_list");
	}


}