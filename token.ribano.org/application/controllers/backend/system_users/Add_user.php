<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_user extends CI_Controller {
 	
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

 	public function index($id = null)
	{ 
		$data['title']    = display('add_admin');
		$data['userrole'] 	= $this->common_model->getMenuSingelRoleInfo(7);
		$data['role']	  = $this->db->select('*')->from('dbt_role')->get()->result();
		/*-----------------------------------*/
		$this->form_validation->set_rules('firstname', display('firstname'),'required|max_length[50]|xss_clean');
		$this->form_validation->set_rules('lastname', display('lastname'),'required|max_length[50]|xss_clean');
		#------------------------#
		if (!empty($id)) {   
       		$this->form_validation->set_rules('email', display('email'), "required|valid_email|max_length[100]|xss_clean"); 
		} else {
			$this->form_validation->set_rules('email', display('email'),'required|valid_email|is_unique[admin.email]|max_length[100]|xss_clean');
		}
		#------------------------#
		$this->form_validation->set_rules('password', display('password'),'required|max_length[32]|md5|xss_clean');
		$this->form_validation->set_rules('about', display('about'),'max_length[1000]|xss_clean');
		$this->form_validation->set_rules('status', display('status'),'required|max_length[1]|xss_clean');
		/*-----------------------------------*/
 		$image = $this->upload_lib->do_upload(
			'upload/dashboard/',
			'image'
		);
		// if image is uploaded then resize the image
		if ($image !== false && $image != null) {
			$this->upload_lib->do_resize(
				$image, 
				115,
				90
			);
		}
		/*-----------------------------------*/
		
		$data['admin'] = (object)$adminLevelData = array(
			'id' 		  => $this->input->post('id',TRUE),
			'firstname'   => $this->input->post('firstname',TRUE),
			'lastname' 	  => $this->input->post('lastname',TRUE),
			'email' 	  => $this->input->post('email',TRUE),
			'password' 	  => md5($this->input->post('password',TRUE)),
			'about' 	  => $this->input->post('about',true),
			'image'   	  => (!empty($image)?$image:$this->input->post('old_image',TRUE)),
			'last_login'  => null,
			'last_logout' => null,
			'ip_address'  => null,
			'status'      => $this->input->post('status',TRUE),
			'is_admin'    => 2,
			'role_id'     => $this->input->post('role',TRUE),
		);

		/*-----------------------------------*/
		if ($this->form_validation->run()) 
		{

	        if (empty($adminLevelData['image']) && $this->session->flashdata('exception') == null) {
				$this->session->set_flashdata('exception', display('you_did_not_upload_any_file'));
	        }

			if (empty($adminLevelData['id'])) {
				if ($this->admin_model->create($adminLevelData)) {
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect("backend/system_users/add_user/index");

			} else {
				if ($this->admin_model->update($adminLevelData)) {
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect("backend/system_users/add_user/index/$id");
			}
		} 
		else 
		{ 
			if(!empty($id)) {
				$data['title'] = display('edit_admin');
				$data['admin']   = $this->admin_model->single($id);
			}
			$data['content'] = $this->load->view("backend/system_users/add_user", $data, true);
			$this->load->view("backend/layout/main_wrapper", $data);
		}
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

}