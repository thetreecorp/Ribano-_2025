<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Package_model extends CI_Model {


	public function allPackage($type="")
	{
		return $this->db->select("*")
			->from('package')
			->where('pack_type',$type)
			->get()
			->result();
	}

	public function allInvestment($type="")
	{
		return $this->db->select("investment.*,package.*")
			->from('investment')
			->join('package','package.package_id=investment.package_id')
			->where('package.pack_type',$type)
			->where('investment.user_id',$this->session->userdata('user_id'))
			->get()
			->result();
	}

	public function packageInfoById($package_id=NULL)
	{
		return $this->db->select("*")
			->from('package')
			->where('package_id',$package_id)
			->get()
			->row();
	}

	public function getBalance($userid="")
	{
		if($userid!=""){
			$user_id = $userid;
		}
		else{
			$user_id = $this->session->userdata('user_id');
		}
		return $this->db->select('*')
		->from('dbt_balance')
		->where('user_id',$user_id)
		->get()
		->row();
	}

	public function checkInvestment($user_id=NULL)
    {
        return $this->db->select('*')
         ->from('investment')
         ->where('user_id',$user_id)
         ->get()
         ->num_rows();
        
    }

	public function buyPackage($data)
	{
		$this->db->insert('investment',$data);
		return $this->db->insert_id();
	}

	public function saveBalanceLog($data=array())
	{
		$this->db->insert('dbt_balance_log',$data);
	}

	public function updateBalance($data = array())
	{
		$this->db->where('user_id',$data['user_id']);
		$this->db->set('balance',$data['new_balance'])->update('dbt_balance');
	}


}