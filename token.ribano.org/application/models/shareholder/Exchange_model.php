<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchange_model extends CI_Model {


	public function singleExchange($exchange_id = null)
	{
		return $this->db->select('*')
			->from('dbt_exchange')
			->where('id', $exchange_id)
			->get()
			->row();
	}
	
	public function exchangeCreate($data = array()){

		$this->db->insert('dbt_exchange', $data);
		return  $this->db->insert_id();

	}
	
	public function exchangeUpdate($data = array()){

		return $this->db->where('id', $data["id"])->update("dbt_exchange", $data);

	}

	public function exchangeLogCreate($data = array()){

		return $this->db->insert('dbt_exchange_details', $data);

	}

	//Discut Balance
	public function balanceDebit($data = array()){

		$balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data['user_id'])->get()->row();

		$updatebalance = array(
            'balance'     => $balance->balance-($data['amount']+(float)@$data['feesamount']),
        );

        return $this->db->where('user_id', $data['user_id'])->update("dbt_balance", $updatebalance);

	}

	//Return Balance
	public function balanceReturn($data = array()){

		$balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data['user_id'])->get()->row();

		$updatebalance = array(
            'balance'     => $balance->balance+$data['amount']+$data['return_fees'],
        );

        $this->db->where('user_id', $data['user_id'])->update("dbt_balance", $updatebalance);

        $logdata = array(
        	'balance_id'		=>$balance->id,
        	'user_id' 			=>$data['user_id'],
        	'transaction_type' 	=>'ADJUSTMENT',
        	'transaction_amount'=>$data['amount'],
        	'transaction_fees'	=>$data['return_fees'],
        	'ip' 				=>$data['ip'],
        	'date'				=>date('Y-m-d H:i:s')
        );

        $this->db->insert("dbt_balance_log",$logdata);

	}
	
	//Add balance
	public function balanceCredit($data = array()){

		$balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data->user_id)->get()->row();

		$updatebalance = array(
            'balance'     => $balance->balance-$data->total_amount-$data->fees_amount,
        );

        return $this->db->where('user_id', $data->user_id)->update("dbt_balance", $updatebalance);


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

	public function retriveUserIdByCryptoWallet($wallet=null)
	{
		$query = $this->db->select('user_id')
			->from('dbt_user_cryptowallet')
			->where('wallet', $wallet)
			->get()
			->row();

		return @$query->user_id;

	}

	public function user_cryptowallet($data)
	{
		$this->db->insert('dbt_user_cryptowallet',$data);
			return array('id'=>$this->db->insert_id());

	}
	public function crypto_transaction($data)
	{
		$this->db->insert('dbt_crypto_transaction',$data);
			return array('id'=>$this->db->insert_id());

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

	public function retriveUserWallet($wallet=null)
	{
		$user_wallet_exist = $this->db->select('*')
			->from('dbt_user_cryptowallet')
			->where('wallet', $wallet)
			->get()
			->num_rows();

		if ($user_wallet_exist==1) {
			$query = $this->db->select('*')
			->from('dbt_crypto_transaction')
			->where('wallet', $wallet)
			->get()
			->row();

		}else{
			return false;

		}

		return $query;

	}

	public function updateUserWalletData($data=array())
	{
		return $this->db->where('wallet', $data["wallet"])
			->update("dbt_crypto_transaction", $data);

	}

	public function userExchangeOpened($wallet=null)
	{

		return $this->db->select('*')
			->from('dbt_exchange')
			->where('source_wallet', $wallet)
			->where('status', 2)
			->order_by('id','desc')
			->get()
			->result();

	}

	public function userExchangeCanceled($wallet=null)
	{
		return $this->db->select('*')
		->from('dbt_exchange')
		->where('source_wallet', $wallet)
		->where('status', 0)
		->order_by('id','desc')
		->get()
		->result();
	}

	public function userExchangeHistory($wallet=null)
	{

		return $this->db->select('master.*, details.exchange_type as exchange_type1, details.source_wallet as source_wallet1, details.destination_wallet, details.crypto_qty as crypto_qty1, details.crypto_rate as crypto_rate1, details.complete_qty as complete_qty1, details.available_qty as available_qty1, details.datetime as datetime1')
			->from('dbt_exchange master')
			->join('dbt_exchange_details details', 'details.exc_id = master.id', 'left')
			->where('master.source_wallet', $wallet)
			->get()
			->result();

	}

	public function userSingelExchnageHistory($wallet=null)
	{
		return $this->db->select('*')
			->from('dbt_exchange')
			->where('source_wallet', $wallet)
			->get()
			->result();
	}

	public function create($data = array())
	{
		return $this->db->insert('dbt_exchange', $data);

	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('dbt_exchange')
			->where('type', 'buy')
			->order_by('exc_id', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function single($id = null)
	{
		return $this->db->select('*')
			->from('dbt_exchange')
			->where('id', $id)
			->get()
			->row();
	}

//Balance Log
    public function balancelog($data = array()){
       
        return $this->db->insert('dbt_balance_log', $data);

    }
	public function all()
	{
		return $this->db->select('*')
			->from('dbt_exchange')
			->where('type', 'buy')
			->get()
			->result();
	}

	public function update($data = array())
	{
		return $this->db->where('exc_id', $data["exc_id"])
			->update("dbt_exchange", $data);
	}

}