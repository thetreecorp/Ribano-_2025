<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_lib
{
	protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

        $role_id = $this->CI->session->userdata('role_id');

        $globaldata = array();

        if($role_id!=0){

        	$globaldata['admin_role']		= $this->CI->db->select('*')
										        ->from('dbt_role_permission')
										        ->where('role_id',$role_id)
										        ->get()
										        ->result();
        }

        $globaldata['backend_main_menu'] 	= $this->CI->db->select('*')
										        ->from('dbt_main_menu')
										        ->order_by('short','ASC')
										        ->get()
										        ->result();

		$globaldata['backend_sub_menu'] 	= $this->CI->db->select('*')
										        ->from('dbt_sub_menu')
										        ->get()
										        ->result();

        $globaldata['settings']  			= $this->CI->db->select("*")
										        ->get('setting')
										        ->row();

		$globaldata['help_notify']  		= $this->CI->db->select('id')
												->from('dbt_messenger')
												->where('reciver_id','admin')
												->where('status',1)
												->get()
												->num_rows();

        $this->CI->load->vars($globaldata);
    }
}