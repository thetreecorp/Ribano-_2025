<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('dbt_currency', $data);
	}
	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('dbt_currency')
			->order_by('rank', 'asc')
			->limit($limit, $offset)
			->get()
			->result();
	}
	public function single($id = null)
	{
		return $this->db->select('*')
			->from('dbt_currency')
			->where('id', $id)
			->get()
			->row();
	}
	public function all()
	{
		return $this->db->select('*')
			->from('dbt_currency')
			->get()
			->result();
	}
	public function update($data = array())
	{
		return $this->db->where('id', $data["id"])
			->update("dbt_currency", $data);
	}
	public function delete($id = null)
	{
		return $this->db->where('id', $id)
			->delete("dbt_currency");
	}

	public function updateCurency($data = array())
	{
		return $this->db->where('id', $data["id"])
			->update("dbt_currency", $data);
	}

	public function activeCurrency()
	{
		return $this->db->select('*')
			->from('dbt_currency')
			->where('status', 1)
			->get()
			->result();
	}
	public function findlocalCurrency()
	{
		return $this->db->select('usd_exchange_rate, currency_name, currency_iso_code, currency_symbol, currency_position')
			->from('local_currency')
			->where('currency_id', 1)
			->get()
			->row();
	}


	/*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
	var $table = 'dbt_currency';
	var $column_order = array(null, 'icon', 'name', 'symbol', 'rate', 'algorithm', 'position', 'rank', 'status'); //set column field database for datatable orderable
	var $column_search = array('icon', 'name', 'symbol', 'rate', 'algorithm', 'position', 'rank', 'status'); //set column field database for datatable searchable 

	var $order = array('name' => 'desc'); // default order 

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
