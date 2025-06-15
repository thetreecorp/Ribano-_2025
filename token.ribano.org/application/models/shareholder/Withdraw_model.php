<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw_model extends CI_Model {

	public function withdraw($data)
	{
		$this->db->insert('dbt_withdraw',$data);
		return array('id'=>$this->db->insert_id());
	}

	public function verify($data)
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
	public function retriveUserInfo()
	{
		return $this->db->select('*')
			->from('dbt_user')
			->where('user_id', $this->session->userdata('user_id'))
			->get()
			->row();

	}

	public function retriveUserlog()
	{
		return $this->db->select('*')
			->from('dbt_user_log')
			->where('user_id', $this->session->userdata('user_id'))
			->order_by('access_time', 'desc')
			->limit(10, 0)
			->get()
			->result();

	}
	public function checkFees($type)
	{
		return $this->db->select('*')
			->from('dbt_fees')
			->where('level', $type)
			->get()
			->row();

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

	public function get_withdraw_by_id($id)
	{
		return $this->db->select('*')
		->from('dbt_withdraw')
		->where('id',$id)
		->where('user_id',$this->session->userdata('user_id'))
		->get()
		->row();
	}

	public function coinpayment_withdraw()
	{
		$data = $this->db->select('data')
		->from('payment_gateway')
		->where('identity','coinpayment')
		->get()
		->row();

		$data_tbl = json_decode($data->data,true);
		$withdraw = $data_tbl['withdraw'];

		return $withdraw;
	}
}