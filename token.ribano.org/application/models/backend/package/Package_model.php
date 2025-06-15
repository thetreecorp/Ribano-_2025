<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('package', $data);
	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('package')
			->order_by('package_name', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function single($package_id = null)
	{
		return $this->db->select('*')
			->from('package')
			->where('package_id', $package_id)
			->get()
			->row();
	}

	public function update($data = array(),$package_id = null)
	{
		return $this->db->where('package_id', $package_id)
			->update("package", $data);
	}

	public function delete($package_id = null)
	{
		return $this->db->where('package_id', $package_id)
			->delete("package");
	}

}
