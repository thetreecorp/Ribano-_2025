<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('web_slider', $data);
	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('web_slider')
			->order_by('slider_h1_en', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function single($id = null)
	{
		return $this->db->select('*')
			->from('web_slider')
			->where('id', $id)
			->get()
			->row();
	}

	public function all()
	{
		return $this->db->select('*')
			->from('web_slider')
			->get()
			->result();
	}

	public function update($data = array())
	{
		return $this->db->where('id', $data["id"])
			->update("web_slider", $data);
	}

	public function delete($id = null)
	{
		return $this->db->where('id', $id)
			->delete("web_slider");
	}
}
