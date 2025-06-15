<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transections_model extends CI_Model {


	public function save_transections($data)
	{
		$this->db->insert('transections',$data);
	}

	
	public function all_transection($limit,$page)
	{
		return $this->db->select('*')
		->from('dbt_balance_log')
		->where('user_id', $this->session->userdata('user_id'))
		->order_by('log_id','DESC')
		->limit($limit, $page)
		->get()
		->result();
	}

	public function transections_all_sums($user_id = "")
	{
		if ($user_id == '') {
			$user_id = $this->session->userdata('user_id');
		}

		$data['deposit_amount'] = $this->db->select_sum('transaction_amount')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'DEPOSIT')
								->get()
								->row();

		$data['credited_amount'] = $this->db->select_sum('transaction_amount')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'CREDITED')
								->get()
								->row();

		$data['exchange_cancel_amount'] = $this->db->select_sum('transaction_amount')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'EXCHANGE_CANCEL')
								->get()
								->row();

		$data['recevied_amount'] = $this->db->select_sum('transaction_amount')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'RECEIVED')
								->get()
								->row();

		$data['sell_amount'] = $this->db->select_sum('transaction_amount')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'SELL')
								->get()
								->row();

		$data['roi_amount']	 = $this->db->select_sum('amount')
								->from('earnings')
								->where('user_id', $user_id)
								->where('earning_type', "ROI")
								->get()
								->row();

		$data['referral_amount'] = $this->db->select_sum('amount')
								->from('earnings')
								->where('user_id', $user_id)
								->where('earning_type', "REFERRAL")
								->get()
								->row();

		$data['transfer_amount'] = $this->db->select_sum('transaction_amount')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'TRANSFER')
								->get()
								->row();

		$data['withdraw_amount'] = $this->db->select_sum('transaction_amount')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'WITHDRAW')
								->get()
								->row();

		$data['buy_amount'] = $this->db->select_sum('transaction_amount')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'BUY')
								->get()
								->row();

		$data['invest_amount'] = $this->db->select_sum('transaction_amount')
								  ->select('transaction_type')
								  ->from('dbt_balance_log')
								  ->where('user_id', $user_id)
								  ->where('transaction_type', 'INVESTMENT')
								  ->get()
								  ->row();

		$data['return_amount'] = $this->db->select_sum('transaction_amount')
								  ->select('transaction_type')
								  ->from('dbt_balance_log')
								  ->where('user_id', $user_id)
								  ->where('transaction_type', 'ADJUSTMENT')
								  ->get()
								  ->row();
								  
		$data['return_fees'] = $this->db->select_sum('transaction_fees')
		                          ->select('transaction_type')
    							  ->from('dbt_balance_log')
    							  ->where('user_id', $user_id)
    							  ->where('transaction_type', 'ADJUSTMENT')
    							  ->get()
    							  ->row();

		$data['deposit_amount_fees'] = $this->db->select_sum('transaction_fees')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'DEPOSIT')
								->get()
								->row();

		$data['credited_amount_fees'] = $this->db->select_sum('transaction_fees')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'CREDITED')
								->get()
								->row();

		$data['exchange_cancel_amount_fees'] = $this->db->select_sum('transaction_fees')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'EXCHANGE_CANCEL')
								->get()
								->row();

		$data['recevied_amount_fees'] = $this->db->select_sum('transaction_fees')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'RECEIVED')
								->get()
								->row();

		$data['sell_amount_fees'] = $this->db->select_sum('transaction_fees')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'SELL')
								->get()
								->row();

		$data['transfer_amount_fees'] = $this->db->select_sum('transaction_fees')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'TRANSFER')
								->get()
								->row();

		$data['withdraw_amount_fees'] = $this->db->select_sum('transaction_fees')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'WITHDRAW')
								->get()
								->row();

		$data['buy_amount_fees'] = $this->db->select_sum('transaction_fees')
								->select('transaction_type')
								->from('dbt_balance_log')
								->where('user_id', $user_id)
								->where('transaction_type', 'BUY')
								->get()
								->row();

		return  $data;
	}





	public function getFees($table,$id)
	{
		return $this->db->select('*')
		->from($table)
		->where($table.'_id',$id)
		->get()
		->row();
	}

	public function get_coin_info()
	{
		return $this->db->select('*')
		->from('dbt_sto_setup')
		->get()
		->row();
	}


}
 