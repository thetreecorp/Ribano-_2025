<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pending_user_verification_list extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'backend/user/user_model',
            'shareholder/transections_model',
            'common_model'
        ));
        
        if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
        
        if (!$this->session->userdata('isLogin') 
            && !$this->session->userdata('isAdmin'))
            redirect('admin');
    }

    public function index()
    {
        $data['title']  = display('pending_user_list');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(11);
        
        /******************************
        * Pagination Start
        ******************************/
        $config["base_url"] = base_url('backend/shareholders/pending_user_verification_list');
        $config["total_rows"] = $this->db->get_where('dbt_user', array('verified'=>3))->num_rows();
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

        $data['users'] = $this->db->select('*')->from('dbt_user')
                ->where('verified', 3)
                ->limit($config["per_page"], $page)
                ->get()
                ->result();

        $data["links"] = $this->pagination->create_links();
        /******************************
        * Pagination ends
        ******************************/

        $data['content'] = $this->load->view("backend/shareholders/pending_user_verification_list", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);

    }


}
