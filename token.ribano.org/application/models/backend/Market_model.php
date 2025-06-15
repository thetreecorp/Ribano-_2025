<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('dbt_market', $data);
	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('dbt_market')
			->order_by('id', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function single($id = null)
	{
		return $this->db->select('*')
			->from('dbt_market')
			->where('id', $id)
			->get()
			->row();
	}

	public function all()
	{
		return $this->db->select('*')
			->from('dbt_market')
			->get()
			->result();
	}

	public function update($data = array())
	{
		return $this->db->where('id', $data["id"])
			->update("dbt_market", $data);
	}


}