<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cryptocoin_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('dbt_cryptocoin', $data);
	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('dbt_cryptocoin')
			->order_by('id', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function single($id = null)
	{
		return $this->db->select('*')
			->from('dbt_cryptocoin')
			->where('id', $id)
			->get()
			->row();
	}

	public function update($data = array())
	{
		return $this->db->where('cid', $data["cid"])
			->update("dbt_cryptocoin", $data);
	}



	/*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
	var $table = 'dbt_cryptocoin';
	var $column_order = array(null, 'cid', 'symbol', 'coin_name', 'full_name', 'algorithm', 'rank', 'show_home', 'coin_position'); //set column field database for datatable orderable
	var $column_search = array('cid', 'symbol', 'coin_name', 'full_name', 'algorithm', 'rank', 'show_home', 'coin_position'); //set column field database for datatable searchable 

	var $order = array('rank' => 'asc'); // default order 

	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
			
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


}
