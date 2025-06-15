<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_sender extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'backend/dashboard/sms_model',
			'backend/dashboard/email_model'
		));
	}
	public function index()
	{
		$this->load->library('sms_lib');

		$nowtime 	= strtotime(date("Y-m-d H:i:s"));

		$schedule = $this->sms_model->sms_schedule_list();

		foreach ($schedule as $key => $value) {

			if($value->ss_status!=0){
			  
				if ($nowtime>=strtotime($value->hit_time)) {
				    
					$nowtime 		= date('Y-m-d H:i:s');

					$insert_data = array(
						'sms_temp_id'	=>$value->ss_teamplate_id,
						'customer_type'	=>$value->customer_type,
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

	}

}