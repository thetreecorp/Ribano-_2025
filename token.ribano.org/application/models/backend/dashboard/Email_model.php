<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {
	

	public function user_info($user_id="")
	{
		if ($user_id!="") {
			$user_id = $user_id;
		}
		else{
			$user_id = $this->session->userdata('user_id');
		}

		$my_info = $this->db->select('*')
		->from('dbt_user')
		->where('user_id',$user_id)
		->get()
		->row();
		
	

		$sponser_info = $this->db->select('*')
		->from('dbt_user')
		->where('user_id',@$my_info->sponsor_id)
		->get()
		->row();
		

		return array('my_info'=>$my_info,'sponser_info'=>$sponser_info);
	}

	public function gettemplatedata($data="")
	{
		if($data!=""){

			return $this->db->select('*')
			->from("email_template")
			->where("email_temp_id",$data)
			->get()
			->row();

		}
		else
		{
			return $this->db->select('*')
			->from('email_template')
			->get()
			->result();
		}
	}

	public function getactivetemplatedata()
	{
		return $this->db->select('*')
		->from('email_template')
		->where('default_status',1)
		->get()
		->result();
	}

	public function schedule_list()
	{
 	 	return $this->db->select('email_schedule.*,email_template.*')
 	 	->from('email_schedule')
 	 	->join('email_template','email_template.email_temp_id=email_schedule.email_temp_id')
 	 	->get()
 	 	->result();
 	}

	public function savetemplate($data = array())
	{
		$this->db->insert("email_template",$data);
	}

	public function savereservekey($data = array())
	{
		$this->db->insert("reserve_key",$data);
	}

	public function getreservekey()
	{
		return $this->db->select('*')
		->from('reserve_key')
		->get()
		->result_array();
	}

	public function getuser($data = array())
	{
		if($data=="ALL"){

			return $this->db->select('*')
			->from('dbt_user')
			->get();

		}
		else
		{
			return $this->db->select('*')
			->from('dbt_user')
			->where("transfer_limit",$data)
			->get();
		}
	}

	public function assignreservekey($data = array())
	{
		$reg = array();
		$reservekey = $this->getreservekey();
		$i =0;
		foreach ($reservekey as $value) {
			
			$reg[$i][$value['reserve_key']] = $data[$value['reserve_key']];

			$i++;
		}

		return $reg;
	}

	public function email_list($limit, $offset)
	{
		return $this->db->select('*')
		->from('email_delivery')
		->order_by('email_delivery_id', 'asc')
		->limit($limit, $offset)
		->get()
		->result();
	}	


}