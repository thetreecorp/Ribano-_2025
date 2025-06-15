<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Model {


	public function template($data="")
	{
		if($data!=""){

			return $this->db->select('*')
			->from("sms_teamplate")
			->where("teamplate_id",$data)
			->get()
			->row();

		}
		else
		{
			return $this->db->select('*')
			->from('sms_teamplate')
			->get()
			->result();
		}
	}

	public function save_template($data = array())
	{
		$this->db->insert("sms_teamplate",$data);
	}

	public function sms_schedule_list()
	{
		return $this->db->select('sms_schedule.*,sms_teamplate.*')
			->from('sms_schedule')->join('sms_teamplate','sms_teamplate.teamplate_id = sms_schedule.ss_teamplate_id')
			->get()
			->result();
	}

	public function sms_delivery_list($limit, $offset)
	{
		return $this->db->select('*')
		->from('sms_delivery')
		->order_by('id', 'asc')
		->limit($limit, $offset)
		->get()
		->result();
	}

}