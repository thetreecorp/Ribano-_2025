<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sto_setup extends CI_Controller {
	
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
		$data['title']  = display('sto_setup');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(20);
		$this->form_validation->set_rules('sto_name',display('sto_name'),'required|trim|xss_clean');
		$this->form_validation->set_rules('sto_symbol',display('sto_symbol'),'required|trim|xss_clean');
		$this->form_validation->set_rules('pair_with',display('pair_with'),'required|trim|xss_clean');


		$data['sto_setup'] = $this->db->select('*')->from('dbt_sto_setup')->get()->row();
		$data['currency'] 	= $this->db->select('*')->from('dbt_currency')->where('status', 1)->get()->result();

		$data['check_system_run'] = $this->db->select('*')->from('dbt_balance')->get()->num_rows(); 
		

		if($this->form_validation->run()){


			if ($data['sto_setup']->create_wallet==0) {			
				//Generate Wallet
	        	$stowallet = md5(hash('sha256', date('Y-m-d H:i:s').microtime().mt_rand(0, 9999999).@$this->input->post('sto_name',TRUE).@$this->input->post('sto_symbol',TRUE)));
	        	$create_wallet = 1;

	        	$data = array(
					'name' 		=>$this->input->post('sto_name',TRUE),
					'symbol' 	=>$this->input->post('sto_symbol',TRUE),
					'pair_with' =>$this->input->post('pair_with',TRUE),
					'wallet'    => $stowallet,
					'create_wallet'    => $create_wallet
				);
			}
			else{
				$data = array(
					'name' 		=>$this->input->post('sto_name',TRUE),
					'symbol' 	=>$this->input->post('sto_symbol',TRUE),
					'pair_with' =>$this->input->post('pair_with',TRUE),
				);
			}
		
			
			$this->db->update("dbt_sto_setup", $data);
			$this->session->set_flashdata("message",display('setup_successfully'));
			redirect("backend/sto_settings/sto_setup");

		}		


		$data['content'] 	= $this->load->view("backend/sto_setup/form", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}


}