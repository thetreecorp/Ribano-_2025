<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliation extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
 		
 		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
 		
		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');
		$this->load->model(array(
 			'backend/affiliation_model',
 			'common_model'
 		));
 	}
 
	public function index()
	{  
		$data['title']  = display('affiliation_setup');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(33);

		$this->form_validation->set_rules('commission', display('commission'),'max_length[100]|required|trim|xss_clean');
		$this->form_validation->set_rules('type', display('type'),'max_length[11]|required|trim|xss_clean');
		$this->form_validation->set_rules('status', display('status'),'max_length[1]|required|trim|xss_clean');

		$data['affiliation'] = (object)$userdata = array(
			'id' 		=> $this->input->post('id',TRUE),
			'commission'=> $this->input->post('commission',TRUE),
			'type' 		=> $this->input->post('type',TRUE),
			'status' 	=> $this->input->post('status',TRUE)
		);
 		

		if ($this->form_validation->run()) 
		{
			$commission = $this->input->post('commission',TRUE);

			if($commission<=0){
				$this->session->set_flashdata('exception', display('invalid_amount'));
                redirect("backend/setting/affiliation");
			}

			if ($this->affiliation_model->update($userdata)) {
				$this->session->set_flashdata('message', display('update_successfully'));
			} else {
				$this->session->set_flashdata('exception', display('please_try_again'));
			}
			redirect("backend/setting/affiliation");
		}

		$data['affiliation']   = $this->affiliation_model->single();


		$data['content'] = $this->load->view("backend/affiliation/affiliation", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);

	}


}
