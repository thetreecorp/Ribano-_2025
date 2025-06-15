<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CI_Model {

	public function checkExistsDoc($data = array())
	{
		return $this->db->select('id')
			->from('dbt_documents')
			->where($data)
			->get();
	}

	public function getDocuments($data="")
	{
		return $this->db->select('*')
			->from('dbt_documents')
			->order_by('year','DESC')
			->where('level',$data)
			->get()
			->result();
	}

	public function addDocuments($data = array())
	{
		$this->db->insert('dbt_documents',$data);
	}

	public function deleteDocuments($id="")
	{
		$this->db->delete('dbt_documents',array('id'=>$id));
	}


}