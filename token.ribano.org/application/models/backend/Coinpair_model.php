<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coinpair_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('dbt_coinpair', $data);
	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('dbt_coinpair')
			->order_by('id', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function single($id = null)
	{
		return $this->db->select('*')
			->from('dbt_coinpair')
			->where('id', $id)
			->get()
			->row();
	}

	public function all()
	{
		return $this->db->select('*')
			->from('dbt_coinpair')
			->get()
			->result();
	}
	public function allMarket()
	{
		return $this->db->select('*')
			->from('dbt_market')
			->get()
			->result();
	}
	public function allCoin()
	{
		return $this->db->select('*')
			->from('dbt_cryptocoin')
			->where('status', 1)
			->order_by('rank', 'asc')
			->limit(100, 0)
			->get()
			->result();
	}

	public function update($data = array())
	{
		return $this->db->where('id', $data['id'])
			->update("dbt_coinpair", $data);
	}



}