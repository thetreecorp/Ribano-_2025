<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_setup extends CI_Controller {

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
		$data['title'] = display('transaction_setup');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(28);
		$data['transaction_setup'] = $this->db->select('*')->from('dbt_transaction_setup')->get()->result();
		$data['content'] = $this->load->view('backend/dashboard/transaction_setup',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function transaction_setup_save()
	{
		$coininfo 	= $this->db->select('*')->from('dbt_sto_setup')->get()->row();
		$check 		= $this->db->select('*')->from('dbt_transaction_setup')->where('trntype', $this->input->post('trntype',TRUE))->where('acctype',$this->input->post('acctype',TRUE))->get()->num_rows();

		if($check>0){
			$this->session->set_flashdata('exception', display('this_level_already_exist'));
			redirect('backend/setting/transaction_setup');

		}else{
			$fees = array(
				'trntype'=>$this->input->post('trntype',TRUE),
				'acctype'=>$this->input->post('acctype',TRUE),
				'lower'=>0,
				'upper'=>$this->input->post('upper',TRUE),
				'duration'=>7,
				'status'=>1
			);

			$this->db->insert('dbt_transaction_setup',$fees);
			$this->session->set_flashdata('message',display('save_successfully'));
			redirect('backend/setting/transaction_setup');

		}
		
	}

	public function delete_transaction_setup($id=NULL)
	{

		if ($this->db->where('id',$id)->delete('dbt_transaction_setup')) {
			$this->session->set_flashdata('message', display('delete_successfully'));

		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));

		}
		redirect('backend/setting/transaction_setup');

	}




}