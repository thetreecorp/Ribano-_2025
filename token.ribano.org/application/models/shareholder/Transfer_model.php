<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer_model extends CI_Model {

	public function transfer($data)
	{
		$this->db->insert('dbt_transfer',$data);
		return array('id'=>$this->db->insert_id());
	}

	public function save_transfer_verify($data)
	{
		$this->db->insert('dbt_verify',$data);
		return array('id'=>$this->db->insert_id());
	}

	public function get_verify_data($id)
    {
        $v = $this->db->select('*')
				        ->from('dbt_verify')
				        ->where('id',$id)
				        ->where('session_id', $this->session->userdata('isLogIn'))
				        ->get()
				        ->row();

        return $v;
    }
	public function balanceAdd($data = array())
	{
		$this->db->insert('dbt_balance', $data);
		return  $this->db->insert_id();

	}
	public function checkBalance($user=null)
	{
		if ($user==null) {
			$user = $this->session->userdata('user_id');
		}

		return $this->db->select('*')
			->from('dbt_balance')
			->where('user_id', $user)
			->get()
			->row();

	}

	public function retriveUserInfo()
	{
		return $this->db->select('*')
			->from('dbt_user')
			->where('user_id', $this->session->userdata('user_id'))
			->get()
			->row();

	}

	public function checkFees($type)
	{
		return $this->db->select('*')
			->from('dbt_fees')
			->where('level', $type)
			->get()
			->row();

	}


	public function get_send($id){
		return $this->db->select('dbt_transfer.*,dbt_user.*')
		->from('dbt_transfer')
		->join('dbt_user','dbt_user.user_id=dbt_transfer.receiver_user_id')
		->where('dbt_transfer.sender_user_id',$this->session->userdata('user_id'))
		->where('dbt_transfer.id',$id)
		->get()->row();
	}

	public function get_recieved($id){

		return $this->db->select('dbt_transfer.*,dbt_user.*')
		->from('dbt_transfer')
		->join('dbt_user','dbt_user.user_id=dbt_transfer.sender_user_id')
		->where('dbt_transfer.receiver_user_id',$this->session->userdata('user_id'))
		->where('dbt_transfer.id',$id)
		->get()->row();
		
	}
	
	public function verify($data)
	{
		$this->db->insert('dbt_verify',$data);
		return array('id'=>$this->db->insert_id());
	}


}
 