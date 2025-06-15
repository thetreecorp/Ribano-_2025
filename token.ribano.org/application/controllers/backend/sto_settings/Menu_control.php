<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Menu_control extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('isAdmin')) 
        	redirect('logout');

		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
		redirect('admin');
		$this->load->model('common_model');
	}

	public function index()
	{
		$data['title']	 	= display('menu_control');
		$data['userrole'] 	= $this->common_model->getMenuSingelRoleInfo(23);
		$data['control'] 	= $this->db->select('*')->from('dbt_menu_controller')->get()->row();
		$data['content'] = $this->load->view("backend/menu_control/menu_control", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	public function save()
	{
		$isto 		= $this->input->post('isto',TRUE)?1:0;
		$exchange 	= $this->input->post('exchange',TRUE)?1:0;
		$package 	= $this->input->post('package',TRUE)?1:0;

		$this->db->set(array('isto'=>$isto,'exchange'=>$exchange,'package'=>$package))->update('dbt_menu_controller');
		redirect(base_url('backend/sto_settings/menu_control'));
	}

}