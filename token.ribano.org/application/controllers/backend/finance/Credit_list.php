<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
        if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
        
        if (!$this->session->userdata('isLogIn')) 
        redirect('admin'); 
    
		$this->load->model(array(
            'backend/dashboard/message_model' 
		));
		
		$globdata['coininfo'] = $this->db->select('*')->from('dbt_sto_setup')->get()->row();
		$this->load->vars($globdata);

	}
 
    public function index()
    {
        $data['title']  =  display('credit_list');

        #
        #pagination starts
        #
        $config["base_url"]       = base_url('backend/finance/credit_list/index'); 
        $config["total_rows"]     = $this->db->get_where('dbt_deposit', array('method' =>'ADMIN', 'status'=>1))->num_rows(); 
        $config["per_page"]       = 25;
        $config["uri_segment"]    = 5; 
        $config["num_links"]      = 5;  
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']  = "<ul class='pagination col-xs pull-right m-0'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open']   = '<li>';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']  = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']  = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open']  = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']  = "<li>";
        $config['last_tagl_close'] = "</li>"; 
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $data['credit_info'] = $this->db->select('*')->from('dbt_deposit')
        ->where('method','ADMIN')
        ->where('status',1)
        ->limit($config["per_page"], $page)
        ->get()
        ->result(); 

         $data["links"] = $this->pagination->create_links(); 
        #
        #pagination ends
        #  
        $data["content"] = $this->load->view("backend/finance/credit_list", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);
    }
	
}
