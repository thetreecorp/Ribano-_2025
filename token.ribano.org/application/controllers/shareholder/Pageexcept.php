<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pageexcept extends CI_Controller {
 	
 	public function __construct()
 	{
    	parent::__construct();
    	if (!$this->session->userdata('isLogIn')) 
            redirect('login');

            if (!$this->session->userdata('user_id')) 
            redirect('login');
 	}

	public function index()
	{
		$data['title']	 = display('page_exception');
		$data['content'] = $this->load->view("shareholder/pages/pageexcept", $data, true);
		$this->load->view("shareholder/layout/main_wrapper", $data);
	}

}