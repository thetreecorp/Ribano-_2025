<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_sms_setting extends CI_Controller {

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
		$data['email'] = $this->db->select('*')->from('sms_email_send_setup')->where('method','email')->get()->row();
		$data['sms'] = $this->db->select('*')->from('sms_email_send_setup')->where('method','sms')->get()->row();
		$data['title'] = display('email_and_sms_setting');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(29);
		$data['content'] = $this->load->view('backend/dashboard/email_and_sms_setting',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function update_sender()
	{
		$email = $this->input->post('email',TRUE);
		$sms   = $this->input->post('sms',TRUE);

		$email_info = $this->db->select('*')->from('sms_email_send_setup')->where('method','email')->get()->row();
		$sms_info   = $this->db->select('*')->from('sms_email_send_setup')->where('method','sms')->get()->row();

		$deposit  		= $this->input->post('deposit',TRUE)?1:NULL;
		$transfer 		= $this->input->post('transfer',TRUE)?1:NULL;
		$withdraw 		= $this->input->post('withdraw',TRUE)?1:NULL;
		$payout   		= $this->input->post('payout',TRUE)?1:NULL;
		$commission 	= $this->input->post('commission',TRUE)?1:NULL;
		$team_bonnus 	= $this->input->post('team_bonnus',TRUE)?1:NULL;
		$sign_up 		= $this->input->post('sign_up',TRUE)?1:NULL;
		$authentication = $this->input->post('authentication',TRUE)?1:NULL;

		if($email!=NULL){

    		if($authentication == 0){
    		    $this->db->set('googleauth',NULL)->update('dbt_user');
    		}

			$data = array(
				'deposit' 		 => $deposit,
				'transfer' 		 => $transfer,
				'withdraw' 		 => $withdraw,
				'payout' 		 => $payout,
				'commission' 	 => $commission,
				'team_bonnus' 	 => $team_bonnus,
				'sign_up' 		 => $sign_up,
				'authentication' => $authentication
			);

			$this->db->where('method',$email)->update('sms_email_send_setup',$data);
		}
		if($sms!=NULL){
    		if($authentication == 0){
    		    $this->db->set('smsauth',NULL)->update('dbt_user');
    		}
            
			$data = array(
				'deposit' 		 => $deposit,
				'transfer' 		 => $transfer,
				'withdraw' 		 => $withdraw,
				'payout' 		 => $payout,
				'commission' 	 => $commission,
				'team_bonnus' 	 => $team_bonnus,
				'sign_up' 		 => $sign_up,
				'authentication' => $authentication
			);

			$this->db->where('method',$sms)->update('sms_email_send_setup',$data);
		}

		$this->session->set_flashdata('message',display('update_successfully'));
		redirect('backend/setting/email_sms_setting');
	}


}