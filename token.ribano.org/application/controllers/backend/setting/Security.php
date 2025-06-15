<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends CI_Controller {

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
			'backend/dashboard/security_model',
			'common_model'
        ));

	}

	public function index()
	{
		$data['title']	  = display('security_modules');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(26);

		$data['security'] = $this->db->select('*')->from('dbt_security')->get()->result();
		$data['url'] 	  = "http://".$_SERVER["HTTP_HOST"].str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);

		$this->form_validation->set_rules('try_duration',display('try_duration'),'required|trim|xss_clean');
		$this->form_validation->set_rules('wrong_try',display('wrong_try'),'required|trim|xss_clean');
		$this->form_validation->set_rules('ip_block',display('ip_block'),'required|trim|xss_clean');
		$this->form_validation->set_rules('site_key',display('site_key'),'required|trim|xss_clean');
		$this->form_validation->set_rules('secret_key',display('secret_key'),'required|trim|xss_clean');

		if($this->form_validation->run()){

			$url_status 	= $this->input->post('url_status',TRUE)==1?'https':'http';
			$url = $url_status."://".$_SERVER["HTTP_HOST"].str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
			$url_data = json_encode(array('url'=>$url));
			$this->db->set('status',$this->input->post('url_status',TRUE)==1?1:0)->set('data',$url_data)->where('keyword','url')->update('dbt_security');

			$try_duration 	= $this->input->post('try_duration',TRUE);
			$wrong_try 		= $this->input->post('wrong_try',TRUE);
			$ip_block 		= $this->input->post('ip_block',TRUE);
			$login_status	= $this->input->post('login_status',TRUE)==1?1:0;
			$login_data = array(

				'duration'	=> $try_duration,
				'wrong_try'	=> $wrong_try,
				'ip_block'	=> $ip_block
			);
			$login_data = json_encode($login_data);
			$this->db->set('status',$login_status)->set('data',$login_data)->where('keyword','login')->update('dbt_security');

			$cookie_secure 	= $this->input->post('cookie_secure',TRUE)==1?1:0;
			$cookie_http 	= $this->input->post('cookie_http',TRUE)==1?1:0;
			$cookie_secure_data = array(

				'cookie_secure' => $cookie_secure,
				'cookie_http' 	=> $cookie_http
			);
			$cookie_secure_data = json_encode($cookie_secure_data);
			$this->db->set('data',$cookie_secure_data)->where('keyword','https')->update('dbt_security');

			$xss_filter 	 = $this->input->post('xss_filter',TRUE)==1?1:0;
			$this->db->set('status',$xss_filter)->where('keyword','xss_filter')->update('dbt_security');

			$csrf_token_alow = $this->input->post('csrf_token_alow',TRUE)==1?1:0;
			$this->db->set('status',$csrf_token_alow)->where('keyword','csrf_token')->update('dbt_security');

			$site_key 		 = $this->input->post('site_key',TRUE);
			$secret_key 	 = $this->input->post('secret_key',TRUE);
			$capture_status  = $this->input->post('capture_status',TRUE);
			$capture_data = array(

				'site_key'	=>$site_key,
				'secret_key'=>$secret_key,
			);
			$capture_data = json_encode($capture_data);
			$this->db->set('status',$capture_status)->set('data',$capture_data)->where('keyword','capture')->update('dbt_security');

			$this->session->set_flashdata('message',display('update_successfully'));
			redirect(base_url('backend/setting/security'));

		}

		$data['content'] = $this->load->view('backend/dashboard/security',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function block_list()
	{
		$data['title']  = display('blocklist');
 		
 		/******************************
        * Pagination Start
        ******************************/
        $config["base_url"] = base_url('backend/setting/security/block_list');
        $config["total_rows"] = $this->db->count_all('dbt_blocklist');
        $config["per_page"] = 50;
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
        $data['blocklist'] = $this->security_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        /******************************
        * Pagination ends
        ******************************/

		$data['content'] = $this->load->view("backend/dashboard/blocklist", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	public function delete_blocklist($id=''){

		$this->security_model->delete($id);
		$this->session->set_flashdata('message',display('update_successfully'));
		redirect(base_url('backend/setting/security/block_list'));

	}

}