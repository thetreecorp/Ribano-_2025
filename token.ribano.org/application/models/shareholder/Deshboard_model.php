<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Deshboard_model extends CI_Model {
	

	public function get_cata_wais_transections($user_id)
	{
		$data = array();

		$data['totalBalance'] 	= $this->db->select_sum('balance')
									->from('dbt_balance')
									->where('user_id',$user_id)
									->get()
									->row();

		return $data;
	}

	public function getFees($table,$id)
	{
		return $this->db->select('*')
		->from($table)
		->where($table.'_id',$id)
		->get()
		->row();
	}

	public function my_info()
	{
		$user_id = $this->session->userdata('user_id');

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


	public function my_sales()
	{
		$user_id = $this->session->userdata('user_id');
		$result1 = $this->db->select("*")
			->from('dbt_user')
			->where('sponsor_id',$user_id)
			->limit(5)
			->order_by('created', 'DESC')
			->get()
			->result();
		return $result1;		
	}


	public function my_payout()
	{
		$user_id = $this->session->userdata('user_id');
		
		$result1 = $this->db->select("*")
			->from('earnings')
			->where('user_id',$user_id)
			->where('earning_type','ROI')
			->limit(5)
			->order_by('date', 'DESC')
			->get()
			->result();

		return $result1;		
	}	


	public function my_bangk_info()
	{
		$user_id = $this->session->userdata('user_id');
		$result1 = $this->db->select("*")
			->from('bank_info')
			->where('user_id',$user_id)
			->get()
			->row();
		return $result1;		
	}


	public function my_total_investment($user_id)
	{
		$result = $this->db->select("sum(amount) as total_amount")
			->from('investment')
			->where('user_id',$user_id)
			->get()
			->row();
		return $result;		
	}

	public function pending_withdraw()
	{
		$user_id = $this->session->userdata('user_id');
		return $this->db->select("*")
			->from('withdraw')
			->where('status',1)
			->where('user_id',$user_id)
			->limit(5)
			->order_by('request_date', 'DESC')
			->get()
			->result();
	}	

	public function my_level_information($user_id)
	{
		
		return $this->db->select('level')
			->from('team_bonus')
			->where('user_id',$user_id)
			->get()
			->row();
	}

	public function pairCurrencyInfo()
	{
		return $this->db->select('*')
				->from('dbt_sto_setup')
				->get()
				->row();
	}

	public function allPackage()
	{
		return $this->db->select("*")
			->from('package')
			->get()
			->result();
	}

	public function securedPackage()
	{
		return $this->db->select("*")
			->from('package')
			->where('pack_type','secured')
			->get()
			->result();
	}

	public function gurenteedPackage()
	{
		return $this->db->select("*")
			->from('package')
			->where('pack_type','guaranteed')
			->get()
			->result();
	}

				

}
 