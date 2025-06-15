<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_gateway extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
 		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

 		$this->load->model(array(
 			'backend/payment_gateway/payment_gateway_model',
 			'common_model'
 		));
 		
 	}
 
	public function index()
	{
		$data['title']  = display('payment_gateway');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(32);
 		#-------------------------------#
        #
        #pagination starts
        #
        $config["base_url"] = base_url('backend/setting/payment_gateway/index');
        $config["total_rows"] = $this->db->count_all('payment_gateway');
        $config["per_page"] = 25;
        $config["uri_segment"] = 5;
        $config["last_link"] = "Last"; 
        $config["first_link"] = "First"; 
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';  
        $config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data['payment_gateway'] = $this->payment_gateway_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #    
		$data['content'] = $this->load->view("backend/payment_gateway/list", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}
 
	public function form($id = null)
	{ 
		$data['title']  = display('add_payment_gateway');
		$data_value = "";

		if ($this->input->post('identity',TRUE)=='bitcoin') {

			$this->form_validation->set_rules('status', display('status'),'required|max_length[10]|xss_clean');
			$public_key = serialize(array(
				$this->input->post('key1',TRUE) => $this->input->post('public_key',TRUE),
				$this->input->post('key2',TRUE) => $this->input->post('public_key2',TRUE),
				$this->input->post('key3',TRUE) => $this->input->post('public_key3',TRUE),
				$this->input->post('key4',TRUE) => $this->input->post('public_key4',TRUE),
				$this->input->post('key5',TRUE) => $this->input->post('public_key5',TRUE),
				$this->input->post('key6',TRUE) => $this->input->post('public_key6',TRUE),
				$this->input->post('key7',TRUE) => $this->input->post('public_key7',TRUE),
				$this->input->post('key8',TRUE) => $this->input->post('public_key8',TRUE),
				$this->input->post('key9',TRUE) => $this->input->post('public_key9',TRUE),
				$this->input->post('key10',TRUE) => $this->input->post('public_key10',TRUE),
				$this->input->post('key11',TRUE) => $this->input->post('public_key11',TRUE),
				$this->input->post('key12',TRUE) => $this->input->post('public_key12',TRUE),
				$this->input->post('key13',TRUE) => $this->input->post('public_key13',TRUE)
			));
			$private_key = serialize(array(
				$this->input->post('key1',TRUE) => $this->input->post('private_key',TRUE),
				$this->input->post('key2',TRUE) => $this->input->post('private_key2',TRUE),
				$this->input->post('key3',TRUE) => $this->input->post('private_key3',TRUE),
				$this->input->post('key4',TRUE) => $this->input->post('private_key4',TRUE),
				$this->input->post('key5',TRUE) => $this->input->post('private_key5',TRUE),
				$this->input->post('key6',TRUE) => $this->input->post('private_key6',TRUE),
				$this->input->post('key7',TRUE) => $this->input->post('private_key7',TRUE),
				$this->input->post('key8',TRUE) => $this->input->post('private_key8',TRUE),
				$this->input->post('key9',TRUE) => $this->input->post('private_key9',TRUE),
				$this->input->post('key10',TRUE) => $this->input->post('private_key10',TRUE),
				$this->input->post('key11',TRUE) => $this->input->post('private_key11',TRUE),
				$this->input->post('key12',TRUE) => $this->input->post('private_key12',TRUE),
				$this->input->post('key13',TRUE) => $this->input->post('private_key13',TRUE)
			));


		}elseif($this->input->post('identity',TRUE)=='coinpayment'){

			$this->form_validation->set_rules('public_key', display('public_key'),'required|max_length[1000]|xss_clean');
			$this->form_validation->set_rules('private_key', display('private_key'),'required|max_length[1000]|xss_clean');
	        $this->form_validation->set_rules('mercent_id', display('mercent_id'), 'required|trim|xss_clean');
	        $this->form_validation->set_rules('ipn_secret', display('ipn_secret'), 'required|trim|xss_clean');
	        $this->form_validation->set_rules('debug_email', display('debug_email'),'required|trim|xss_clean');
	        $this->form_validation->set_rules('coinpayment_wtdraw', display('withdraw'),'required|trim|xss_clean');

            $public_key 		= $this->input->post('public_key',TRUE);
			$private_key 		= $this->input->post('private_key',TRUE);
            $mercent_id    		= $this->input->post('mercent_id',TRUE);
            $ipn_secret     	= $this->input->post('ipn_secret',TRUE);
            $debug_email 		= $this->input->post('debug_email',TRUE);
            $coinpayment_wtdraw = $this->input->post('coinpayment_wtdraw',TRUE);
            
            if($this->input->post('debuging_active',TRUE)){
            	$debuging_active = 1;
            }
            else{
            	$debuging_active = 0;
            }

            $post_data = array(

            	'marcent_id'		=>$mercent_id,
            	'ipn_secret'		=>$ipn_secret,
            	'debug_email'		=>$debug_email,
            	'debuging_active'	=>$debuging_active,
            	'withdraw'			=>$coinpayment_wtdraw

            );

            $data_value = json_encode($post_data);


		}else{
			$this->form_validation->set_rules('public_key', display('public_key'),'required|max_length[1000]|xss_clean');
			$this->form_validation->set_rules('private_key', display('private_key'),'required|max_length[1000]|xss_clean');

			$public_key = $this->input->post('public_key',TRUE);
			$private_key = $this->input->post('private_key',TRUE);

		}
		





		$data['payment_gateway']   = (object)$userdata = array(
			'id'      		=> $this->input->post('id',TRUE),
			'agent'   		=> $this->input->post('agent',TRUE),
			'public_key'   	=> $public_key,
			'private_key' 	=> $private_key,
			'secret_key' 	=> $this->input->post('secret_key',TRUE),
			'data' 			=> $data_value,
			'status' 		=> $this->input->post('status',TRUE)
		);

		/*-----------------------------------*/
		if ($this->form_validation->run()) 
		{

			if ($this->payment_gateway_model->update($userdata)) {
				$this->session->set_flashdata('message', display('update_successfully'));
			} else {
				$this->session->set_flashdata('exception', display('please_try_again'));
			}
			redirect("backend/setting/payment_gateway/form/$id");
		} 
		else
		{
			if(!empty($id)) {
				$data['title'] = display('setup_payment_gateway');
				$data['payment_gateway']   = $this->payment_gateway_model->single($id);
			}			
		}
		$data['content'] = $this->load->view("backend/payment_gateway/form", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}


}
