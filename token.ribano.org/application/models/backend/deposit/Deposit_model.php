<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('dbt_deposit', $data);
	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('dbt_deposit')
			->order_by('deposit_date', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function single($id = null)
	{
		return $this->db->select('*')
			->from('dbt_deposit')
			->where('id', $id)
			->get()
			->row();
	}

	public function all()
	{
		return $this->db->select('*')
			->from('dbt_deposit')
			->get()
			->result();
	}

	public function update($data = array())
	{
		return $this->db->where('id', $data["id"])
			->update("dbt_deposit", $data);
	}

	public function delete($id = null)
	{
		return $this->db->where('id', $id)
			->delete("dbt_deposit");
	}
}
