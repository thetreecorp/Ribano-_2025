<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchange_model extends CI_Model {
 	
 	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('dbt_biding')
			->order_by('open_order', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function userExchangeOpened($limit, $offset)
	{

		return $this->db->select('master.*, details.exchange_type as exchange_type1, details.source_wallet as source_wallet1, details.destination_wallet, details.crypto_qty as crypto_qty1, details.crypto_rate as crypto_rate1, details.complete_qty as complete_qty1, details.available_qty as available_qty1, details.datetime as datetime1')
			->from('dbt_exchange master')
			->join('dbt_exchange_details details', 'details.exc_id = master.id AND `details`.`source_wallet`=`master`.`source_wallet`', 'left')
			->where('master.status', 2)
			->order_by('details.id','DESC')
			->limit($limit, $offset)
			->get()
			->result();

	}

	public function userExchangeHistory($limit, $offset)
	{

		return $this->db->select('master.*, details.exchange_type as exchange_type1, details.source_wallet as source_wallet1, details.destination_wallet, details.crypto_qty as crypto_qty1, details.crypto_rate as crypto_rate1, details.complete_qty as complete_qty1, details.available_qty as available_qty1, details.datetime as datetime1')
			->from('dbt_exchange master')
			->join('dbt_exchange_details details', 'details.exc_id = master.id', 'left')
			->limit($limit, $offset)
			->get()
			->result();

	}

	public function userSingelExchnageHistory($limit, $offset)
	{
		return $this->db->select('*')
			->from('dbt_exchange')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function userExchangeCanceled($limit, $offset)
	{

		return $this->db->select('master.*, details.exchange_type as exchange_type1, details.source_wallet as source_wallet1, details.destination_wallet, details.crypto_qty as crypto_qty1, details.crypto_rate as crypto_rate1, details.complete_qty as complete_qty1, details.available_qty as available_qty1, details.datetime as datetime1')
			->from('dbt_exchange master')
			->join('dbt_exchange_details details', 'details.exc_id = master.id', 'left')
			->where('master.status', 0)
			->where('details.status', 0)
			->limit($limit, $offset)
			->get()
			->result();

	}


}
