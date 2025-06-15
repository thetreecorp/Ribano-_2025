<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchange_history extends CI_Controller {
    
        public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

        if (!$this->session->userdata('isLogin') 
            && !$this->session->userdata('isAdmin'))
            redirect('admin');

        $this->load->model(array(
            'backend/exchange/exchange_model'

        ));
    }

    public function index()
    {
        $data['title'] = display('exchange_history');
        $config["base_url"] = base_url('backend/exchange/exchange_history/index');
        $config["total_rows"] = $this->db->count_all('dbt_exchange');
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
        $data['trade_history'] = $this->exchange_model->userSingelExchnageHistory($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #    
        $data['content'] = $this->load->view("backend/exchange/exchange_history", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);

    }

}
