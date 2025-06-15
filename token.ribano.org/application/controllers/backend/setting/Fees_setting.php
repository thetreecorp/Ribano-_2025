<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fees_setting extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

		if (!$this->session->userdata('isLogIn') 
			&& !$this->session->userdata('isAdmin')
		) 
		redirect('admin'); 
		
		$this->load->model(array(
			'backend/dashboard/setting_model',
			'common_model'
		));
		
	}

	public function index()
	{
		$this->load->model(array('backend/coinpair_model'));

		$data['title'] = display('fees_setting');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(27);
		$data['stoinfo'] = $this->db->select('pair_with')->from('dbt_sto_setup')->get()->row();
		$data['fees_data'] = $this->db->select('*')->from('dbt_fees')->get()->result();


		$data['content'] = $this->load->view('backend/dashboard/fees_setting', $data, true);
		$this->load->view('backend/layout/main_wrapper', $data);
	}

	public function fees_setting_save()
	{
		$fees = $this->input->post('fees');
		if($fees<=0){
			$this->session->set_flashdata('exception', display('invalid_amount'));
            redirect('backend/setting/fees_setting');
		}
		
		$check = $this->db->select('*')->from('dbt_fees')->where('level',$this->input->post('level'))->get()->num_rows();
		if($check>0){
			$this->session->set_flashdata('exception','This Level Already Exist!');
			redirect('backend/setting/fees_setting');
		}else{
			$fees = array(
				'level'=>$this->input->post('level'),
				'fees'=>$this->input->post('fees'),
			);
			$this->db->insert('dbt_fees',$fees);
			$this->session->set_flashdata('message',display('fees_setting_successfully'));
			redirect('backend/setting/fees_setting');
		}
		
	}  

	public function delete_fees_setting($id=NULL)
	{

		if ($this->db->where('id',$id)->delete('dbt_fees')) {
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('backend/setting/fees_setting');
	}

}