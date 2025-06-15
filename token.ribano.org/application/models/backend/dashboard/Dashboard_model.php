<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {


	public function withdraw_all_request()
	{
		return $this->db->select("*")
			->from('withdraw')
			->where('status',1)
			->limit(10)
			->order_by('request_date', 'DESC')
			->get()
			->result();
	}
	public function exchange_all_request()
	{
		return $this->db->select("*")
			->from('ext_exchange')
			->where('status',1)
			->limit(10)
			->order_by('date_time', 'DESC')
			->get()
			->result();
	}
	public function crypto_all_request()
	{
		return $this->db->select("cid, name, symbol")
			->from('crypto_currency')
			->where('status',1)
			->get()
			->result();
	}

	public function get_cata_wais_transections()
	{
		$data = array();//Declear Array Variable

		/***********************|
		| All User 				|
		************************/		
		$data['total_user'] 		= $this->db->select('user_id')
										->from('dbt_user')
										->get()
										->num_rows();

		/*************************|
		| All Investment 		  |
		**************************/
		$data['total_investment'] 	= $this->db->select_sum("amount")
										->from('investment')
										->get()
										->row();

		/*************************|
		| All ROI 		 		  |
		**************************/
		$data['total_roi'] 			= $this->db->select_sum("amount")
										->from('earnings')
										->where('earning_type','ROI')
										->get()
										->row();

		/*************************|
		| Total Deposit	 		  |
		**************************/
		$data['total_deposit'] 		= $this->db->select_sum('transaction_amount','deposit')
										->where('transaction_type','DEPOSIT')
										->from('dbt_balance_log')
										->get()
										->row();

		/*************************|
		| Total Withdraw 		  |
		**************************/
		$data['total_withdraw']		= $this->db->select_sum('transaction_amount','withdraw')
										->where('transaction_type','WITHDRAW')
										->from('dbt_balance_log')
										->get()
										->row();

		/*************************|
		| Sold Token 	 		  |
		**************************/
		$data['sold_token']			= $this->db->select_sum('fillup_target','soldtoken')
										->from('dbt_release_setup')
										->get()
										->row();

		/*************************|
		| Total Fees 	 		  |
		**************************/
		$totalfees                  = $this->db->select_sum('transaction_fees')
                                		->from('dbt_balance_log')
                                		->where('transaction_type !=', 'ADJUSTMENT')
                                		->get()
                                		->row();
		$adjustfees                 = $this->db->select_sum('transaction_fees')
                                		->from('dbt_balance_log')
                                		->where('transaction_type', 'ADJUSTMENT')
                                		->get()
                                		->row();
                                		
        $data['total_earning_fees'] = (float)@$totalfees->transaction_fees-(float)@$adjustfees->transaction_fees;

		/*************************|
		| All Token 	 		  |
		**************************/
		$all_token 		= $this->db->select('*')->from('dbt_sto_manager')->get()->row();
		$data['token']				= @$all_token->non_secured;


		/*************************|
		| Secured Investment	  |
		**************************/
		$data['secured_investment'] = $this->db->select('SUM(investment.amount) as amount,package.package_id')
										->from('investment')
										->join('package','package.package_id=investment.package_id')
										->where('package.pack_type','secured')
										->get()
										->row();
						

		/*************************|
		| Gurenteed Investment	  |
		**************************/
		$data['gurenteed_investment'] = $this->db->select('SUM(investment.amount) as amount,package.package_id')
										->from('investment')
										->join('package','package.package_id=investment.package_id')
										->where('package.pack_type','guaranteed')
										->get()
										->row();
										


		/*************************|
		| Secured ROI 	 		  |
		**************************/
		$data['secured_roi'] 		= $this->db->select_sum("amount")
										->from('earnings')
										->where('earning_type','ROI')
										->where('package_type',"secured")
										->get()
										->row();

		/*************************|
		| Gurenteed ROI  		  |
		**************************/
		$data['gurenteed_roi'] 		= $this->db->select_sum("amount")
										->from('earnings')
										->where('earning_type','ROI')
										->where('package_type',"guaranteed")
										->get()
										->row();


		return $data;
		
	}

	public function getPackage()
	{
		return $this->db->select('*')
				->from('package')
				->get()
				->result();
	}

	public function monthlyInvestment()
	{
		return $query = $this->db->query("SELECT MONTHNAME(`invest_date`) as month, SUM(`amount`) as invest FROM `investment` GROUP BY YEAR(`invest_date`), MONTH(`invest_date`)")->result();
	}

	public function allWithdraw()
	{
		return $this->db->select('*')
				->from('dbt_withdraw')
				->order_by('request_date','DESC')
				->limit(5)
				->get()
				->result();
	}

	public function allDeposit()
	{
		return $this->db->select('*')
				->from('dbt_deposit')
				->order_by('deposit_date','DESC')
				->limit(5)
				->get()
				->result();
	}

	public function allExchange()
	{
		return $this->db->select('*')
				->from('dbt_exchange')
				->order_by('datetime','DESC')
				->limit(10)
				->get()
				->result();
	}

	public function pairCurrencyInfo()
	{
		return $this->db->select('*')
				->from('dbt_sto_setup')
				->get()
				->row();
	}


}
 