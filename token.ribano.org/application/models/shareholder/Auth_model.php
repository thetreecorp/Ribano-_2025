<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{


	public function checkUser($data = array())
	{
		return $this->db->select("*")
			->from('dbt_user')
			->group_start()
			->where('email', $data['email'])
			->or_where('username', $data['email'])
			->group_end()
			->where('password', $data['password'])
			->get();
	}

	public function last_login($id = null)
	{
		return $this->db->set('last_login', date('Y-m-d H:i:s'))
			->set('ip_address', $this->input->ip_address())
			->where('id', $this->session->userdata('id'))
			->update('admin');
	}

	public function last_logout($id = null)
	{
		return $this->db->set('last_logout', date('Y-m-d H:i:s'))
			->where('id', $this->session->userdata('id'))
			->update('admin');
	}
}