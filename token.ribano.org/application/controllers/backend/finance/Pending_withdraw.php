<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pending_withdraw extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
        
 		$this->load->model(array(
 			'backend/withdraw/withdraw_model',
            'common_model',
 		));
 		
 		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
 		
		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

        $globdata['coininfo'] = $this->common_model->get_coin_info();
        $this->load->vars($globdata);
 	}

	public function index()
	{
		$data['title'] = display('pending_withdraw');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(2);
        $menulink         = $this->common_model->getMenuLink(2);
        #-------------------------------#
        #
        #pagination starts
        #
        $config["base_url"] = base_url('backend/finance/pending_withdraw/index');
        $config["total_rows"] = $this->db->get_where('dbt_withdraw', array('status'=>2))->num_rows();
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
        $data['withdraw'] = $this->db->select('*')->from('dbt_withdraw')
        ->where('status',2)
        ->limit($config["per_page"], $page)
        ->get()
        ->result();
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #

		$data['content'] = $this->load->view("backend/finance/pending_withdraw", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	
	}

}