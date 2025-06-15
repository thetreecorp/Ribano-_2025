<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('web_category', $data);

	}

	public function read($limit, $offset)
	{
		return $this->db->select("web_cat.*,web_cat2.slug as parent_name")
					->from('web_category web_cat')
					->order_by('web_cat.position_serial', 'asc')
					->join('web_category web_cat2','web_cat.parent_id = web_cat2.cat_id','left')
					->limit($limit, $offset)
					->get()
					->result();
	}

	public function getParentId()
	{
		return $this->db->select('*')->from('web_category')->where('parent_id',0)->get()->result();
	}

	public function single($cat_id = null)
	{
		return $this->db->select('*')
			->from('web_category')
			->where('cat_id', $cat_id)
			->get()
			->row();
	}

	public function all()
	{
		return $this->db->select('*')
			->from('web_category')
			->order_by('position_serial','asc')
			->get()
			->result();
	}

	public function update($data = array())
	{
		return $this->db->where('cat_id', $data["cat_id"])
			->update("web_category", $data);
	}

	public function delete($cat_id = null)
	{
		return $this->db->where('cat_id', $cat_id)
			->delete("web_category");
	}
	
}
