<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('dbt_user', $data);
	}

	public function read($limit, $offset)
	{
		return $this->db->select("
				dbt_user.*, 
				CONCAT_WS(' ', first_name, last_name) AS fullname 
			")
			->from('dbt_user')
			->order_by('id', 'desc')
			->limit($limit, $offset)
			->get()
			->result();
	}

	public function single($id = null)
	{
		return $this->db->select('*')
			->from('dbt_user')
			->where('id', $id)
			->get()
			->row();
	}

	public function getUserId($id = null)
	{
		$data = $this->db->select('*')
				->from('dbt_user')
				->where('id', $id)
				->get()
				->row();

		return $data->user_id;
	}

	public function singleUserVerifyDoc($user_id = null)
	{
		return $this->db->select('*')
			->from('dbt_user user')
			->join('dbt_user_verify_doc userdoc', 'userdoc.user_id=user.user_id', 'left')
			->where('userdoc.user_id', $user_id)
			->get()
			->row();
	}

	public function update($data = array())
	{
		return $this->db->where('user_id', $data["user_id"])
			->update("dbt_user", $data);
	}

	public function delete($user_id = null)
	{
		return $this->db->where('user_id', $user_id)
			->delete("dbt_user");
	}

	public function dropdown()
	{
		$data = $this->db->select("user_id, CONCAT_WS(' ', first_name, last_name) AS fullname")
			->from("dbt_user")
			->where('status', 1)
			->get()
			->result();
		$list[''] = display('select_option');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->id] = $value->fullname;
			return $list;
		} else {
			return false; 
		}
	}

	/*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
	var $table = 'dbt_user';
	var $column_order = array(null, 'user_id','first_name','last_name','username','email','phone','referral_id','language','country','city','address','ip'); //set column field database for datatable orderable
	var $column_search = array('user_id','first_name','last_name','username','email','phone','referral_id','language','country','city','address','ip'); //set column field database for datatable searchable 

	var $order = array('id' => 'asc'); // default order 

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

	public function checkUserAllBalance($user_id = null)
	{
		return $this->db->select('*')
			->from('dbt_balance balance')
			->join('dbt_cryptocoin coin', 'coin.symbol = balance.currency_symbol', 'left')
			->where('balance.user_id', $user_id)
			->get()
			->result();

	}

	public function all_transection($user_id = null)
	{
		return $this->db->select('*')
		->from('dbt_balance_log')
		->where('user_id', $user_id)
		->order_by('log_id','DESC')
		->get()
		->result();
	}

	public function all_earnings($user_id = null)
	{
		return $this->db->select('*')
		->from('earnings')
		->where('user_id', $user_id)
		->order_by('earning_id','DESC')
		->get()
		->result();
	}
 
	public function singleByUserId($user_id = null)
	{
		return $this->db->select('*')
			->from('dbt_user')
			->where('user_id', $user_id)
			->get()
			->row();
	}

}
