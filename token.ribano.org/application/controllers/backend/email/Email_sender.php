<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_sender extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'backend/dashboard/email_model',
			'common_model'
		));
	}
	public function index()
	{
		$nowtime 	= strtotime(date("Y-m-d H:i:s"));

		$schedule = $this->email_model->schedule_list();

		foreach ($schedule as $key => $value) {

			if($value->email_ss_status!=0){
			  
				if ($nowtime>=strtotime($value->hit_time)) {

					$nowtime 		= date('Y-m-d H:i:s');

					$insert_data = array(
						'subject'		=>$value->mail_subject,
						'email_temp_id'	=>$value->email_temp_id,
						'customer_type'	=>$value->customer_type,
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

	}

}