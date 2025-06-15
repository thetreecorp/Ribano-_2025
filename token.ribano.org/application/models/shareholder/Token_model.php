<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model {

	public function crypto_transaction($data)
	{
		$this->db->insert('dbt_crypto_transaction',$data);
			return array('id'=>$this->db->insert_id());

	}

	public function user_cryptowallet($data)
	{
		$this->db->insert('dbt_user_cryptowallet',$data);
			return array('id'=>$this->db->insert_id());

	}

	public function updateUserWalletData($data=array())
	{
		return $this->db->where('wallet', $data["wallet"])
			->update("dbt_crypto_transaction", $data);
	}

	public function exchangeCurrency()
	{
		return $this->db->select('*')
			->from('dbt_currency')
			->where('status', 1)
			->get()
			->result();
	}

	public function checkBalance($user=null)
	{
		if ($user==null) {
			$user = $this->session->userdata('user_id');
		}

		$query = $this->db->select('balance')
			->from('dbt_balance')
			->where('user_id', $user)
			->get()
			->row();

		return @$query->balance;

	}

	public function checkBalance1($user=null)
	{
		if ($user==null) {
			$user = $this->session->userdata('user_id');
		}

		$query = $this->db->select('*')
			->from('dbt_balance')
			->where('user_id', $user)
			->get()
			->row();

		return $query;

	}

	public function retriveUserCryptoTransaction($user=null)
	{
		if ($user==null) {
			$user = $this->session->userdata('user_id');
		}

		$wallet = $this->retriveUserCryptoWallet($user);

		$query = $this->db->select('*')
			->from('dbt_crypto_transaction')
			->where('wallet', $wallet)
			->get()
			->row();

		return $query;

	}

	public function retriveUserCryptoWallet($user=null)
	{
		if ($user==null) {
			$user = $this->session->userdata('user_id');
		}

		$query = $this->db->select('wallet')
			->from('dbt_user_cryptowallet')
			->where('user_id', $user)
			->get()
			->row();

		return @$query->wallet;

	}

	public function nonsecureStoBalance()
	{
		return $this->db->select('non_secured')
			->from('dbt_sto_manager')
			->get()
			->row();
	}

	public function cryptoBallanceByWallet($wallet = "")
	{
		return $this->db->select('*')
			->from('dbt_user_cryptowallet')
			->where('wallet',$wallet)
			->get()
			->row();
	}

}   

