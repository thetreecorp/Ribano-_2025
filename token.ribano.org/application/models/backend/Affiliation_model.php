<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliation_model extends CI_Model {
	
	public function single($id = 1)
	{
		return $this->db->select('*')
			->from('dbt_affiliation')
			->where('id', $id)
			->get()
			->row();
	}

	public function update($data = array())
	{
		return $this->db->where('id', $data["id"])
			->update("dbt_affiliation", $data);
	}


}