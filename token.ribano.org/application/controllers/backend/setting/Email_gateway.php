<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_gateway extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

		if (!$this->session->userdata('isLogIn') 
			&& !$this->session->userdata('isAdmin')
		) 
		redirect('admin'); 
		
		$this->load->model(array(
			'backend/dashboard/setting_model',
			'common_model'
		));
		
	}

	public function index()
	{
		$data['title'] = display('email_gateway');
		$data['email'] = $this->db->select('*')->from('email_sms_gateway')->where('es_id', 2)->get()->row();
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(30);
		$data['content'] = $this->load->view('backend/dashboard/email_gateway',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function update_email_gateway()
	{
		$email = $this->input->post('es_id',TRUE);
		
		$pass = '';
		$password = $this->db->select('password')->from('email_sms_gateway')->where('es_id', 2)->get()->row();
		
		if($password->password == base64_decode($this->input->post('email_password',TRUE))){
		   $pass = $password->password;
		   
		}else{
		    $pass = $this->input->post('email_password',TRUE);
		    
		}
		$data = array(
			'title' 	=>$this->input->post('email_title',TRUE),
			'protocol' 	=>$this->input->post('email_protocol',TRUE),
			'host' 		=>$this->input->post('email_host',TRUE),
			'port' 		=>$this->input->post('email_port',TRUE),
			'user' 		=>$this->input->post('email_user',TRUE),
			'password' 	=>$pass,
			'mailtype' 	=>$this->input->post('email_mailtype',TRUE),
			'charset' 	=>$this->input->post('email_charset',TRUE)
		);
			
		$this->db->where('es_id', $email)->update('email_sms_gateway',$data);
		
		$this->session->set_flashdata('message',display('update_successfully'));

		redirect('backend/setting/email_gateway');
	}

	public function test_email()
	{
		$this->form_validation->set_rules('email_to',display('email'),'required|valid_email|xss_clean');
		$this->form_validation->set_rules('email_sub',display('subject'),'required|xss_clean');
		$this->form_validation->set_rules('email_message',display('message'),'required|xss_clean');

		if($this->form_validation->run()){

			$post = array(
                'title'             => display('test_email_gateway'),
                'subject'           => $this->input->post('email_sub',TRUE),
                'to'                => $this->input->post('email_to',TRUE),
                'message'           => $this->input->post('email_message',TRUE),
            );

            if(@$this->common_model->send_email($post)){
            	$this->session->set_flashdata('message',display('email_send_successfully'));
            }
            else{
            	$this->session->set_flashdata('exception',display('email_not_configured_in_server'));
            }

		}
		else{
			$this->session->set_flashdata('exception',validation_errors());
		}

		redirect('backend/setting/email_gateway/');
	}


}