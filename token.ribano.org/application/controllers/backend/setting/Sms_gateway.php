<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_gateway extends CI_Controller {

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
		$data['title'] = display('sms_gateway');
		$data['sms'] = $this->db->select('*')->from('email_sms_gateway')->where('es_id', 1)->get()->row();
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(30);
		$data['content'] = $this->load->view('backend/dashboard/sms_gateway',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function update_sms_gateway()
	{
		$sms = $this->input->post('es_id',TRUE);
		
		$pass = '';
		$password = $this->db->select('password')->from('email_sms_gateway')->where('es_id', 2)->get()->row();
		
		if($password->password == base64_decode($this->input->post('password',TRUE))){
		   $pass = $password->password;
		   
		}else{
		    $pass = $this->input->post('password',TRUE);
		    
		}

		$data = array(
			'gatewayname' 	=>$this->input->post('gatewayname',TRUE),
			'title' 		=>$this->input->post('title',TRUE),
			'host' 			=>$this->input->post('host',TRUE),
			'user' 			=>$this->input->post('user',TRUE),
			'userid' 		=>$this->input->post('userid',TRUE),
			'password' 		=>$pass,
			'api' 			=>$this->input->post('api',TRUE)
		);

		$this->db->where('es_id',$sms)->update('email_sms_gateway',$data);

		
		$this->session->set_flashdata('message',display('update_successfully'));
		
		
		redirect('backend/setting/sms_gateway');
	}

	public function test_sms()
	{
		$this->form_validation->set_rules('mobile_num',display('mobile_number'),'required|trim|xss_clean');
		$this->form_validation->set_rules('test_message',display('test_sms'),'required|xss_clean');

		if($this->form_validation->run()){

			#----------------------------
            #      SMS Test
            #----------------------------
            $this->load->library('sms_lib');

            $mobile_num 	= $this->input->post('mobile_num',TRUE);
            $test_message 	= $this->input->post('test_message',TRUE);


            if ($mobile_num) {
                $smssend = $this->sms_lib->send(array(
                    'to'                => $mobile_num, 
                    'template'          => $test_message,
                    'template_config'	=> ''
                ));

                if (is_string($smssend) && is_array(json_decode($smssend, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {

                	$smsdata = json_decode($smssend,true);

                	if($smsdata['status']){

                		$this->session->set_flashdata('message',$smsdata['message']);
                	}
                	else{

                		$this->session->set_flashdata('exception',$smsdata['message']);
                	}

                }
                else{

                	$this->session->set_flashdata('message',$smssend);
                }

            }else{

                $this->session->set_flashdata('exception', display('there_is_no_phone_number'));

            }

		}
		else{
			$this->session->set_flashdata('exception',validation_errors());
		}

		redirect('backend/setting/sms_gateway/');
	}


}