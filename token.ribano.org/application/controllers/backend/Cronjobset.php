<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjobset extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'backend/dashboard/email_model',
			'backend/dashboard/sms_model',
			'backend/dashboard/setting_model',
			'shareholder/transections_model',
			'common_model'
		));
	}

	public function index()
	{
		/**********************************
		| Email Shedule Email Send Script |
		***********************************/

		$nowtime 	= strtotime(date("Y-m-d H:i:s"));

		$schedule = $this->email_model->schedule_list();

		foreach ($schedule as $key => $value) {

			if($value->email_ss_status!=0){
			  
				if ($nowtime>=strtotime($value->hit_time)) {

					$nowtime 		= date('Y-m-d H:i:s');

					$insert_data = array(
						'subject'		=>$value->mail_subject,
						'email_temp_id'	=>$value->email_temp_id,
						'next_id'		=>0,
						'next_time'		=>$nowtime,
						'status'		=>1
					);

					$this->db->insert("temp_cornjobs",$insert_data);
					
					$this->db->where("email_ss_id",$value->email_ss_id);
        			$this->db->set("email_ss_status",0)->update("email_schedule");
				}
			}
			
		}

		/***************************************
		| Email Shedule Bulk Email Send Script |
		****************************************/

		//Temporary data to send cron jobs for bulk sms.
		$tempdata = $this->db->select('*')->from('temp_cornjobs')->get()->result();
		
		foreach ($tempdata as $key => $value) {

			$nowtime = strtotime(date("Y-m-d H:i:s"));
			if($nowtime>=strtotime($value->next_time)){

				if($value->status==1){
				    
					$nextselectid 	= $value->next_id;
					$userinfo 		= $this->db->select('user_id,email,phone')->from('dbt_user')->order_by("user_id","asc")->limit(10,$nextselectid)->get();

					if($userinfo->num_rows()>0){

						//All Reserve Key
						$template 		= $this->email_model->gettemplatedata($value->email_temp_id);

						// Send 10 mail
						foreach ($userinfo->result() as $key => $value1) {
							
							$temconfig = $this->templateconfig($value1->user_id);

							$config = array(

								'to'				=>$value1->email,
								'subject'			=>$value->subject,
								'template'			=>$template->template,
								'template_config'	=>$temconfig

							);
							//Send Mail.
							$this->common_model->send_bulk_email($config);

						}
						//Present Next time in db table
						$nextime = $value->next_time;
						//Add 15 minutes in Next time
						$nextime = date("Y-m-d H:i:s",strtotime("$nextime +15 minutes"));
						$nextselectid = $nextselectid+10;
						$this->db->where("id",$value->id);
						$this->db->set("next_id",$nextselectid);
						$this->db->set("next_time",$nextime)->update("temp_cornjobs");

					}
					else{
						//Deactive Send Bulk Email
						$this->db->where("id",$value->id)->set("status",0)->update("temp_cornjobs");
					}
					

					
				}

			}	

		}

		/******************************
		| SMS Shedule SMS Send Script |
		*******************************/

		$this->load->library('sms_lib');
		$nowtime 	= strtotime(date("Y-m-d H:i:s"));

		$schedule = $this->sms_model->sms_schedule_list();

		foreach ($schedule as $key => $value) {

			if($value->ss_status!=0){
			  
				if ($nowtime>=strtotime($value->hit_time)) {
				    
					$nowtime 		= date('Y-m-d H:i:s');

					$insert_data = array(
						'sms_temp_id'	=>$value->ss_teamplate_id,
						'next_id'		=>0,
						'next_time'		=>$nowtime,
						'status'		=>1
					);

					$this->db->insert("sms_temp_cornjobs",$insert_data);

					$this->db->where("ss_id",$value->ss_id);
        			$this->db->set("ss_status",0)->update("sms_schedule");
				}
			}
			
		}

		/**********************************
		| SMS Shedule Bulk SMS Send Script|
		***********************************/

		//Temporary data to send cron jobs for bulk sms.
		$tempdata = $this->db->select('*')->from('sms_temp_cornjobs')->get()->result();
		
		foreach ($tempdata as $key => $value) {

			$nowtime = strtotime(date("Y-m-d H:i:s"));
			if($nowtime>=strtotime($value->next_time)){

				if($value->status==1){
				    
					$nextselectid 	= $value->next_id;
					$userinfo = $this->db->select('user_id,email,phone')->from('dbt_user')->order_by("user_id","asc")->limit(10,$nextselectid)->get();

					if($userinfo->num_rows()>0){

						//All Reserve Key
						$template = $this->sms_model->template($value->sms_temp_id);

						// Send 10 mail
						foreach ($userinfo->result() as $key => $value1) {
							
							$temconfig = $this->templateconfig($value1->user_id);

							$config = array(
								'template'			=>@$template->teamplate,
								'to'			 	=>@$value1->phone,
								'template_config'	=>$temconfig
							);

							$smsdata = $this->sms_lib->sms_rank_send($config);

				            if($smsdata=='true'){
								$nowtime	  = date("Y-m-d H:i:s");
								$insert_data = array(
								'receiver'	=>@$value1->phone,
								'date_time'	=>$nowtime,
								'message'	=>@$template->teamplate
								);
								$this->db->insert("sms_delivery",$insert_data);
				            }
				          	else{
				          		$nowtime	  = date("Y-m-d H:i:s");
								$insert_data = array(
								'receiver'	=>@$value1->phone,
								'date_time'	=>$nowtime,
								'message'	=>'NO SEND SMS'
								);
								$this->db->insert("sms_delivery",$insert_data);
				          	}

						}
						//Present Next time in db table
						$nextime = $value->next_time;
						//Add 15 minutes in Next time
						$nextime = date("Y-m-d H:i:s",strtotime("$nextime +15 minutes"));
						$nextselectid = $nextselectid+10;
						$this->db->where("id",$value->id);
						$this->db->set("next_id",$nextselectid);
						$this->db->set("next_time",$nextime)->update("sms_temp_cornjobs");

					}
					else{
						//Deactive Send Bulk Email
						$this->db->where("id",$value->id)->set("status",0)->update("sms_temp_cornjobs");
					}
					
				}

			}	

		}


	}

	public function gettemplatconfig($user_id="")
	{

		$transectinfo 	= $this->transections_model->transections_all_sums($user_id);
		$userinfo 		= $this->email_model->user_info($user_id);

		$data['user_name']			= $userinfo['my_info']->username;
		$data['name']				= $userinfo['my_info']->first_name." ".$userinfo['my_info']->last_name;
		$data['email']				= $userinfo['my_info']->email;
		$data['phone']				= $userinfo['my_info']->phone;

		$data['payout']				= @$transectinfo['my_earns']?"$".number_format($transectinfo['my_earns'], 2):'$0.0';

		$data['commission']			= @$transectinfo['commission']?"$".number_format($transectinfo['commission'], 2):'$0.0';

		$data['withdraw']			= @$transectinfo['withdraw']?"$".number_format($transectinfo['withdraw'], 2):'$0.0';

		$data['sponser_turnover']	= @$transectinfo['sponser_commission']?"$".number_format($transectinfo['sponser_commission'], 2):'$0.0';

		$data['balance']			= @$transectinfo['balance']?"$".number_format($transectinfo['balance'], 2):'$0.0';

		$data['investment']			= @$transectinfo['investment']->total_amount?"$".number_format($transectinfo['investment']->total_amount, 2):'$0.0';

		return $data;

	}

	private function templateconfig($user_id)
	{
		$data 		 = $this->gettemplatconfig($user_id);
		$reservedata = $this->email_model->assignreservekey($data);

		return $reservedata;
	}


}